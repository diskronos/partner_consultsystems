<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Index extends Controller
{
	private $_key = 'xG$%ngh!J';
	private $_errors = array();

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
//417 Expectation Failed
	//422 Unprocessable Entity
	//456 Unrecoverable Error
	private function check_certificate()
	{
		$_POST = array_map(function($var){return empty($var) ? NULL : $var;}, $_POST);//пост идейно не передает null
		$certificate = arr::get($_POST, 'certificate');
		unset($_POST['certificate']);
		return (md5(serialize($_POST) . $this->_key) == $certificate);
	}
	
	protected function check(ORM $model)
	{
		try
		{
			$model->check();
		}
		catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors('validation');
			if ($external = arr::get($errors, '_external'))
			{
				$errors = arr::merge($errors, $external);
				unset($errors['_external']);
			}
			$this->_errors = $errors;
			return FALSE;
		}
		return true;
	}

	public function action_register_client()
	{
		if (!$this->check_certificate())
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		
		$client = ORM::factory('client')
				->values($_POST);
		if (!$this->check($client))
		{
			header('HTTP/1.1 422 Unprocessable Entity');
			echo json_encode($this->_errors);
		}
		else 
		{
			$client->save();
		}
		exit();
	}
	
	public function action_register_payment()
	{
		if (!$this->check_certificate())
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		$validation = Validation::factory($_POST)
					->rule('client_id', 'numeric', NULL)
					->rule('client_id', 'not_empty', NULL)
					->rule('transaction_id', 'numeric', NULL)
					->rule('transaction_id', 'not_empty', NULL)
					->rule('payment_sum', 'numeric', NULL)
					->rule('payment_sum', 'not_empty', NULL);
		if (!$validation->check())
		{
			header('HTTP/1.1 422 Unprocessable Entity');
			echo json_encode($validation->errors('validation'));
			exit();
		}
		
		if (orm::factory('money_payment_client')
				->where('transaction_id', '=', $_POST["transaction_id"])
				->find()
				->loaded())
		{
			header('HTTP/1.1 422 Unprocessable Entity');
			echo json_encode(array('transaction_id' => "Транзакция уже учтена"));
			exit();
		}
		$foreign_client_id = arr::get($_POST, 'client_id');
		$client = ORM::factory('client')->where('foreign_id', '=', $foreign_client_id)->find();
		
		if (!$client->loaded())
		{
			header('HTTP/1.1 422 Unprocessable Entity');
			echo json_encode(array('client_id' => "Id указан неверно"));
			exit();
		}
		if (!Webconsult_Transaction::client_payment($client->id, arr::get($_POST, 'payment_sum', 0), TRUE, 'holded', arr::get($_POST, 'transaction_id')))
		{
			header('HTTP/1.1 456 Unrecoverable Error');//мускул грохнулся
		}
		exit();
	}

	public function action_test()
	{
		//$a = Vendor_Api::factory()->send_message_client_registered('200', '234', 'sadf','gfdhnameasdf', 'fg@asd.dd');
		$a = Vendor_Api::factory()->send_message_client_payment('12', '324', '234123');
		echo $a;
		exit();
	}
}