<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

abstract class CM_Field_Image_Abstract extends CM_Field_File
{
	protected $_value_class = 'CM_Value_Image';

	protected $_thumb_path_mapping = array(
		'#^(.*)$#', '$1'
	);

	protected function generate_alt_field()
	{
		$field = new CM_Field_String;
		$field->set_value_source($this->get_value_source());
		$field->set_name($this->get_name().'_alt');
		$field->set_raw_value($this->get_value()->get_alt());
		return $field;
	}

	protected function get_default_destination_dir()
	{
		return 'pictures';
	}

	public function set_thumb_path_mapping($regex, $replace)
	{
		$this->_thumb_path_mapping = array($regex, $replace);
	}

	public function get_allowed_extensions()
	{
		return array('jpeg', 'jpg', 'png', 'gif');
	}

	public function get_type_name()
	{
		return 'Изображение';
	}

	public function render_icon()
	{
		return $this->render_value();
	}

	public function render_additional_inputs()
	{
		return View::factory('cm/field/image/additional_inputs', array(
			'alt_field' => $this->generate_alt_field(),
			'name' => $this->get_name()
		));
	}

	public function render_value()
	{
		$value = $this->get_value();
		if ($value->is_empty())
		{
			return '';
		}

		return View::factory('cm/value/image', array(
			'value' => $value,
			'thumb_filename' => $this->get_thumb_filename()
		));
	}

	protected function get_thumb_filename()
	{
		if ($this->get_value()->is_empty())
		{
			return NULL;
		}

		return preg_replace(
			$this->_thumb_path_mapping[0],
			$this->_thumb_path_mapping[1],
			$this->get_value()->get_download_filename()
		);
	}

	public function get_submitted_value()
	{
		$filename = arr::get($this->get_value_source(), $this->get_name());

		$alt = $this->generate_alt_field()->get_submitted_value()->get_raw();

		return $this->create_raw_value($filename.'|'.$alt);
	}

	public function get_description()
	{
		$description = parent::get_description();
		$value = $this->get_value();
		if ( ! $value->is_empty())
		{
			$description['Размеры изображения'] = $value->get_width().'x'.$value->get_height();
		}
		return $description;
	}

}
