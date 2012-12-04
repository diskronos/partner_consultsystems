<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Extasy_Grid_Column_Bool extends Grid_Column_Text
{
	protected function _field($obj)
	{
		return View::factory($this->_field_template, array(
			'align' => $this->_align,
			'value' => $obj[$this->get_name()] ? '<span style="color:green;">Да</span>' : '<span style="color:red;">Нет</span>',
		));
	}
}