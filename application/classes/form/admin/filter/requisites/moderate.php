<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Filter_Requisites_Moderate extends CM_Form_Abstract
{
	protected function  construct_form($param) {
		$this->_model_obj = $param;

		//категория, название, урл, статус, владелец.
		$this->set_method('get');
		$this->add_plugin(new CM_Form_Plugin_ORM_Filter_Equals('status', TRUE, TRUE));
		$this->set_field('partner_id', new CM_Field_Select_ORM_Autocomplete(ORM::factory('user'), 'name'));
		$this->get_field('partner_id')->set_label('Логин');
	}
}