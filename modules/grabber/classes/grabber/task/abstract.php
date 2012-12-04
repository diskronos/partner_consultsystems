<?php defined('SYSPATH') or die('No direct script access.');

/**
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
abstract class Grabber_Task_Abstract
{
	/**
	 * @var Grabber_Task
	 */
	private $master_task;
	
	final public function set_master_task(Grabber_Task $task)
	{
		$this->master_task = $task;
	}

	public function create_subtask(Grabber_Task_Abstract $strategy)
	{
		$this->master_task->new_task($strategy);
	}

	public function create_task(Grabber_Task_Abstract $strategy)
	{
		$this->master_task->new_checkpoint($strategy);
	}

	final public function download(Download_Request $request, Grabber_Callback $callback=NULL, $filename=NULL)
	{
		$this->master_task->download($request, $callback, $filename);
	}

	abstract public function start();

	public function get_description()
	{
		return get_class($this);
	}


	public function on_complete() {}
}
