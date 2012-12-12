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

	public function get_date()
	{
		return date('d.m.Y', $this->created_at);
	}

	public function get_is_holded()
	{
		return $this->status == 'holded';
	}
}