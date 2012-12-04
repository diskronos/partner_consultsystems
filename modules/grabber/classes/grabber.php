<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Grabber implements Grabber_Task_Observer
{
	/**
	 * @var Grabber
	 */
	protected static $instance;

	/**
	 * @return Grabber
	 */
	final public static function instance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	static protected function log($type, $message)
	{
		Logger::add($type, $message, __CLASS__);
	}

	protected $max_tasks = 10;
	protected $tasks_count_total  = 0;
	protected $tasks_count_by_type  = array();
	protected $limits = array();
	protected $queue = array();

	protected function  __construct()
	{
		$this->max_tasks = (int) Kohana::$config->load('grabber')->max_tasks;
		$this->limits = Kohana::$config->load('grabber')->limits;
	}

	public function add_task(Grabber_Task $task)
	{
		if ( ! isset($this->tasks_count_by_type[$task->get_type()]))
		{
			$this->tasks_count_by_type[$task->get_type()] = 0;
		}

		if ($this->tasks_count_total < $this->max_tasks AND $this->can_start_task($task))
		{
			$this->start_task($task);
		}
		else
		{
			self::log(Logger::MSG, "Task '{$task->get_description()}' queued");
			$this->queue[$task->get_priority()][] = $task;
			krsort($this->queue);
		}
	}

	protected function check_queue()
	{
		foreach ($this->queue as $priority => $tasks)
		{
			foreach ($this->queue[$priority] as $key => $task)
			{
				if ( ! ($this->tasks_count_total < $this->max_tasks))
					break;

				if ( ! $this->can_start_task($task))
					continue;

				// it works
				unset($this->queue[$priority][$key]);
				$this->start_task($task);
			}

			if (empty($this->queue[$priority]))
			{
				unset($this->queue[$priority]);
			}
		}

		if (empty($this->queue))
		{
			Grabber_Checkpoint::restore();
		}
	}

	protected function can_start_task(Grabber_Task $task)
	{
		if (isset($this->limits[$task->get_type()])
			AND isset($this->tasks_count_by_type[$task->get_type()])
			AND (
				$task->is_loaded()
				OR $this->tasks_count_by_type[$task->get_type()] >= $this->limits[$task->get_type()]
			))
		{
			return FALSE;
		}

		return TRUE;
	}

	protected function start_task(Grabber_Task $task)
	{
		self::log(Logger::MSG, "Task '{$task->get_description()}' started");
		$this->tasks_count_total++;
		$this->tasks_count_by_type[$task->get_type()]++;
		$task->add_observer($this);
		$task->set_state('IN_PROCESS');
		$task->start();
	}

	public function on_task_complete(Grabber_Task $task)
	{
		self::log(Logger::MSG, "Task '{$task->get_description()}' completed");
		$this->tasks_count_total--;
		$this->tasks_count_by_type[$task->get_type()]--;
		$task->set_state('RUNNING');
		$this->check_queue();
	}
}
