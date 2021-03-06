<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class CM_Field_Boolean extends CM_Field
{
	protected $_value_class = 'CM_Value_Boolean';
	
	public function render()
	{
		return form::checkbox($this->get_name(), '1', $this->get_value()->get_raw(), $this->get_attributes());
	}

	public function get_type_name()
	{
		return 'Boolean';
	}

	public function render_value()
	{
		return parent::render_value() ? 'Да' : 'Нет';
	}
}