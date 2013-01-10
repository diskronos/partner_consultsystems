<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Money_Payment_Partner extends Controller_Crud
{
	protected $_model = 'money_payment_partner';
	protected $_group_actions = array(
		'revert' => array(
			'handler' => 'revert_routine',
			'title' => 'Откатить',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
		),

		'unhold' => array(
			'handler' => 'unhold_routine',
			'title' => 'Снять с ожидания',
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
		$item->status = 'reverted';
		$item->save();
		Webconsult_Balance::factory($item->partner)->set_new_balance();
	}
	public function action_unhold()
	{
		$item = $this->get_item();
		$this->unhold_routine($item);
		$this->redirect($this->get_index_route());
	}

	protected function unhold_routine(ORM $item)
	{
		$item->status = 'active';
		$item->save();
		Webconsult_Balance::factory($item->partner)->set_new_balance();
	}
	public function action_index() {
		parent::action_index();
		Navigation::instance()->actions()->clear();
	}

	public function before_fetch(ORM $item) 
	{
		return $item->order_by('created_at','desc');
	}

}