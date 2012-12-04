<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

abstract class CM_Field_File_Abstract extends CM_Field
{
	protected $_value_class = 'CM_Value_File';

	private $_destination_dir = NULL;

	public function __construct($destination_dir = NULL)
	{
		parent::__construct();
		$this->_destination_dir = $destination_dir;
		$this->configure_destination_dir();
	}

	public function __wakeup()
	{
		parent::__wakeup();
		$this->configure_destination_dir();
	}

	protected function configure_destination_dir()
	{
		if (is_null($this->_destination_dir))
		{
			$this->_destination_dir = $this->get_default_destination_dir();
		}
	}

	public function set_name($name)
	{
		parent::set_name($name);

		// process AJAX requests
		if ($name == arr::get($_GET, 'file_upload'))
		{
			while (ob_get_level())
			{
				ob_end_clean();
			}

			$this->process_upload();

			echo $this->render()
				->set('upload_error', $this->get_error())
				->set('is_ajax', TRUE);

			exit(0);
		}
	}

	public function is_submitted()
	{
		return parent::is_submitted() OR isset($_FILES[$this->get_name().'_file']);
	}

	public function get_submitted_value()
	{
		$filename = arr::get($this->get_value_source(), $this->get_name());

		if (empty($filename))
		{
			return $this->create_raw_value(NULL);
		}

		return $this->create_raw_value($filename);
	}

	public function render_icon()
	{
		return '';
	}

	protected function process_upload()
	{
		$file_index = $this->get_name().'_file';
		switch (arr::get($_FILES[$file_index], 'error'))
		{
			case UPLOAD_ERR_OK:
				$this->set_error(NULL);
				break;
			case UPLOAD_ERR_INI_SIZE:
				$this->set_error('Размер файла превышает максимально допустимый в настройках PHP');
				break;
			case UPLOAD_ERR_NO_FILE:
				$this->set_error('Файл не выбран');
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$this->set_error('Ошибка записи временного файла');
				break;
/*
			case UPLOAD_ERR_FORM_SIZE:
			case UPLOAD_ERR_PARTIAL:
			case UPLOAD_ERR_NO_FILE:
			case UPLOAD_ERR_NO_TMP_DIR:
			case UPLOAD_ERR_EXTENSION:
*/
			default:
				$this->set_error('Ошибка загрузки файла');
		}
		if ($this->get_error())
		{
			return;
		}

		// Пытаемся загрузить файл
		if ( ! is_dir(Kohana::$config->load('file.upload_root')))
		{
			$this->set_error('Директория для загрузки файлов не настроена');
			return;
		}

		$destination_dir = Kohana::$config->load('file.upload_root').'/'.$this->get_destination_dir();
		if ( ! file_exists($destination_dir))
		{
			if ( ! mkdir($destination_dir, 0777, TRUE))
			{
				$this->set_error('Не удалось создать директорию для загрузки файлов');
				return;
			}
		}
		$basename = arr::get($_FILES[$file_index], 'name');

		$extension = pathinfo($basename, PATHINFO_EXTENSION);
		if ( ! empty($extension))
		{
			$basename = preg_replace('#'.$extension.'$#iu', strtolower($extension), $basename);
		}

		// Проверяем тип файла
		if ( ! $this->is_valid_file_type($extension))
		{
			$this->set_error('Недопустимый тип файла');
			return;
		}

		if (file_exists($destination_dir.'/'.$basename))
		{
			$basename_pref = '0';
			while (file_exists($destination_dir.'/'.$basename_pref.'_'.$basename))
			{
				$basename_pref++;
			}
			$basename = $basename_pref.'_'.$basename;
		}

		if ( ! is_writable($destination_dir))
		{
			$this->set_error('Директория для загрузки файлов недоступна для записи');
			return;
		}

		if ( ! move_uploaded_file(arr::get($_FILES[$file_index], 'tmp_name'), $destination_dir.'/'.$basename))
		{
			$this->set_error('Не удалось переместить загруженный файл');
			return;
		}

		// Устанавливаем value в новый файл
		$this->set_value($this->create_raw_value($this->get_destination_dir().'/'.$basename));
	}

	public function get_type_name()
	{
		return 'Файл';
	}

	public function get_allowed_extensions()
	{
		return array();
	}

	public function get_destination_dir()
	{
		return $this->_destination_dir;
	}

	protected function get_default_destination_dir()
	{
		return 'files';
	}

	public function render_additional_inputs()
	{
		return '';
	}

	public function render()
	{
		return View::factory('cm/field/file', array(
			'name' => $this->get_name(),
			'value' => $this->get_value(),
			'field' => $this,
			'upload_error' => NULL,
			'is_ajax' => FALSE
		));
	}

	public function render_value()
	{
		$value = $this->get_value();
		if ($value->is_empty())
		{
			return '';
		}
		return html::anchor($value->get_download_filename(), $value->get_basename());
	}

	public function load_file($filename)
	{
		$this->set_raw_value($filename);
	}

	protected function validate()
	{
		if ($this->get_value()->is_empty())
		{
			return;
		}

		$this->validate_file();
	}

	protected function is_valid_file_type($extension)
	{
		if (count($this->get_allowed_extensions()) == 0)
		{
			return TRUE;
		}
		return in_array(strtolower($extension), $this->get_allowed_extensions());
	}

	protected function validate_file()
	{
		if ( ! $this->is_valid_file_type($this->get_value()->get_extension()))
		{
			$this->set_error('Недопустимый тип файла');
		}
	}

	public function get_description()
	{
		if ($this->get_value()->is_empty())
		{
			return array();
		}

		return array(
			'Загруженный файл' => html::anchor($this->get_value()->get_download_filename()),
			'Тип' => $this->get_value()->get_mime_type(),
			'Размер файла' => text::bytes($this->get_value()->get_size())
		);
	}
}