<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cabinet_Statistics extends Controller_Site_Cabinet 
{

	public function action_index()
	{
		$this->set_view('cabinet/statistics');
	}
}