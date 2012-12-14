<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Additional extends Controller
{
	public function action_site_menu_top()
	{
		$this->set_view('additional/site_menu_top');
	}
	public function action_cabinet_menu_top()
	{
		$this->template->active = arr::get($_GET, 'active', 'statistics');
	}
//	pub
}