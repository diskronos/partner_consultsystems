<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Money_Payment_Client extends Controller_Crud
{
	protected $_model = 'money_payment_client';
	protected $_group_actions = array(
		'revert' => array(
			'handler' => 'revert_routine',
			'title' => 'Откатить',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
		),
		'delete' => array(
			'handler' => 'delete_routine',
			'title' => 'Удалить',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
		)
	);
	public function action_revert()
	{
		$item = $this->get_item();
		$this->revert_routine($item);
		$this->redirect($this->get_index_route());
	}

	protected function revert_routine(ORM $item)
	{
		Webconsult_Transaction::money_back($item->id);
	}
	public function action_index() {
		parent::action_index();
//		Navigation::instance()->actions()->clear();
	}
}