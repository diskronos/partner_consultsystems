<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Client extends ORM
{
	protected $_table_name = 'clients';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);
//	
	protected $_belongs_to = array(
		'partner' => array(
			'model' => 'user',
			'foreign_key'=> 'partner_id',
		),
	);

	protected $_grid_columns = array(
		'name' => NULL,
		'partner_id' => array(
			'type' => 'template',
			'template' => '${partner.name}',
		),
		'email' => NULL,
		'tariff' => NULL,
		'site' => NULL,

		'created_at' => 'timestamp',

		'edit' => array(
			'type' => 'link',
			'route_str' => 'admin-client:edit?id=${id}',
			'title' => '[*]',
		),
		'delete' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-client:delete?id=${id}',
			'title' => '[X]',
			'confirm' => 'Вы уверены?'
		)
	);


	public function rules()
	{
		return array(
			'name' => array(				//это ник он же логин
				array('not_empty'),
//				array('min_length', array(':value', 3)),
//				array('max_length', array(':value', 16)),
//				array('regex', array(':value', '#^[a-z0-9\pL ]+$#iu')),
				array(array($this, 'unique'), array('name', ':value')),
			),
			'email' => array(
				array('not_empty'),
				array('email'),
				array(array($this, 'unique'), array('email', ':value')),
			),
		);
	}
	public function labels()
	{
		return array(
			'email' => 'E-Mail',
			'created_at' => 'Дата регистрации',
			'name' => 'Имя',
			'partner_id' => 'Логин партнера',
			'tariff' => 'Тариф',
			'site' => 'Сайт',
		);
	}
	
	public function form()
	{
		return new Form_Admin_Client($this);
	}

}