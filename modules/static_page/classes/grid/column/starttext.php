<?php

defined('SYSPATH') or die('No direct script access.');
/**
 *  @author Astapenko Yakoy <y.astapenko@smartdesign.by>
 *  @copyright KRIOS GROUP
 */
class Grid_Column_Starttext extends Grid_Column_Text {
	
	protected $border = 50;


	protected function _field($obj)
	{
		if(mb_strlen($obj[$this->get_name()]) > $this->border)
		{
			$value = mb_substr($obj[$this->get_name()], 0,50,'utf8').'...';
		}
		else
		{
			$value = $obj[$this->get_name()];
		}
		return View::factory($this->_field_template, array(
			'value' => $value,
		));
	}
}
