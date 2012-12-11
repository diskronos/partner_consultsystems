<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Money_Payout extends ORM
{
	protected $_table_name = 'payouts';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);
	
	protected $_belongs_to = array(
		'partner' => array(
			'model' => 'user',
			'foreign_key'=> 'parent_id',
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

}