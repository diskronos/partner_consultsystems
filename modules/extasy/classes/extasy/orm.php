<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Extasy_ORM extends Kohana_ORM implements ArrayAccess
{
	protected $_form_fields = array();

	private $_form = NULL;

	protected $_grid_columns = array();
	protected $_grid_options = array();

	private $_has_many_to_save = array();

	protected $_render_options = array();
	
	/**
	 * Updates all existing records
	 * Т.к. в 3.2.2 этой ф-ции нет, то приходится реализоовывать здесь.
	 *
	 * @chainable
	 * @return  ORM
	 */
	public function save_all()
	{
		$this->_build(Database::UPDATE);

		if (empty($this->_changed))
			return $this;

		$data = array();
		foreach ($this->_changed as $column)
		{
			// Compile changed data omitting ignored columns
			$data[$column] = $this->_object[$column];
		}

		if (is_array($this->_updated_column))
		{
			// Fill the updated column
			$column = $this->_updated_column['column'];
			$format = $this->_updated_column['format'];

			$data[$column] = $this->_object[$column] = ($format === TRUE) ? time() : date($format);
		}

		$this->_db_builder->set($data)->execute($this->_db);

		return $this;
	}

	/**
	 * Tests if a field exists in the database. This can be used as a
	 * Valdidation callback.
	 *
	 * @param   object    Validate object
	 * @param   string    Field
	 * @param   array     Array with errors
	 * @return  array     (Updated) array with errors
	 */
	public function field_available(Validate $array, $field)
	{
		if ($this->loaded() AND ! Arr::get($this->_changed, $field))
		{
			// This value is unchanged
			return TRUE;
		}

		if( ORM::factory($this->object_name())->where($field,'=',$array[$field])->find_all(1)->count() )
		{
			$array->error($field,'field_available');
		}
	}

	/**
	 * @return Form_ORM
	 */
	public function form()
	{
		throw new Exception('Form not implemented');
	}

	public function grid()
	{
		return Grid::factory(clone $this, $this->_grid_columns, $this->_grid_options);
	}

	public function __get($key)
	{
		if(method_exists($this, 'get_'.$key))
		{
			$getter = 'get_'.$key;
			return $this->$getter();
		}
		return parent::__get($key);
	}

	public function get_rendered($key)
	{
		$value = $this[$key];
		return $this->render_value($key, $value);
	}

	public function render_value($key, $value)
	{
		return Arr::path($this->_render_options, $key.'.'.$value, $value);
	}

	public function offsetGet($offset)
	{
		return $this->__get($offset);
	}

	public function offsetSet($offset, $value)
	{
		return $this->__set($offset, $value);
	}

	public function offsetExists($offset)
	{
		return $this->__isset($offset);
	}

	public function offsetUnset($offset)
	{
		return $this->__unset($offset);
	}

	public function start_transaction()
	{
		$this->_db->query(0, 'BEGIN', FALSE);
	}

	public function commit()
	{
		$this->_db->query(0, 'COMMIT', FALSE);
	}

	public function rollback()
	{
		$this->_db->query(0, 'ROLLBACK', FALSE);
	}

	public function allow_edit()
	{
		return TRUE;
	}

	public function allow_delete()
	{
		return TRUE;
	}
}