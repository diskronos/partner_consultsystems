<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Description of observer
 *
 * @author exxy
 */
interface Downloader_Observer
{
	public function on_task_done(Download_Task $task);
}
