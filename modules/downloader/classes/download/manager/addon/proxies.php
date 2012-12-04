<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Manager_Addon_Proxies extends Download_Manager_Addon
{
	protected static function log($type, $message)
	{
		Logger::add($type, $message, __CLASS__);
	}

	protected $proxies = array();
	protected $proxy_refresh_period = 60;
	protected $last_refresh_time = 0;

	public function  __construct()
	{
		$this->proxy_refresh_period = (int) Kohana::$config->load('downloader')->proxy_refresh_period;
	}


	public function before_download(Download_Task $task)
	{
		$state = $this->refresh_proxies_routine();
		if ($state !== FALSE)
			$task->set_proxy($this->proxies[array_rand($this->proxies)]);
	}

	public function after_download(Download_Task $task)
	{
		$possible_proxy_errors = array(
			CURLE_COULDNT_CONNECT,
			CURLE_OPERATION_TIMEOUTED,
			CURLE_GOT_NOTHING,
			CURLE_PARTIAL_FILE,
		);

		$result = $task->get_result();
		if (in_array($result->get_error_code(), $possible_proxy_errors))
		{
			self::log(Logger::WRN, "Proxy ({$task->get_proxy()}) error: {$task->get_result()->error()}. URL: '{$result->get_info('url')}'. Retrying...");
			return Download_Manager::REDOWNLOAD;
		}
		elseif ($result->get_info('http_code') == 504)
		{
			self::log(Logger::WRN, "Proxy ({$task->get_proxy()}) gateway timeout. URL: '{$result->get_info('url')}'. Retrying...");
			return Download_Manager::REDOWNLOAD;
		}
		elseif ($result->get_info('http_code') == 407)
		{
			self::log(Logger::ERR, "Proxy ({$task->get_proxy()}) requires authorization. URL: '{$result->get_info('url')}'");
			return Download_Manager::IGNORE;
		}

		return Download_Manager::OK;
	}

	protected function refresh_proxies_routine()
	{
		if (time() - $this->last_refresh_time > $this->proxy_refresh_period)
		{
			$db_proxies = ORM::factory('downloader_proxy')
					->where('active', '=', '1')
					->find_all();

			$this->proxies = array();
			foreach ($db_proxies as $db_proxy)
			{
				$this->proxies[$db_proxy->id] = $db_proxy->proxy;
			}

			if (empty($this->proxies))
				return FALSE;

			$this->last_refresh_time = time();
		}
	}

}
