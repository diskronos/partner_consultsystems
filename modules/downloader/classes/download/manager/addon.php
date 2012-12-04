<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
abstract class Download_Manager_Addon
{
	public function before_download(Download_Task $task)
	{
		
	}

	/**
	 *
	 * @param Download_Task $task
	 * @return Action to be performed (ignore, redownload, run_callback)
	 */
	public function after_download(Download_Task $task)
	{
		return Download_Manager::OK;
	}
}
