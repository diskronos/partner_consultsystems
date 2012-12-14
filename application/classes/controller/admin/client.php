<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Client extends Controller_Crud
{
//	protected $_group_actions = array();
	protected $_model = 'client';
	public function get_filter_form(ORM $model) {
		return new Form_Admin_Filter_Client($model);
	}
	public function action_index() {
		parent::action_index();
	//	Navigation::instance()->actions()->clear();
	}
}