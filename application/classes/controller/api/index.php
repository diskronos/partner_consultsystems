<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Index extends Controller
{
	private $_key = 'xG$%ngh!J';
	private $_errors = array();
	static $_client_variables = array(
		'certificate' => 'certificate',
		'partner_id' => 'partner_id',
		'foreign_id' => 'client_id',
		'name' => 'name',
		'login' => 'login',
		'email' => 'email',
		'site' => 'site',
		'tariff'=>'tariff',
	);
	static $_payment_variables = array(
		'certificate' => 'certificate',
		'client_id' => 'client_id',
		'payment_sum' => 'payment_sum',
		'transaction_id' => 'transaction_id',
	);

	public function action_index()
	{
		header('HTTP/1.1 404 Not Found');
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
	private function check_certificate_client(&$variables)
	{
		$partner_id = arr::get($variables, 'partner_id', NULL);
		$login = arr::get($variables, 'login', NULL);
		$certificate = arr::get($variables, 'certificate');
		return (md5($partner_id .',' . $login .',' . $this->_key) == $certificate);
	}
	
	private function check_certificate_payment(&$variables)
	{
		$client_id = arr::get($variables, 'client_id', NULL);
		$transaction_id = arr::get($variables, 'transaction_id', NULL);
		$certificate = arr::get($variables, 'certificate');
		return (md5($client_id .',' . $transaction_id .',' . $this->_key) == $certificate);
	}

	private function check_certificate_client_update($client, &$variables)
	{
		$certificate = arr::get($variables, 'certificate');
	//	var_dump(md5($client->name .',' . $client->login .',' . $this->_key));
		return (md5($client->name .',' . $client->login .',' . $this->_key) == $certificate);
	}
	
	private function check_certificate_payment_revert(&$variables)
	{
		$transaction_id = arr::get($variables, 'transaction_id', NULL);
		$certificate = arr::get($variables, 'certificate');
	//	var_dump(md5($transaction_id . ',' . $this->_key));
		return (md5($transaction_id . ',' . $this->_key) == $certificate);
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

	protected function register_client(array $variables)
	{
		if (!$this->check_certificate_client($variables))
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		
		$client = ORM::factory('client')
				->values($variables);
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

	protected function update_client(array $variables)
	{
		$client = ORM::factory('client')
				->where('foreign_id', '=', $variables['foreign_id'])
				->find();
		if (!$client->loaded())
		{
			header('HTTP/1.1 404 Not Found');
			exit();
		}

		if (!$this->check_certificate_client_update($client, $variables))
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		
		$client->values($variables);

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

	
	protected function register_payment(array $variables)
	{
		if (!$this->check_certificate_payment($variables))
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		$validation = Validation::factory($variables)
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
				->where('transaction_id', '=', $variables["transaction_id"])
				->find()
				->loaded())
		{
			header('HTTP/1.1 422 Unprocessable Entity');
			echo json_encode(array('transaction_id' => "Транзакция уже учтена"));
			exit();
		}
		$foreign_client_id = arr::get($variables, 'client_id');
		$client = ORM::factory('client')->where('foreign_id', '=', $foreign_client_id)->find();
		
		if (!$client->loaded())
		{
			header('HTTP/1.1 422 Unprocessable Entity');
			echo json_encode(array('client_id' => "Id указан неверно"));
			exit();
		}
		if (!Webconsult_Transaction::client_payment($client->id, arr::get($variables, 'payment_sum', 0), TRUE, 'holded', arr::get($variables, 'transaction_id')))
		{
			header('HTTP/1.1 456 Unrecoverable Error');//мускул грохнулся
		}
		exit();
	}
	
	protected function revert_payment($variables)
	{
		$transaction_id = arr::get($variables, 'transaction_id', -1);
		$payment = ORM::factory('money_payment_client')
				->where('transaction_id', '=', $transaction_id)
				->find();
		if (!$payment->loaded())
		{
			header('HTTP/1.1 404 Not Found');
			exit();
		}

		if (!$this->check_certificate_payment_revert($variables))
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		if (!Webconsult_Transaction::money_back($transaction_id))
		{
			header('HTTP/1.1 456 Unrecoverable Error');//мускул грохнулся
		}
		exit;
	}

	public function action_client()
	{
		$variables = array_map(function($var) { return arr::get($_GET, $var, NULL);}, self::$_client_variables);
		$this->register_client($variables);
		exit();
	}

	public function action_payment()
	{
		$variables = array_map(function($var) { return arr::get($_GET, $var, NULL);}, self::$_payment_variables);
		$this->register_payment($variables);
		exit();
	}
	public function action_client_update()
	{
		$variables = $_GET;
		$variables['foreign_id'] = $variables['client_id'];
		$this->update_client($variables);
		exit();
	}
	public function action_payment_revert()
	{
		$variables = $_GET;
		$this->revert_payment($variables);
		exit();
	}
}