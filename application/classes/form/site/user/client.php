<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_User_Client extends CM_Form_Abstract
{
	private $_model = NULL;

	protected function construct_form($param) 
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM());
		$this->set_field('email', new CM_Field_String());
		$this->set_field('name', new CM_Field_String());
		//$this->set_field('site', new CM_Field_String());
		$this->set_field('tariff', new CM_Field_Password());
		$this->set_field('partner_id', new CM_Field_String());
		$this->set_field('login', new CM_Field_String());
	}
}