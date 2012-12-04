<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Manager_Debug extends Download_Manager
{
	
	protected $debug_delay_min = 5;
	protected $debug_delay_max = 15;

	/**
	 * Maximal number simultaneous downloads
	 * @var integer
	 */
	protected $max_sessions = 1;

	public function  __construct()
	{
		parent::__construct();
		$this->delay_min = (int) Kohana::$config->load('downloader')->debug_delay_min;
		$this->delay_max = (int) Kohana::$config->load('downloader')->debug_delay_max;
		$this->max_sessions = 1;
	}

	protected function start_task(Download_Task $task)
	{
		sleep(rand($this->debug_delay_min, $this->debug_delay_max));
		parent::start_task($task);
	}
}
