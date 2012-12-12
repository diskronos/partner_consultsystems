<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Money_Payout extends CM_Form_Abstract 
{
	private $_model = NULL;

	public function construct_form($param)
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,NULL));
		$this->set_field('partner_id', new CM_Field_Select_ORM_Autocomplete(ORM::factory('user'), 'name'), 10);
		$this->set_field('payout_sum', new CM_Field_Int(), 20);
		$this->set_field('status', new CM_Field_Select(ORM::factory('money_payout')->statuses), 30);
		$this->set_field('commentary', new CM_Field_Text(), 40);
		$this->get_field('commentary')->set_attributes(array('rows' => '3'));
		$this->set_field('created_at', new CM_Field_Date(), 50);
	}
}