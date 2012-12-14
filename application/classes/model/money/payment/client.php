<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Money_Payment_Client extends ORM
{
	protected $_table_name = 'payments_client';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);
	protected $_belongs_to = array(
		'client' => array(
			'model' => 'client',
			'foreign_key'=> 'client_id',
		),
	);
	protected $_has_one = array(
		'partner_payment' =>array(
			'model' => 'money_payment_partner',
			'foreign_key'=> 'client_payment_id',
		),
	);
	protected $_grid_columns = array(
		'client_id' => array(
			'type' => 'template',
			'template' => '${client.name}'
		),
		'payment_sum' => NULL,
		'status' => array(
			'type' => 'template',
			'template' => '${status_rendered}'
		),
		'revert' => array(
			'width' => '100',
			'type' => 'link',
			'route_str' => 'admin-money_payment_client:revert?id=${id}',
			'title' => '${revert_rendered}',
		),

		'edit' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-money_payment_client:edit?id=${id}',
			'title' => '[*]',
			
		),
		
		'delete' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-money_payment_client:delete?id=${id}',
			'title' => '[X]',
		),

	);
	public function get_date()
	{
		return date('d.m.Y', $this->created_at);
	}

	public function labels()
	{
		return array(
			'client_id' => 'Логин клиента',
			'payment_sum' => 'Сумма выплаты',
			'status' => 'Статус',
		);
	}
//	public function rules()
//	{
////		return array(
////			'client_id' => array(
////				array('not_empty'),
////			),
////			'payout_sum' => array(
////				array('not_empty'),
////			),
////		);
//	}


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
	
	public function form()
	{
		return new Form_Admin_Payment_Client($this);
	}

	public function get_revert_rendered()
	{
		return $this->status == 'holded' ? '[Откатить]' : '';
	}

}