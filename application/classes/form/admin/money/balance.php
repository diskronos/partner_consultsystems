<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Money_Balance extends CM_Form_Abstract 
{
	private $_model = NULL;

	public function construct_form($param)
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,NULL));
		$this->set_field('payment_sum', new CM_Field_Float(), 10);
		$this->set_field('commentary', new CM_Field_Text(), 20);
		$this->get_field('commentary')->set_attributes(array('rows' => '3'));
	}
	public function populate()
	{
		$this->_model->status = 'active';
	}
	public function after_plugin_submit() 
	{
		Webconsult_Balance::factory($this->_model->partner_id)->set_new_balance();
	}
}