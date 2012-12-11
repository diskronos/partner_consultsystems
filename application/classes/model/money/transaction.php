<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Money_Transaction extends ORM
{
	protected $_table_name = 'transactions';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);
	
	protected $_belongs_to = array(
		'parent_transaction' => array(
			'model' => 'transaction',
			'foreign_key'=> 'parent_transaction_id',
		),
	);
}