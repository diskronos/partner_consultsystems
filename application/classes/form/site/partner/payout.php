<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_Partner_Payout extends CM_Form_Abstract
{
	protected function construct_form($param = NULL) 
	{
		$balance = Webconsult_Balance::factory(Auth::instance()->get_user()->id);
		$max_value = $balance->get_money_available();
		$validation = Validation::factory(array())
					->rule('payout_sum', 'not_empty', NULL)
					->rule('payout_sum', 'numeric', NULL)
					->rule('payout_sum', 'range', array(':value', 0, $max_value));
		$this->add_plugin(new CM_Form_Plugin_Validate($validation));
		$this->set_field('payout_sum', new CM_Field_String());
	}
	public function after_submit()
	{
		Webconsult_Transaction::money_payout_query(
				Auth::instance()->get_user()->id, 
				$this->get_field('payout_sum')->get_value()->get_raw()
				);
	}
}