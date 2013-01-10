<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Money_Balance extends CM_Form_Abstract 
{
	private $_model = NULL;
	private $_balance = 0;

	public function construct_form($param)
	{
		$this->_model = $param;
		$this->_balance = $this->_model->partner->balance;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,array('balance')));
		$this->set_field('balance', new CM_Field_Int());
		$this->get_field('balance')->set_raw_value($this->_balance);
		$this->set_field('commentary', new CM_Field_Text(), 20);
		$this->get_field('commentary')->set_attributes(array('rows' => '3'));
	}
	public function populate()
	{
		$this->_model->status = 'active';
	}
	public function after_submit()
	{
		$this->_model->payment_sum = $this->get_field('balance')->get_value()->get_raw() - $this->_balance;
	}
	public function after_plugin_submit() 
	{
		Webconsult_Balance::factory($this->_model->partner_id)->set_new_balance();
	}
}