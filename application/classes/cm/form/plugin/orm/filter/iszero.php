<?php

defined('SYSPATH') or die('No direct script access.');

class CM_Form_Plugin_ORM_Filter_Iszero extends CM_Form_Plugin_ORM_Filter_Abstract
{
	public function populate(CM_Form_Abstract $form)
	{
		$value = $form->get_field($this->get_field_name())->get_value()->get_raw();//true/false
		$this->get_model()->where($this->get_field_name(), $value ? '<>' : '=', '0');
	}
}