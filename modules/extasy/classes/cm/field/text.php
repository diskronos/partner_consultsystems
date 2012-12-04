<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class CM_Field_Text extends CM_Field_String
{
	protected $_max_len = NULL;
	
	public function __construct()
	{
		parent::__construct();
		$this->set_attributes(array(
			'rows' => 30
		));
	}
	
	public function get_type_name()
	{
		return 'Текст';
	}

	public function render()
	{
		return form::textarea($this->get_name(), $this->get_value()->get_raw(), $this->get_attributes());
	}
/*
	public function render_value()
	{
		return text::limit_chars(parent::render_value(), 100, '...', TRUE);
	}
*/
}