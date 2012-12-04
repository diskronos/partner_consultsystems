<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author    Eugene Dounar <e.dounar@smartdesign.by>
 * @since     PHP 5.0
 */

class Downloader
{
	/**
	 * @var Downloader
	 */
	protected static $instance;

	/**
	 * @return Downloader
	 */
	public static function instance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	public static function reset()
	{
		self::$instance = NULL;
	}

	public static function run()
	{
		self::instance()->run_loop();
	}

	/**
	 * cURL multi-handle for all downloads
	 * @var resource
	 */
	protected $multi_handle;

	/**
	 * Is there any active downloads
	 * @var bool
	 */
	protected $active = FALSE;

	/**
	 * Objects observing downloader events
	 * @var array
	 */
	protected $observers = array();

	/**
	 * Current CURL multi sessions.
	 * @var array
	 */
	protected $running_sessions = array();

	protected function  __construct()
	{
		$this->multi_handle = curl_multi_init();
	}

	public function __destruct()
	{
		foreach ($this->running_sessions as $session)
		{
			$this->close_session($session);
		}
		curl_multi_close($this->multi_handle);
	}

	public function add_observer(Downloader_Observer $observer)
	{
		$this->observers[] = $observer;
	}

	/**
	 * Return number of running sessions
	 * @return int
	 */
	public function sessions_count()
	{
		return count($this->running_sessions);
	}

	/**
	 * Add new Download_Task to be downloaded
	 * @param Download_Task $task task object
	 */
	public function add(Download_Task $task)
	{
		$this->active = TRUE;
		$task->init();

		// Init new CURL session
		$ch = curl_init();
		foreach ($task->get_curl_options() as $option => $value)
		{
			curl_setopt($ch, $option, $value);
		}

		curl_multi_add_handle($this->multi_handle, $ch);
		$this->running_sessions[] = array('handle' => $ch, 'task' => $task);
	}

	/**
	 * Wait CURL multi sessions
	 */
	public function run_loop()
	{
		while ($this->active)
		{
			while (($mrc = curl_multi_exec($this->multi_handle, $active))
					== CURLM_CALL_MULTI_PERFORM);
			$this->active = (bool)$active;

			if ($mrc != CURLM_OK)
				throw new Exception('Unknown cURL-mutli error');

			// Blocking execution until something happens
			curl_multi_select($this->multi_handle);

			while ($done = curl_multi_info_read($this->multi_handle))
			{

				// Find session
				foreach ($this->running_sessions as $id => $session)
				{
					if ($session['handle'] === $done['handle'])
					{
						$done_session = $session;
						$session_id = $id;
						break;
					}
				}

				$done_session['task']->load_result(
						curl_getinfo($done['handle']),
						curl_multi_getcontent($done['handle']),
						$done['result']
				);

				$this->close_session($done_session);
				unset($this->running_sessions[$session_id]);

				foreach($this->observers as $observer)
				{
					$observer->on_task_done($done_session['task']);
				}
			}
		}
	}

	/**
	 * Destroy session
	 * @param integer $id A session id from array $this->sessions
	 */
	protected function close_session($session)
	{
		curl_multi_remove_handle($this->multi_handle, $session['handle']);
		curl_close($session['handle']);
	}

	/**
	 * Check CURL extension, etc.
	 */
	public static function check_environment()
	{
		if ( ! extension_loaded('curl'))
		{
			throw new Downloader_Exception('CURL extension not loaded');
		}
	}
}
