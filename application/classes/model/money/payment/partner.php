<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Money_Payment_Partner extends ORM
{
	protected $_table_name = 'payments_partner';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);

	protected $_belongs_to = array(
		'partner' => array(
			'model' => 'user',
			'foreign_key'=> 'partner_id',
		),
	);

	protected $_grid_columns = array(
		'partner_id' => array(
			'type' => 'template',
			'template' => '${partner.name}'
		),
		'payment_sum' => NULL,
		'status' => array(
			'type' => 'template',
			'template' => '${status_rendered}'
		),
		'commentary' => NULL,
		'revert' => array(
			'width' => '100',
			'type' => 'link',
			'route_str' => 'admin-money_payment_client:revert?id=${id}',
			'title' => '${revert_rendered}',
		),

		'delete' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-money_payment_client:delete?id=${id}',
			'title' => '[X]',
		),

	);
	public function labels()
	{
		return array(
			'partner_id' => 'Логин партнера',
			'client_id' => 'Логин клиента',
			'payment_sum' => 'Изменение баланса',
			'status' => 'Статус',
			'commentary' => 'Комментарий',
		);
	}

	public function get_date()
	{
		return date('d.m.Y', $this->created_at);
	}

	public function get_is_holded()
	{
		return $this->status == 'holded';
	}

	public function get_status_rendered()
	{
		switch ($this->status)
		{
			case 'active':
				$result = '<span style="color:green">Активен</span>';
				break;
			case 'reverted':
				$result = '<span style="color:red">Откачен</span>';
				break;
			case 'holded':
				$result = '<span style="color:#AA3">В ожидании</span>';
				break;
			default:
				break;
		}
		return $result;
	}
	public function get_revert_rendered()
	{
		return $this->status == 'holded' ? '[Откатить]' : '';
	}
	
	public function get_color()
	{
		if ($this->is_holded)
		{
			return 'gray';
		}
		elseif ($this->payment_sum < 0) 
		{
			return 'yellow';
		}
		else 
		{
			return 'green';
		}
	}
	public function get_payment_sum_signed()
	{
		return ($this->payment_sum > 0) ? '+' . $this->payment_sum : $this->payment_sum;
	}
}