<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Client_Site extends ORM
{
	protected $_table_name = 'client_sites';

	public function rules()
	{
		return array(
			'foreign_id' => array(				//это ник он же логин
				array('not_empty'),
				array(array($this, 'unique'), array('foreign_id', ':value')),
			),
			'client_id' => array(				//это ник он же логин
				array('not_empty'),
			),
			'url' => array(
				array('not_empty'),
			),
		);
	}

}