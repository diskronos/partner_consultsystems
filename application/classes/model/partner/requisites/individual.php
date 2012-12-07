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

}
