<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Requisites_Moderate extends CM_Form_Abstract //legal - юридическое лицо
{
	private $_model = NULL;

	public function construct_form($param)
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,NULL));
	
		foreach (array_keys($this->_model->requisites_names) as $requsite_name)
		{
			$this->set_field($requsite_name, new CM_Field_String());
		}
	}
}