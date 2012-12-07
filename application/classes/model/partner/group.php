<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Partner_Group extends ORM
{
	protected $_table_name = 'partner_groups';
	protected $_grid_columns = array(
		'name' => array(
			'orderable' => false,
		),
		'payout_ratio' => array(
			'type' => 'template',
			'template' => '${payout_ratio}%',
		),
		'payment_limit' => array(
			'type' => 'template',
			'template' => '${payment_limit} руб.',
		),
		'logo' => array(
			'type' => 'template',
			'template' => '<img src="${logo}">',
		),
	);

	public function labels()
	{
		return array(
			'name' => 'Название',
			'payout_ratio' => 'Процент выплат',
			'payment_limit' => 'Лимит достижения',
			'logo' => 'Лого',
		);
	}



}