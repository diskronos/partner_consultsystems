<?php defined('SYSPATH') or die('No direct script access.');

class CM_Field_Label extends CM_Field_String
{
	protected $_max_len = NULL;
	protected $_default_value = '';

	public function __construct($default_value = '')
	{
		$this->_default_value = $default_value;
		parent::__construct();
	}
	
	public function get_type_name()
	{
		return 'Текст';
	}

	public function render()
	{
		if (is_null($this->get_value()->get_raw()))
			$this->set_value(new CM_Value_String($this->_default_value));
		return form::label($this->get_name(), $this->get_value()->get_raw(), $this->get_attributes());
	}
}