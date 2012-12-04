<?php defined('SYSPATH') or die('No direct script access.');

/**
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Grabber_Task
{
	/**
	 * Number of running downloads for this task
	 * @var integer
	 */
	protected $running_downloads = 0;

	/**
	 * @var Grabber_Task_Abstract
	 */
	protected $strategy;

	/**
	 * @var Grabber_Checkpoint
	 */
	private $checkpoint;

	protected $observers = array();

	/**
	 * @var Download_Manager
	 */
	protected $download_manager;

	public function  __construct(Grabber_Task_Abstract $strategy, Grabber_Checkpoint $checkpoint)
	{
		$this->download_manager = Download_Manager::get_default();
		$this->strategy = $strategy;
		$this->checkpoint = $checkpoint;
	}

	public function add_observer(Grabber_Task_Observer $observer)
	{
		$this->observers[] = $observer;
	}

	public function get_description()
	{
		return $this->strategy->get_description();
	}

	public function get_type()
	{
		return get_class($this->strategy);
	}

	public function get_priority()
	{
		return Arr::get(Kohana::$config->load('grabber')->priorities, $this->get_type(), 0);
	}

	public function download(Download_Request $request, Grabber_Callback $callback=NULL, $filename=NULL)
	{
		$this->running_downloads++;
		$handler = new Download_Callback(array($this, 'on_load'), array($callback));

		$task = new Download_Task($request);
		$task->set_handler($handler);
		$task->set_output($filename);
		$this->download_manager->add_task($task);
	}

	public function on_load(Download_Result $result, Grabber_Callback $callback)
	{
		if ( ! is_null($callback))
		{
			$callback->call($this->strategy, $result);
		}

		$this->running_downloads--;
		$this->check_complete();
	}

	protected function check_complete()
	{
		if ($this->running_downloads <= 0)
		{
			$this->on_complete();
		}
	}

	public function new_task(Grabber_Task_Abstract $strategy)
	{
		$this->checkpoint->start_new_task($strategy);
	}

	public function new_checkpoint(Grabber_Task_Abstract $strategy)
	{
		$this->checkpoint->create_child($strategy)->start();
	}

	public function start()
	{
		$this->strategy->set_master_task($this);
		$this->strategy->start();

		$this->check_complete();
	}

	public function set_state($state)
	{
		$this->checkpoint->set_state($state);
	}

	public function is_loaded()
	{
		return $this->checkpoint->is_loaded();
	}

	public function on_complete()
	{
		$this->strategy->on_complete();
		foreach ($this->observers as $observer)
		{
			$observer->on_task_complete($this);
		}

		$this->strategy = NULL;
		$this->checkpoint = NULL;
		$this->observers = array();
	}
}
