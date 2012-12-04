<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class CM_Field_Url extends CM_Field_String
{
	protected function validate()
	{
		parent::validate();
		if ($this->get_value()->get_raw() AND ! Validate::url($this->get_value()->get_raw()))
		{
			$this->set_error('Невалидный URL');
		}
	}
}