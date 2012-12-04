<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

abstract class Spreadsheet_Reader implements Iterator, Countable
{
	const TYPE_CSV = 'Csv';
	
	static public function factory($raw_data, $type)
	{
		$class = 'Spreadsheet_Reader_'.$type;
		if ( ! class_exists($class, TRUE))
		{
			throw new Exception('Can not create spreadsheet reader: '.$type.'. Class not found');
		}
		return new $class($raw_data);
	}
	
	static public function create_from_file($filename)
	{
		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$type = self::get_type_by_ext($extension);
		if (is_null($type))
		{
			throw new Exception('Can not determine spreadsheet type');
		}
		
		$raw_data = file_get_contents($filename);
		
		return self::factory($raw_data, $type);
	}
	
	static public function create_from_raw($raw_data, $mime)
	{
		$type = self::get_type_by_mime($mime);
		if (is_null($type))
		{
			throw new Exception('Can not determine spreadsheet type');
		}
		return self::factory($raw_data, $type);
	}
	
	static public function get_type_by_ext($extension)
	{
		switch ($extension)
		{
			case 'csv':
				return self::TYPE_CSV;
				break;
		}
		return NULL;
	}
	
	static public function get_type_by_mime($mime)
	{
		switch ($mime)
		{
			case 'text/x-comma-separated-values':
			case 'application/vnd.ms-excel':
			case 'text/comma-separated-values':
			case 'text/csv':
				return self::TYPE_CSV;
		}
		return NULL;
	}
	
	private $_raw_data = NULL;
	
	private $_parsed_data = NULL;
	
	private $_total_rows  = 0;
	private $_current_row = 0;
	
	protected function __construct($raw_data)
	{
		$this->_raw_data = $raw_data;
		
		$this->_parsed_data = $this->_get_parsed_data();
		$this->_total_rows = count($this->_parsed_data);
	}
	
	public function get_raw_data()
	{
		return $this->_raw_data;
	}
	
	abstract protected function _get_parsed_data();
	
	public function as_array()
	{
		return $this->_parsed_data;
	}
	
	public function count()
	{
		return $this->_total_rows;
	}
	
	public function current()
	{
		return $this->_parsed_data[$this->_current_row];
	}

	public function next()
	{
		++$this->_current_row;
		return $this;
	}

	public function key()
	{
		return $this->_current_row;
	}

	public function valid()
	{
		return $this->_current_row >= 0 AND $this->_current_row < $this->_total_rows;
	}

	public function rewind()
	{
		$this->_current_row = 0;
		return $this;
	}
}