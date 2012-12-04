<?php defined('SYSPATH') or die('No direct script access.');

/**
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Grabber_Checkpoint implements Grabber_Task_Observer
{

	protected static $_model_name = 'grabber_task';

	/**
	 * Create a task and save it to the database
	 *
	 * @param Grabber_Task_Abstract $strategy
	 */
	public static function create(Grabber_Task_Abstract $strategy)
	{
		$db_task = ORM::factory(self::$_model_name);
		$db_task->restore = 1;
		$db_task->strategy = serialize($strategy);
		$db_task->type = get_class($strategy);
		$db_task->state = 'RUNNING';
		$db_task->save();

		return $db_task;
	}

	/**
	 * Restore a task from ORM object
	 *
	 * @param Model_Grabber_Task $db_task
	 * @return Grabber_Checkpoint
	 */
	public static function load(Model_Grabber_Task $db_task)
	{
		if ( ! $db_task->loaded())
			throw new Exception("Could not restore grabber checkpoint: ORM object not loaded");

		$strategy = @unserialize($db_task->strategy);
		if ( ! $strategy instanceof Grabber_Task_Abstract)
			throw new Exception("Could not restore grabber checkpoint: invalid task");

		return new self($db_task, $strategy, NULL);
	}

	/**
	 * Restore all not completed tasks
	 */
	public static function restore_in_process()
	{
		$tasks = ORM::factory(self::$_model_name)
			->where('state', '=', 'IN_PROCESS')
			->where('restore', '=', '1');

		$tasks->state = 'RUNNING';
		$tasks->save_all();
	}

	/**
	 * Restore all saved and scheduled tasks
	 */
	public static function restore()
	{
		$restore_limit = (int) Kohana::$config->load('grabber')->restore_limit;
		$priorities = Kohana::$config->load('grabber')->priorities;
		arsort($priorities);

		$db_tasks = array();
		foreach ($priorities as $type => $priority)
		{
			$new = ORM::factory(self::$_model_name)
					->where('restore', '=', '1')
					->where('state', '=', 'RUNNING')
					->order_by('id', 'asc')
					->limit($restore_limit - count($db_tasks));

			if ($type !== '*')
			{
				$new->where('type', '=', $type);
			}

			$db_tasks = array_merge($db_tasks, $new->find_all()->as_array());

			if (count($db_tasks) >= $restore_limit)
				break;
		}

		foreach ($db_tasks as $db_task)
		{
			if( ! isset(self::$tasks_list[$db_task->id]))
			{
				self::$tasks_list[$db_task->id] = 1;
				self::load($db_task)->start();
			}
		}
	}

	/**
	 * Mark already done tasks as DONE
	 */
	public static function refresh_states()
	{
		$table_name = ORM::factory(self::$_model_name)->table_name();
		$db_running_tasks = DB::query(Database::SELECT,
				"SELECT id, restore, parent_id FROM {$table_name} WHERE `state` = 'RUNNING'")
				->execute();

		// Creating init forest structure
		$tasks = array();
		foreach ($db_running_tasks as $db_task)
		{
			$tasks[$db_task['id']] = array(
					'restore' => $db_task['restore'],
					'parent' => $db_task['parent_id'],
					'running' => FALSE,
			);
		}

		foreach ($tasks as $id => $task)
		{
			if ($task['running'])
				continue;

			if ($task['restore'] == 1)
			{
				// Climb up the tree marking all parents not to be saved
				$current_id = $id;
				while ( ! is_null($current_id) AND ! $tasks[$current_id]['running'])
				{
					$tasks[$current_id]['running'] = TRUE;
					$current_id = $tasks[$current_id]['parent'];
				}
			}
		}

		$ids_to_save = array();
		foreach ($tasks as $id => $task)
		{
			if ( ! $task['running'])
			{
				$ids_to_save[] = $id;
			}
		}

		while ($ids_part = array_splice($ids_to_save, 0, 1000))
		{
			$tasks_to_save = ORM::factory(self::$_model_name)->where('id', 'IN', $ids_part);
			$tasks_to_save->state = 'DONE';
			$tasks_to_save->save_all();
		}
	}

	/**
	 * @var Grabber_Checkpoint
	 */
	protected $parent;

	/**
	 * @var Model_Grabber_Task
	 */
	protected $db_task;

	/**
	 * @var Grabber_Task_Abstract
	 */
	protected $strategy;

	protected static $tasks_list = array();

	protected $children = array();
	protected $completed = FALSE;
	protected $child_tasks_count = 0;


	protected function  __construct(Model_Grabber_Task $db_task, Grabber_Task_Abstract $strategy, Grabber_Checkpoint $parent=NULL)
	{
		$this->grabber = Grabber::instance();
		$this->parent = $parent;
		$this->db_task = $db_task;
		$this->strategy = $strategy;

		if ( ! is_null($parent))
		{
			$parent->children[] = $this;
		}
	}

	public function create_child(Grabber_Task_Abstract $strategy)
	{
		$db_task = ORM::factory(self::$_model_name);
		$db_task->state = 'RUNNING';
		$db_task->strategy = serialize($strategy);
		$db_task->restore = 0;

		return new self($db_task, $strategy, $this);
	}

	public function start()
	{
		$this->start_new_task($this->strategy);
	}

	public function start_new_task(Grabber_Task_Abstract $strategy)
	{
		$this->child_tasks_count++;

		$task = new Grabber_Task($strategy, $this);
		$task->add_observer($this);

		$this->grabber->add_task($task);
	}

	public function on_task_complete(Grabber_Task $task)
	{
		$this->child_tasks_count--;
		if ($this->child_tasks_count <= 0)
		{
			$this->on_complete();
		}
	}

	public function on_complete()
	{
		$this->completed = TRUE;
		if (is_null($this->parent))
		{
			DB::query(NULL, 'START TRANSACTION')->execute();
			try
			{
				$this->check_for_deletion();
				DB::query(NULL, 'COMMIT')->execute();
			}
			catch (Exception $e)
			{
				DB::query(NULL, 'ROLLBACK')->execute();
			}
		}
	}

	protected function check_for_deletion()
	{
		if ($this->completed)
		{
			if(isset(self::$tasks_list[$this->db_task->id]))
			{
				unset(self::$tasks_list[$this->db_task->id]);
			}

			$children = $this->children;
			foreach ($this->children as $child)
			{
				$child->check_for_deletion();
			}
			$this->delete();
		}
		else
		{
			$this->db_task->restore = 1;
			$this->save();
		}
	}

	protected function delete()
	{
		foreach ($this->children as $child)
		{
			$child->parent = NULL;
		}
		$this->children = array();

		$this->db_task->restore = 0;
		$this->save();
	}

	protected function save()
	{
		if ( ! is_null($this->parent))
		{
			if ( ! $this->parent->db_task->loaded())
				throw new Exception("Saving task with not saved parent");
			$this->db_task->parent_id = $this->parent->db_task->id;
			$this->db_task->type = get_class($this->strategy);
		}
		$this->db_task->save();
	}

	public function set_state($state)
	{
		$this->db_task->state = $state;
		$this->db_task->save();
	}

	public function is_loaded()
	{
		return (bool)($this->db_task->state == 'IN_PROCESS');
	}
}
