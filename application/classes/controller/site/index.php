<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Index extends Controller_Site {

	public function action_index()
	{
//		Webconsult_Transaction::client_payment(2, 700);
//		Webconsult_Transaction::client_payment(24, 100);
//		Webconsult_Transaction::client_payment(31, 200);
//		Webconsult_Transaction::client_payment(32, 800);
//		Webconsult_Transaction::client_payment(2, 900);
		$this->set_view('index/index');
	}
}