<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class CM_Form_Plugin_ORM_Filter_Equals extends CM_Form_Plugin_ORM_Filter_Abstract
{
	private $_allow_null = FALSE;
	private $_allow_empty = FALSE;

	public function __construct($field_name, $allow_null = FALSE, $allow_empty = FALSE)
	{
		parent::__construct($field_name);
		$this->_allow_null = $allow_null;
	}

	public function populate(CM_Form_Abstract $form)
	{
		$value = $form->get_field($this->get_field_name())->get_value()->get_raw();
		if (empty($value) AND ! $this->_allow_empty)
		{
			return;
		}
		
		if ( ! is_null($value) OR $this->_allow_null)
		{
			$this->get_model()->where($this->get_field_name(), is_null($value) ? 'IS' : '=', $value);
		}
	}
}