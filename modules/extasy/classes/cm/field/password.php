<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class CM_Field_Password extends CM_Field_String
{
	public function render()
	{
		return form::password($this->get_name(), NULL, $this->get_attributes());
	}
	
	public function get_type_name()
	{
		return 'Пароль';
	}
}