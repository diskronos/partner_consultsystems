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
	}
	public function render_jq()
	{
		return View::factory('cm/form/datepick', array());
	}
}