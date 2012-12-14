<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Money_Balance extends ORM
{
	protected $_table_name = 'users';

	protected $_grid_columns = array(
		'name' => NULL,
		'balance' => NULL,
		'money_earned' => NULL,
		'money_paidout' => NULL,

		'edit' => array(
			'type' => 'link',
			'route_str' => 'admin-money_balance:edit?id=${id}',
			'title' => 'Редактировать баланс',
		),
	);
	public function labels()
	{
		return array(
			'name' => 'Логин',
			'balance' => 'Баланс',
			'money_earned' => 'Заработано',
			'money_paidout' => 'Выплачено',
		);
	}
	
	public function form()
	{
		$transaction = ORM::factory('money_payment_partner');
		$transaction->partner_id = $this->id;
		return new Form_Admin_Money_Balance($transaction);
	}
}