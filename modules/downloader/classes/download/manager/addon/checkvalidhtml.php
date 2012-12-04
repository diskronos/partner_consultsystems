<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Manager_Addon_CheckValidHtml extends Download_Manager_Addon
{
	public function after_download(Download_Task $task)
	{
		$http_code = $task->get_result()->get_info('http_code');
		$url = $task->get_url();

		if ($http_code >= 400)
		{
			Logger::add(Logger::WRN, "Got HTTP code {$http_code}. URL: '{$url}'. Retrying...");

			return Download_Manager::REDOWNLOAD;
		}
		elseif ($task->get_result()->get_contents() == '')
		{
			Logger::add(Logger::WRN, "Got empty content. URL: '{$url}'. Retrying...");

			return Download_Manager::REDOWNLOAD;
		}
		elseif ($task->get_result()->get_error_code() !== CURLE_OK)
		{
			Logger::add(Logger::WRN, "Network error: '{$task->get_result()->error()}' URL: '{$task->get_url()}'");
			return Download_Manager::REDOWNLOAD;
		}

		return Download_Manager::OK;
	}
}
