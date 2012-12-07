<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Index extends Controller_Site {

	public function action_index()
	{
	//	$this->template->result = Xhtml::get_from_docx_file();
		$this->set_view('index/index');
	}
}