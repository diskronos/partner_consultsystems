<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Index extends Controller_Site {

	public function action_index()
	{
		$this->set_view('index/index');
		
		//$this->template->set_layout('global');
	}
}