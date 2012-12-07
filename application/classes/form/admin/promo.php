<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Promo extends CM_Form_Abstract 
{
	private $_model = NULL;

	public function construct_form($param)
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,NULL));
		$this->set_field('page_content', new CM_Field_HTML());
		$this->get_field('page_content')->set_label('Контент');
	}
}