<?php

defined('SYSPATH') or die('No direct script access.');


class Controller_Site_Cabinet_Clients extends Controller_Site_Cabinet 
{
	public function action_index()
	{
		$this->template->clients = $this->_user->clients->find_all();
		$this->set_view('cabinet/clients/index');
	}
	
	public function action_new()
	{
		$this->set_view('cabinet/clients/register_client');
	}
}