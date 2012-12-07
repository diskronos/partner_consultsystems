<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_User_Register extends CM_Form_Abstract
{
	private $_model = NULL;

	protected function construct_form($param) 
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL, array('password_confirm')));
		$this->set_field('email', new CM_Field_String());
		$this->set_field('name', new CM_Field_String());
		$this->set_field('password', new CM_Field_Password());
		$this->set_field('password_confirm', new CM_Field_Password());
		$this->set_field('referrer_id', new CM_Field_Int());
		$this->set_field('fullname', new CM_Field_String());
		$this->add_plugin(new CM_Form_Plugin_Validate(Model_User::get_password_validation()));
	}

	
	protected function after_submit() 
	{
//		var_dump($this->get_field('password')->get_error());
//		die();
		$this->_model->status = 'individual';
		$this->_model->roles = 2;
	}
}