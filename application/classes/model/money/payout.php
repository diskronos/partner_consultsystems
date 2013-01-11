<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Money_Payout extends ORM
{
	protected $_table_name = 'payouts';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);

	static $_statuses = array('pending' => 'В ожидании выплаты', 'paid' => 'Выплачено');

	protected $_belongs_to = array(
		'partner' => array(
			'model' => 'user',
			'foreign_key'=> 'partner_id',
		),
	);
//	
	protected $_grid_columns = array(
		'partner_id' => array(
			'type' => 'template',
			'template' => '${partner.name}'
		),
		'payout_sum' => NULL,
		'status' => array(
			'type' => 'template',
			'template' => '${status_rendered}'
		),
		'created_at' => 'timestamp',
		'requisites' => array(
			'width' => '100',
			'type' => 'template',
			'template' => '${requisites_rendered}'
		),
		'edit' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-money_payout:edit?id=${id}',
			'title' => '[*]',
			
		),
		'set_paid' => array(
			'width' => '160',
			'type' => 'link',
			'route_str' => 'admin-money_payout:set_paid?id=${id}',
			'title' => '${set_paid_rendered}',
			
		),
		'unset_paid' => array(
			'width' => '110',
			'type' => 'link',
			'route_str' => 'admin-money_payout:unset_paid?id=${id}',
			'title' => '${unset_paid_rendered}',
			
		),

	);

	public function rules()
	{
		return array(
			'partner_id' => array(				//это ник он же логин
				array('not_empty'),
			),
			'payout_sum' => array(
				array('not_empty'),
			),
		);
	}
	public function labels()
	{
		return array(
			'partner_id' => 'Логин',
			'payout_sum' => 'Сумма выплаты',
			'status' => 'Статус',
			'requisites' => 'Кошелек WebMoney / Реквизиты',
			'created_at' => 'Дата заказа',
		);
	}

	public function form()
	{
		return new Form_Admin_Money_Payout($this);
	}

	public function get_balance_change()
	{
		return '-' . ($this->payout_sum);
	}

	public function get_date()
	{
		return date('d.m.Y', $this->created_at);
	}
	
	public function get_status_rendered()
	{
		switch ($this->status)
		{
			case 'pending':
				$result = '<span style="color:red;">В ожидании выплаты</span>';
				break;
			case 'paid':
				$result = '<span style="color:green;">Выплачено</span';
				break;
			default:
				$result = 'Неизвестен';
				break;
		}
		return $result;
	}
	public function get_set_paid_rendered()
	{
		switch ($this->status)
		{
			case 'pending':
				$result = '[Отметить выплаченным]';
				break;
			case 'paid':
				$result = '';
				break;
			default:
				break;
		}
		return $result;
	}
	public function get_statuses()
	{
		return self::$_statuses;
	}
	public function get_color()
	{
		return ($this->status == 'paid') ? 'yellow' : 'yellow-gray';
	}
	
	public function get_requisites_rendered()
	{
		if ($this->partner->status == 'individual')
		{
			return $this->partner->requisites->wmz_purse_number;
		}
		else 
		{
			return '<a href="/' . Url::url_to_route('admin-partner_requisites_edit?id=' . $this->partner->id) . '" target="_blank">Реквизиты</a>';
		}
	}
	public function get_unset_paid_rendered()
	{
		switch ($this->status)
		{
			case 'pending':
				$result = '';
				break;
			case 'paid':
				$result = '[Откатить отметку]';
				break;
			default:
				break;
		}
		return $result;
	}
	public function get_message_params()
	{
		$partner = $this->partner;
		$result = array(
			'payout_sum' => $this->payout_sum,
			'new_balance' => $partner->balance,
			'contact' => $this->fullname,
		);
		if ($partner->status == 'individual')
		{
			$result['purse_number'] = $partner->requisites->wmz_purse_number;
		}
		else 
		{
			$result['company_name'] = $partner->company_name;
		}
		return $result;
	}
}