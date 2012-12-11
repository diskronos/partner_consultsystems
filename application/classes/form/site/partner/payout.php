<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_Partner_Payout extends CM_Form_Abstract
{
	private $_model = null;
	protected function construct_form($param = NULL) 
	{
		$balance = Webconsult_Balance::factory(Auth::instance()->get_user()->id);
		$max_value = $balance->get_money_balance() - $balance->get_money_holded();
		$this->add_plugin(new CM_Form_Plugin_ORM());
		$validation = Validation::factory(array())
					->rule('payout_sum', 'numeric', NULL)
					->rule('payout_sum', 'range', array(':value', 0, $max_value));
		$this->add_plugin(new CM_Form_Plugin_Validate($validation));
		$this->_model = $param;
		$this->set_field('payout_sum', new CM_Field_String());
	}
	public function populate() 
	{
		$this->_model->partner_id = Auth::instance()->get_user()->id;
	}
}