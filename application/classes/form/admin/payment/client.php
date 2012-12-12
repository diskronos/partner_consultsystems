<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Payment_Client extends CM_Form_Abstract
{
	protected function construct_form($param = NULL) 
	{
//		$balance = Webconsult_Balance::factory(Auth::instance()->get_user()->id);
//		$max_value = $balance->get_money_available();
//		$validation = Validation::factory(array())
//					->rule('payout_sum', 'not_empty', NULL)
//					->rule('payout_sum', 'numeric', NULL)
//					->rule('payout_sum', 'range', array(':value', 0, $max_value));
//		$this->add_plugin(new CM_Form_Plugin_Validate($validation));
		$this->add_plugin(new CM_Form_Plugin_ORM_Labels());
		$this->set_field('client_id', new CM_Field_Select_ORM_Autocomplete(ORM::factory('user'), 'name'),10);
		$this->set_field('payment_sum', new CM_Field_Int(),20);
		$this->set_field('partner_payment', new CM_Field_Boolean(),30);
		$this->get_field('partner_payment')->set_label('С партнерскими отчислениями');
		
	}
	public function after_submit()
	{
		Webconsult_Transaction::client_payment(
				$this->get_field('client_id')->get_value()->get_raw(),
				$this->get_field('payment_sum')->get_value()->get_raw(),
				$this->get_field('partner_payment')->get_value()->get_raw()
				);
	}
}