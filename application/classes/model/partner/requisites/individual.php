<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Partner_Requisites_Individual extends ORM
{
	protected $_table_name = 'individual_requisites';

	protected $_belongs_to = array(
		'user' => array(
			'model' => 'user',
			'foreign_key' => 'partner_id',
		),
	);

	static $_requisite_names = array(
		'wmz_purse_number' => array(
			'fullname'	=> 'Индивидуальный номер налогоплательщика',
			'shortname' => 'ИНН',
		),
	);

	
	public function rules()
	{
		return array(
			'wmz_purse_number' => array(
				array('not_empty'),
			),
		);
	}
	
	public function get_name()
	{
		return $this->wmz_purse_number;
	}

	public function save(Validation $validation = NULL)
	{
		$this->wmz_purse_number = htmlspecialchars($this->wmz_purse_number, ENT_COMPAT, 'UTF-8', false);
		return parent::save($validation);
	}


}
