<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Index extends Controller_Site {

	public function action_index()
	{
		//Webconsult_Transaction::client_payment(2, 700);
//		var_dump($a);die();
		$this->set_view('index/index');
	}
}