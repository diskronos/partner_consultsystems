<?php

defined('SYSPATH') or die('No direct script access.');

class Webconsult_Balance
{
	protected $_user = NULL;
	public function __construct($user_id)
	{
		$this->_user = is_object($user_id) ? clone $user_id : ORM::factory('user', $user_id);
	}

	public static function factory($user_id)
	{
		return new Webconsult_Balance($user_id);
	}

	public function get_money_earned()
	{
		return arr::get(
			db::query(Database::SELECT, DB::expr('SELECT ( ' . $this->db_compile_debet() . ') as result'))
				->execute()
				->current(),
			'result',
			0
		);
	}
	public function get_money_holded()
	{
		return arr::get(
			db::query(Database::SELECT, DB::expr('SELECT ( ' . $this->db_compile_holded_payments_as_partner() . ') as result'))
				->execute()
				->current(),
			'result',
			0
		);
	}

	public function get_money_paidout()
	{
		return arr::get(
			db::query(Database::SELECT, DB::expr('Select ( ' . $this->db_compile_payouts() . ') as result'))
				->execute()
				->current(),
			'result',
			0
		);
	}
	
	public function get_money_balance()
	{
		return arr::get(
			db::query(Database::SELECT, $this->db_compile_balance())
				->execute()
				->current(),
			'result',
			0
		);
	}
	
	public function get_money_available()
	{
		return arr::get(
			db::query(Database::SELECT, DB::expr('SELECT( (' .$this->db_compile_payments_as_partner() . ') - ('. $this->db_compile_holded_payments_as_partner(). ') - (' . $this->db_compile_payouts() . ')) as result'))
				->execute()
				->current(),
			'result',
			0
		);
	}
	
	public function set_new_balance()
	{
		$this->_user->balance = $this->get_money_balance();
		$this->_user->money_earned = $this->get_money_earned();
		$this->_user->money_paidout = $this->get_money_paidout();
		$this->_user->save();
		$this->_user->try_next_level();
	}

	//select ifnull(sum(payer_account_balance),0) from transactions where payer_id = 1

	//------------DB запросы---------------------------------------------------
	//-------------База
	protected function db_compile_payments_as_client() // пользователь платит фирме
	{
		return	DB::select(DB::expr('ifnull(sum(payment_sum),0)'))
					->from('payments_client')
					->where('client_id', '=', $this->_user->id)
					->and_where('status', '<>', 'reverted')
					->compile(Database::instance());
	}
	

	protected function db_compile_payments_as_partner() // фирма платит партнеру
	{
		return	DB::select(DB::expr('ifnull(sum(payment_sum),0)'))
					->from('payments_partner')
					->where('partner_id', '=', $this->_user->id)
					->and_where('status', '<>', 'reverted')
					->compile(Database::instance());
	}

	protected function db_compile_holded_payments_as_partner() // пользователь платит фирме
	{
		return	DB::select(DB::expr('ifnull(sum(payment_sum),0)'))
					->from('payments_partner')
					->where('partner_id', '=', $this->_user->id)
					->and_where('status', '=', 'holded')
					->compile(Database::instance());
	}

	protected function db_compile_active_payments_as_partner() // пользователь платит фирме
	{
		return	DB::select(DB::expr('ifnull(sum(payment_sum),0)'))
					->from('payments_partner')
					->where('partner_id', '=', $this->_user->id)
					->and_where('status', '=', 'active')
					->compile(Database::instance());
	}

	protected function db_compile_payouts()		//сброс с баланса
	{
		return DB::select(DB::expr('ifnull(sum(payout_sum),0)'))
					->from('payouts')
					->where('partner_id', '=', $this->_user->id)
					->compile(Database::instance());
	}
	//----------------Сложные
	protected function db_compile_debet()
	{
		return $this->db_compile_payments_as_partner();
	}
	
	protected function db_compile_credit()
	{
		return $this->db_compile_payouts();
	}
	
	protected function db_compile_balance()
	{
		return DB::select(DB::expr('( ' . $this->db_compile_debet() .' ) - ( ' . $this->db_compile_credit() . ') as result' ))
					->compile(Database::instance());
	}

}