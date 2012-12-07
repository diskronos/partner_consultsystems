<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Partner_Group extends Controller_Crud
{
	protected $_group_actions = array();
	protected $_model = 'partner_group';
	
	public function action_create()
	{
		$this->redirect('admin-partner_group:index');
	}
	
	public function action_delete()
	{
		$this->redirect('admin-partner_group:index');
	}
	public function action_edit()
	{
		$this->redirect('admin-partner_group:index');
	}

}