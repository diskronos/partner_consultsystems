<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Client extends CM_Form_Abstract 
{
	private $_model = NULL;
	public function construct_form($param)
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,NULL));
		$this->set_field('name', new CM_Field_String(),10);
		$this->set_field('email', new CM_Field_String(),20);
		$this->set_field('partner_id', new CM_Field_Select_ORM_Autocomplete(ORM::factory('user'), 'name'),30);
		$this->set_field('tariff', new CM_Field_String(),40);
		$this->set_field('site', new CM_Field_String(),50);
	}
}