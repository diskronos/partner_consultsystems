<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Description of response
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Result_File extends Download_Result
{

	protected $filename;

	public function __construct($filename)
	{
		$this->filename = $filename;
	}

	public function get_filename()
	{
		return $this->filename();
	}

	public function get_contents()
	{
		return file_get_contents($this->filename);
	}
}