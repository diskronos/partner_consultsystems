<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Index extends Controller
{
	private $_key = 'xG$%ngh!J';

	public function action_index()
	{
		echo $_POST['name'];
		//echo json_encode(array('status' => 'ok'));
		exit();
	}
//регистрация клиента - 
//	
//  foreign_id => 	ваш id
//  partner_id => id партнера по которому регистрируемся
//	tariff => тариф 

	private function check_certificate()
	{
		$certificate = arr::get($_POST, 'certificate');
		unset($_POST['certificate']);
		return md5(serialize($_POST) . $this->_key) == $certificate;
	}

	public function action_register_client()
	{
		if (!$this->check_certificate())
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}

		$a = ORM::factory('client')
				->values($_POST)
				->save();
		exit();
	}
	
	public function action_register_payment()
	{
		if (!$this->check_certificate())
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		if (orm::factory('money_payment_client')
				->where('transaction_id', '=', $_POST["transaction_id"])
				->find()
				->loaded())
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		$foreign_client_id = arr::get($_POST, 'client_id');
		$client = ORM::factory('client')->where('foreign_id', '=', $foreign_client_id)->find();
		if (!Webconsult_Transaction::client_payment($client->id, arr::get($_POST, 'payment_sum', 0), TRUE, 'holded', arr::get($_POST, 'transaction_id')))
		{
			header('HTTP/1.1 500 Internal Server Error');
		}
		exit();
	}

	public function action_test()
	{
		$a = Vendor_Api::factory()->send_message_client_payment('2', '70000', '68');
		echo $a;
		exit();
	}
}