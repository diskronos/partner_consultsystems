<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet extends Controller_Auth
{
	public function before() 
	{
		parent::before();
		$this->template->set_layout('global/global_cabinet');
	}
	
	public function forward_403() 
	{
	//	$this->redirect('site-index');
	}
}