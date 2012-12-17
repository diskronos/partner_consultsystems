<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_Partner_Requisites_Individual extends CM_Form_Abstract //legal - юридическое лицо
{
	private $_model = NULL;

	public function construct_form($param)
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,NULL));

		$field_class = $this->_model->loaded() ? 'CM_Field_Label' : 'CM_Field_String';
		$this->set_field('wmz_purse_number', new $field_class());
	}
	
	public function after_submit() 
	{
		$this->_model->partner_id = Auth::instance()->get_user()->id;
	}
}