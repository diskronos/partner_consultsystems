<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Money_Payout extends Controller_Crud
{
	protected $_model = 'money_payout';
	protected $_group_actions = array(
		'set_paid' => array(
			'handler' => 'set_paid_routine',
			'title' => 'Отметить выплаченными',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
		),
		'unset_paid' => array(
			'handler' => 'unset_paid_routine',
			'title' => 'Снять отметку о выплате',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
		)
	);

	public function action_index() {
		parent::action_index();
		Navigation::instance()->actions()->clear();
	}

	public function get_filter_form(ORM $model) 
	{
		return new Form_Admin_Filter_Payout($model);
	}

	public function before_fetch(ORM $item) 
	{
		return $item->order_by('created_at', 'DESC');
	}
	
	public function action_set_paid()
	{
		$item = $this->get_item();
		$this->set_paid_routine($item);
		$this->redirect($this->get_index_route());
	}

	protected function set_paid_routine(ORM $item)
	{
		$partner = $item->partner;
		$item->status = 'paid';
		$item->commentary = 'Вывод средств с баланса (на ' . $partner->requisites->name .')';
		$item->save();
		Webconsult_Message::send($item->partner_id, 'new_payout_' . $partner->status, $item->message_params);
	}

	public function action_unset_paid()
	{
		$item = $this->get_item();
		$this->unset_paid_routine($item);
		$this->redirect($this->get_index_route());
	}

	protected function unset_paid_routine(ORM $item)
	{
		$item->status = 'pending';
		$item->commentary = '';
		$item->save();
	}
	
}