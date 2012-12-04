<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Manager implements Downloader_Observer
{

	const OK = 0;
	const REDOWNLOAD = 1;
	const IGNORE = 2;

	/**
	 * @var Download_Manager
	 */
	protected static $default_instance;

	/**
	 * @return Download_Manager
	 */
	final public static function get_default()
	{
		if (is_null(self::$default_instance))
		{
			self::$default_instance = new self;
		}
		return self::$default_instance;
	}

	/**
	 * Get default download manager
	 * @param Download_Manager $manager
	 */
	final public static function set_default(Download_Manager $manager)
	{
		self::$default_instance = $manager;
	}

	static protected function log($type, $message)
	{
		Logger::add($type, $message, __CLASS__);
	}


	/**
	 * @var Downloader
	 */
	protected $downloader;

	/**
	 * Pending tasks queue
	 * @var array
	 */
	protected $queue = array();

	/**
	 * Maximal number simultaneous downloads
	 * @var integer
	 */
	protected $max_sessions = 10;

	protected $redownload_limit = 50;
	protected $addons = array();

	public function  __construct()
	{
		$this->downloader = Downloader::instance();
		$this->downloader->add_observer($this);
		$this->max_sessions = (int) Kohana::$config->load('downloader')->max_sessions;
		$this->redownload_limit = (int) Kohana::$config->load('downloader')->redownload_limit;
	}

	public function add_addon(Download_Manager_Addon $addon)
	{
		$this->addons[] = $addon;
		return $this;
	}

	public function add_task(Download_Task $task)
	{
		if ($task->get_times_downloaded() > $this->redownload_limit)
		{
			self::log(Logger::ERR, "Download exceeded redownload limit: '{$task->get_url()}'");
			return;
		}

		if ($this->downloader->sessions_count() < $this->max_sessions)
		{
			$this->start_task($task);
		}
		else
		{
			self::log(Logger::MSG, "Download queued: '{$task->get_url()}'");
			$this->queue[] = $task;
		}
	}


	protected function start_task($task)
	{
		$task->set_timeout((int) Kohana::$config->load('downloader')->timeout);

		$addons_reverse_order = array_reverse($this->addons);
		foreach ($addons_reverse_order as $addon)
		{
			$addon->before_download($task);
		}

		self::log(Logger::MSG, "Download started: '{$task->get_url()}'");
		$this->downloader->add($task);
	}

	public function on_task_done(Download_Task $task)
	{
		self::log(Logger::MSG, "Download finished: '{$task->get_url()}'");


		$result = self::OK;
		foreach ($this->addons as $addon)
		{
			$result = $addon->after_download($task);
			if ($result !== self::OK)
				break;
		}

		if ($result == self::OK)
		{
			if ($task->get_result()->get_error_code() !== CURLE_OK)
			{
				self::log(Logger::ERR, "Network error: '{$task->get_result()->error()}' URL: '{$task->get_url()}'");
			}
			else
			{
				$handler = $task->get_handler();
				if ( ! is_null($handler))
				{
					$handler->on_download_complete($task->get_result());
				}
			}
		}
		elseif ($result == self::REDOWNLOAD)
		{
			$this->add_task($task);
		}

		while ( ! empty($this->queue) AND $this->downloader->sessions_count() < $this->max_sessions)
		{
			$this->start_task(array_shift($this->queue));
		}

//		while ( ! empty($this->queue) AND ($this->downloader->sessions_count() < $this->max_sessions))
//		{
//			$max_priority = max(array_keys($this->queue));
//			if (empty($this->queue[$max_priority]))
//			{
//				unset($this->queue[$max_priority]);
//				continue;
//			}
//
//			$task = array_shift($this->queue[$max_priority]);
//			$this->start_task($task);
//		}
	}

	/**
	 * Get maximal number of CURL multi sessions
	 * @return integer Maximal number of CURL multi sessions
	 */
	public function get_max_sessions()
	{
		return $this->max_sessions;
	}

	/**
	 * Set maximal number of CURL multi sessions
	 * @param integer $max_sessions Maximal number of CURL multi sessions
	 */
	public function set_max_sessions($max_sessions)
	{
		$this->max_sessions = (int)$max_sessions;
	}
}
