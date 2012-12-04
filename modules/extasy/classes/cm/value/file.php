<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class CM_Value_File implements CM_Value_Interface
{
	protected $_file = NULL;

	public function __construct($raw_value = NULL)
	{
		if ( ! is_null($raw_value) AND ! empty($raw_value))
		{
			$filename = Kohana::$config->load('file.upload_root').'/'.$raw_value;

			if (
				realpath($filename) // Also checks if file exists
				AND
				// Checks if file in upload root
				strpos(realpath($filename), realpath(Kohana::$config->load('file.upload_root'))) === 0
			)
			{
				$this->_file = $raw_value;
			}
		}
	}

	public function is_empty()
	{
		return ! (bool) $this->_file;
	}

	public function get_raw()
	{
		return $this->_file;
	}

	public function get_mime_type()
	{
		if ($this->is_empty())
		{
			return NULL;
		}
		return File::mime_by_ext($this->get_extension());
	}

	public function get_size()
	{
		if ($this->is_empty())
		{
			return NULL;
		}
		return filesize($this->get_filename());
	}

	public function get_basename()
	{
		if ($this->is_empty())
		{
			return NULL;
		}
		return strtolower(pathinfo($this->get_filename(), PATHINFO_BASENAME));
	}

	public function get_extension()
	{
		if ($this->is_empty())
		{
			return NULL;
		}
		return strtolower(pathinfo($this->get_filename(), PATHINFO_EXTENSION));
	}

	public function get_filename()
	{
		if ($this->is_empty())
		{
			return NULL;
		}
		return Kohana::$config->load('file.upload_root').'/'.$this->_file;
	}

	public function get_download_filename()
	{
		if ($this->is_empty())
		{
			return NULL;
		}
		return $this->_file;
	}

	public function is_valid()
	{
		return TRUE;
	}

	public function __toString()
	{
		return $this->get_raw();
	}

	public function rename($new_name)
	{
		$new_name = Text::filename($new_name);

		if ($this->is_empty())
		{
			throw new Exception('Can not rename not uploaded file');
		}

		$directory = dirname($this->get_filename());

		$extension = $this->get_extension();

		if (realpath($this->get_filename()) === realpath($directory.'/'.$new_name.'.'.$extension))
		{
			return;
		}

		if ( ! copy($this->get_filename(), $directory.'/'.$new_name.'.'.$extension))
		{
			throw new Exception('Can not copy file');
		}

		unlink($this->get_filename());

		$this->_file = dirname($this->get_download_filename()).'/'.$new_name.'.'.$extension;
	}

	public function relocate($new_directory)
	{
		if ($this->is_empty())
		{
			throw new Exception('Can not relocate not uploaded file');
		}

		$new_directory_path = Kohana::$config->load('file.upload_root').'/'.$new_directory;

		if ( ! file_exists($new_directory_path))
		{
			mkdir($new_directory_path, 0777, TRUE);
		}

		if ( ! is_dir($new_directory_path) OR ! realpath($new_directory_path))
		{
			throw new Exception('Wrong directory');
		}

		if (strpos(realpath($new_directory_path), realpath(Kohana::$config->load('file.upload_root'))) !== 0)
		{
			throw new Exception('New directory must be within upload root');
		}

		if (realpath($this->get_filename()) === realpath($new_directory_path.'/'.$this->get_basename()))
		{
			// same destination
			return;
		}

		if ( ! copy($this->get_filename(), $new_directory_path.'/'.$this->get_basename()))
		{
			throw new Exception('Can not copy file');
		}

		unlink($this->get_filename());

		$this->_file = $new_directory.'/'.$this->get_basename();
	}
}