<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Description of response
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Result_Variable extends Download_Result
{
	protected $content;

	public function load($info, $content, $error_code)
	{
		parent::load($info, $content, $error_code);
		$this->content = $content;
	}

	public function get_contents()
	{
		return $this->content;
	}
}