<?php

defined('SYSPATH') or die('No direct script access.');

class Webconsult_Balance
{
	protected $_user = NULL;
	public function __construct($user_id)
	{
		$this->_user = ORM::factory('user', $user_id);
	}

	public static function factory($user_id)
	{
		return new Webconsult_Balance($user_id);
	}

	public function get_money_earned()
	{
		return arr::get(
			db::query(Database::SELECT, DB::expr($this->db_compile_debet() . ' as result'))
				->execute()
				->current(),
			'result',
			0
		);
	}
	public function get_money_holded()
	{
		return arr::get(
			db::query(Database::SELECT, DB::expr('Select ( ' . $this->db_compile_holded_benefits() . ') as result'))
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
			db::query(Database::SELECT, DB::expr('SELECT((' .$this->db_compile_debet() . ') - ('. $this->db_compile_credit(). ')) as result'))
				->execute()
				->current(),
			'result',
			0
		);
	}
	
	public function get_money_available()
	{
		return arr::get(
			db::query(Database::SELECT, DB::expr('SELECT((' .$this->db_compile_benefits() . ') - ('. $this->db_compile_credit(). ')) as result'))
				->execute()
				->current(),
			'result',
			0
		);
	}

	//select ifnull(sum(payer_account_balance),0) from transactions where payer_id = 1

	//------------DB запросы---------------------------------------------------
	//-------------База
	protected function db_compile_payments() // пользователь платит фирме
	{
		return	DB::select(DB::expr('ifnull(sum(payer_account_balance),0)'))
					->from('transactions')
					->where('payer_id', '=', $this->_user->id)
					->compile(Database::instance());
	}

	protected function db_compile_benefits() //фирма заплатила пользователю
	{
		return DB::select(DB::expr('ifnull(sum(beneficiary_account_balance),0)'))
					->from('transactions')
					->where('beneficiary_id', '=', $this->_user->id)
					->compile(Database::instance());
	}
	
	protected function db_compile_holded_benefits() //фирма платит в холд
	{
		return DB::select(DB::expr('ifnull(sum(beneficiary_account_hold_balance),0)'))
					->from('transactions')
					->where('beneficiary_id', '=', $this->_user->id)
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
		return DB::select(DB::expr('(' . $this->db_compile_holded_benefits() .' ) + ( ' . $this->db_compile_benefits().')'))
					->compile(Database::instance());
	}
	
	protected function db_compile_credit()
	{
		return DB::select(DB::expr('(' . $this->db_compile_payouts() .' ) - ( ' . $this->db_compile_payments() . ')' ))
					->compile(Database::instance());
	}
	
	protected function db_compile_balance()
	{
		return DB::select( '(' . DB::expr($this->db_compile_debet() .' ) - ( ' . $this->db_compile_credit() . ')'))
					->compile(Database::instance());
	}

}