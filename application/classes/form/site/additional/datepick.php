<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_Additional_Datepick extends CM_Form_Abstract
{
	protected function construct_form($param) 
	{
		$this->set_field('from', new CM_Field_String());
		$this->set_field('to', new CM_Field_String());
		$this->get_field('from')->set_attributes(array('class'=> 'text', 'id' => 'from'));
		$this->get_field('to')->set_attributes(array('class'=> 'text', 'id' => 'to'));
		$this->set_defaults();
	}
	
	
	public function render_jq()
	{
		return View::factory('cm/form/datepick', array());
	}
	
	protected function set_defaults()
	{
		if (is_null($this->get_field('from')->get_value()->get_raw()))
		{
			$this->get_field('from')->set_raw_value(date('d.m.Y', time() - 7 * 86400));
		}
		if (is_null($this->get_field('to')->get_value()->get_raw()))
		{
			$this->get_field('to')->set_raw_value(date('d.m.Y', time()));
		}
	}
}