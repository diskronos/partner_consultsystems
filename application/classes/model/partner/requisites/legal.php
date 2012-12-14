<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Partner_Requisites_Legal extends ORM
{
	protected $_table_name = 'legal_requisites';
	
	protected $_belongs_to = array(
		'user' => array(
			'model' => 'user',
			'foreign_key' => 'partner_id',
		),
	);

	static $_requisite_names = array(
		'individual_number' => array(
			'fullname'	=> 'Индивидуальный номер налогоплательщика',
			'shortname' => 'ИНН',
		),

		'reason_registration_code' => array(
			'fullname'	=> 'Код причины постановки на учёт',
			'shortname' => 'КПП',
		),
		'bank' => array(
			'fullname'	=> 'Банк',
			'shortname' => 'Банк',
		),

		'bank_identification_code' => array(
			'fullname'	=> 'Банковский идентификационный код',
			'shortname' => 'БИК',
		),

		'payment_account' => array(
			'fullname'	=> 'Рассчетный счет',
			'shortname' => 'Р/c',
		),

		'legal_address'=> array(
			'fullname'	=> 'Юридический адрес',
			'shortname' => 'Юр. адрес',
		),

		'represented' => array(
			'fullname'	=> 'В лице',
			'shortname' => 'В лице',
		),

		'on_authority' => array(
			'fullname'	=> 'На основании',
			'shortname' => 'На основании',
		),

		'fullname' => array(
			'fullname'	=> 'ФИО',
			'shortname' => 'ФИО',
		),
	);

	protected $_grid_columns = array(
		'login' => array(
			'type' => 'template',
			'template' => '${user.name}',
		),

		'partner_id' => array(
			'type' => 'template',
			'template' => '${user.company_name}',
		),

		'confirm' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-partner_requisites_moderate:confirm?id=${id}',
			'title' => '[Принять]',
		),

		'edit' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-partner_requisites_moderate:edit?id=${id}',
			'title' => '[Редактировать]',
		),
		'delete' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-partner_requisites_moderate:delete?id=${id}',
			'title' => '[Отклонить]',
			'confirm' => 'Вы уверены?'
		)
	);

	public function rules()
	{
		return array_map(function($var){return array(array('not_empty'));},self::$_requisite_names);
	}
	
	public function labels()
	{
		$labels = $this->get_requisites_fullnames();
		$labels['partner_id'] = "Название компании";
		$labels['login'] = "Логин";
		$labels['confirmed'] = "Подтверждено";
		return $labels;
	}
	
	public function form()
	{
		return new Form_Admin_Requisites_Moderate($this);
	}

	public function get_requisites_fullnames()
	{
		return array_map(function($var){return $var['fullname'];},self::$_requisite_names);
	}
	
	public function get_requisites_shortnames()
	{
		return array_map(function($var){return $var['shortname'];},self::$_requisite_names);
	}
	
	public function get_requisites_names()
	{
		return self::$_requisite_names;
	}

	public function get_requisites()
	{
		$result = array();
		foreach (self::$_requisite_names as $key => $value) 
		{
		  $result[$key]  = $this->$key;
		}
		return $result;
	}

	public function get_name()
	{
		return $this->payment_account;
	}

}