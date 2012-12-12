<?php

defined('SYSPATH') or die('No direct script access.');
//CREATE TABLE `transactions` (
//	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//	`payer_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//	`beneficiary_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//	`parent_transaction_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//	`payer_account_balance` BIGINT(20) NOT NULL,
//	`beneficiary_account_balance` BIGINT(20) NOT NULL,
//	`beneficiary_account_hold_balance` BIGINT(20) NOT NULL,
//	`status` ENUM('active','reverted','revert') NOT NULL DEFAULT 'active',
//	`type` ENUM('client_payment','company_payment') NOT NULL DEFAULT 'client_payment',
//	`commentary` VARCHAR(255) NULL DEFAULT NULL,
//	`created_at` INT(10) UNSIGNED NOT NULL,
//	PRIMARY KEY (`id`),
//	INDEX `parent_transaction_id` (`parent_transaction_id`),
//	CONSTRAINT `parent_transaction_id` FOREIGN KEY (`parent_transaction_id`) REFERENCES `transactions` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
//)
//COLLATE='utf8_general_ci'
//ENGINE=InnoDB;

class Model_Money_Transaction extends ORM
{
	protected $_table_name = 'transactions';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);
	
	protected $_belongs_to = array(
		'parent_transaction' => array(
			'model' => 'transaction',
			'foreign_key'=> 'parent_transaction_id',
		),
		'payer' => array(
			'model' => 'user',
			'foreign_key' => 'payer_id',
			
		),
		'beneficiary' => array(
			'model' => 'user',
			'foreign_key' => 'beneficiary_id',
		),
	);
	

	protected $_grid_columns = array(
		'payer_id' => array(
			'type' => 'template',
			'template' => '${payer_name}'
		),
		'beneficiary_id' => array(
			'type' => 'template',
			'template' => '${beneficiary_name}'
		),
//		'payment_sum' => array(
//			'type' => 'template',
//			'template' => '${balance_changed}'
//		),
//		'is_holded' => array(
//			'type' => 'template',
//			'template' => '${is_holded_rendered}'
//		),
//		'status' => array(
//			'type' => 'template',
//			'template' => '${status_rendered}'
//		),

//		'type' => NULL,
//
//		'created_at' => 'timestamp',
//
//		'payback' => array(
//			'width' => '50',
//			'type' => 'link',
//			'route_str' => 'admin-money_transaction:edit?id=${id}',
//			'title' => '[]',
//			
//		),
//
//		'edit' => array(
//			'width' => '50',
//			'type' => 'link',
//			'route_str' => 'admin-money_transaction:edit?id=${id}',
//			'title' => '[*]',
//			
//		),
	);


	public function get_is_holded()
	{
		return ($this->beneficiary_account_hold_balance != 0);
	}

	public function get_balance_change()
	{
		return '+' . ($this->beneficiary_account_hold_balance + $this->beneficiary_account_balance);
	}
	
	public function get_date()
	{
		return date('d.m.Y', $this->created_at);
	}
	public function get_beneficiary_name()
	{
		return is_null($this->beneficiary_id) ? NULL : ORM::factory('user', $this->beneficiary_id);
	}
	
	public function get_payer_name()
	{
		return is_null($this->$this->beneficiary_id) ? NULL : ORM::factory('user', $this->beneficiary_id);
	}
	
	
	public function get_balance_changed()
	{
		return ($this->beneficiary_account_hold_balance + $this->beneficiary_account_balance);
	}
	
	public function get_is_holded_rendered()
	{
		return $this->is_holded ?	'<span style="color:red">В ожидании</span>' : 
									'<span style="color:greeen">Деньги доступны</span>';
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
			default:
				break;
		}
		return $result;
	}
//	public function get_payer()
//	{
//		return is_null($this->payer_id) ? NULL : ORM::factory('user', $this->payer_id);
//	}
}