<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Manager_Addon_Useragents extends Download_Manager_Addon
{

	protected $user_agents = array();

	public function  __construct()
	{
		$this->user_agents = Kohana::$config->load('downloader')->user_agents;
	}

	public function before_download(Download_Task $task)
	{
		$task->set_user_agent($this->user_agents[array_rand($this->user_agents)]);
	}

}
