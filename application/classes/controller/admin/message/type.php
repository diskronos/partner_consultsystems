<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Message_Type extends Controller_Crud
{
	protected $_group_actions = array();
	protected $_model = 'message_type';
	
	public function action_create()
	{
		$this->redirect('admin-message_type:index');
	}
//	public function action_delete()
//	{
//		$this->redirect('admin-partner_group:index');
//	}
//	public function action_edit()
//	{
//		$this->redirect('admin-partner_group:index');
//	}

}