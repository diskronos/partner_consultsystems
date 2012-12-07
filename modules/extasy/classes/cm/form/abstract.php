<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class CM_Form_Abstract implements CM_Fieldschema_Interface
{
	/**
	 * @var CM_Fieldschema_Interface
	 */
	private $_fieldschema = NULL;

	private $_method = 'post';

	/**
	 * @var CM_Form_Renderer_Abstract
	 */
	private $_renderer = NULL;

	private $_plugins = array();

	final public function __construct($param = NULL)
	{
		$this->init();

		$this->construct_form($param);

		foreach ($this->_plugins as $plugin)
		{
			$plugin->construct_form($this, $param);
		}
	}

	protected function init() {}

	protected function construct_form($param) {}

	public function set_read_only()
	{
		foreach ($this->get_field_names() as $name)
		{
			$new_field = new CM_Field_Readonly();
			$new_field->set_field($this->get_field($name));

			$this->set_field($name, $new_field);
		}
	}

	public function submit()
	{
		$value_source = $this->get_value_source();
		if (empty($value_source))
		{
			return FALSE;
		}
		$valid = TRUE;
		foreach ($this->get_field_names() as $field_name)
		{
			$this->get_field($field_name)->set_value_source($value_source);
			if ( ! $this->get_field($field_name)->is_submitted())
			{
				continue;
			}
			$submitted_value = $this->get_field($field_name)->get_submitted_value();
			$this->get_field($field_name)->set_value($submitted_value);
			if ( ! $this->get_field($field_name)->is_valid())
			{
				$valid = FALSE;
				$this->set_error($field_name, $this->get_field($field_name)->get_error());
			}
		}

		$this->populate();

		foreach ($this->_plugins as $plugin)
		{
			$plugin->populate($this);
		}

		$valid = ($this->validate() AND $valid);
		foreach ($this->_plugins as $plugin)
		{
			$valid = ($plugin->validate($this) AND $valid);
		}

		if ($valid)
		{
			$this->after_submit();
			foreach ($this->_plugins as $plugin)
			{
				$plugin->after_submit($this);
			}
		}
		$this->after_plugin_submit();

		return $valid;
	}

	protected function populate() {}

	protected function validate() { return TRUE; }

	protected function after_submit() {}

	protected function after_plugin_submit() {}

	public function render()
	{
		return $this->get_renderer()->render($this);
	}

	public function set_method($method)
	{
		$this->_method = strtolower($method);
	}

	public function get_method()
	{
		return $this->_method;
	}

	public function get_value_source()
	{
		if (strtolower($this->get_method()) == 'get')
		{
			return $_GET;
		}
		return $_POST;
	}

	public function set_renderer(CM_Form_Renderer_Abstract $renderer)
	{
		$this->_renderer = $renderer;
	}

	public function get_renderer()
	{
		if (is_null($this->_renderer))
		{
			$this->set_renderer(new CM_Form_Renderer_Default());
		}
		return $this->_renderer;
	}

	public function add_plugin(CM_Form_Plugin_Abstract $plugin)
	{
		$this->_plugins[] = $plugin;
	}

	public function set_error($name, $error)
	{
		$this->get_field($name)->set_error($error);
	}

	public function get_error($name)
	{
		return $this->get_field($name)->get_error();
	}

	public function get_errors()
	{
		$errors = array();

		foreach ($this->get_field_names() as $name)
		{
			if ($error = $this->get_error($name))
			{
				$errors[$name] = $error;
			}
		}

		return $errors;
	}

	public function get_values()
	{
		$values = array();

		foreach ($this->get_field_names() as $name)
		{
			$values[$name] = $this->get_field($name)->get_value();
		}

		return $values;
	}

	public function set_values(array $values)
	{
		foreach ($values as $name => $value)
		{
			$this->get_field($name)->set_value($value);
		}
	}

	public function set_fieldschema(CM_Fieldschema_Interface $fieldschema)
	{
		$this->_fieldschema = $fieldschema;
	}

	/**
	 * @return CM_Fieldschema_Interface
	 */
	private function get_fieldschema()
	{
		if (is_null($this->_fieldschema))
		{
			$this->_fieldschema = new CM_Fieldschema;
		}
		return $this->_fieldschema;
	}

	public function set_field($name, CM_Field $field, $position = NULL)
	{
		$this->get_fieldschema()->set_field($name, $field, $position);
	}

	/**
	 * @return CM_Field
	 */
	public function get_field($name)
	{
		return $this->get_fieldschema()->get_field($name);
	}

	public function has_field($name)
	{
		return $this->get_fieldschema()->has_field($name);
	}

	public function remove_field($name)
	{
		return $this->get_fieldschema()->remove_field($name);
	}

	public function get_field_names()
	{
		return $this->get_fieldschema()->get_field_names();
	}

	public function get_value($field_name)
	{
		return $this->get_field($field_name)->get_value();
	}

	public function get_raw($field_name)
	{
		return $this->get_value($field_name)->get_raw();
	}
}