<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Filter_Payout extends CM_Form_Abstract
{

	protected function  construct_form($param) {
		$this->_model_obj = $param;

		//категория, название, урл, статус, владелец.
		$this->set_method('get');
		$this->add_plugin(new CM_Form_Plugin_ORM_Labels());
		$this->add_plugin(new CM_Form_Plugin_ORM_Filter_Equals('status', TRUE, TRUE));
		$this->set_field('status', new CM_Field_Select(ORM::factory('money_payout')->statuses));
	}
}