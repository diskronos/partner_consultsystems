<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Money_Balance extends Controller_Crud
{
	protected $_model = 'money_balance';
	protected $_group_actions = array();

	public function action_index() {
		parent::action_index();
		Navigation::instance()->actions()->clear();
	}
}