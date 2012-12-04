<?php defined('SYSPATH') or die('No direct script access.');

class Model_Logger extends ORM
{
	protected $_table_name = 'logs';
	protected $_created_column = array('column' => 'time','format' => TRUE);

	protected $_grid_columns = array(
		'type' => NULL,
		'sender' => NULL,
		'time' => 'timestamp',
		'message' => array(
			'orderable' => FALSE
		),
	);

	public function labels()
	{
		return array(
			'type' => 'Тип',
			'sender' => 'Отправитель',
			'time' => 'Дата',
			'message' => 'Лог',
		);
	}
}