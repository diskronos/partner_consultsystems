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
		'date_expire' => 'date_expire'
	);
	static $_payment_variables = array(
		'certificate' => 'certificate',
		'client_id' => 'client_id',
		'payment_sum' => 'payment_sum',
		'transaction_id' => 'transaction_id',
	);

	static $_site_variables = array(
		'certificate' => 'certificate',
		'client_id' => 'client_id',
		'url' => 'url',
		'foreign_id' => 'site_id',
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
	
	private function check_certificate_site(&$variables)
	{
		$client_id = arr::get($variables, 'client_id', NULL);
		$foreign_id = arr::get($variables, 'foreign_id', NULL);
		$certificate = arr::get($variables, 'certificate');
		return (md5($client_id .',' . $foreign_id .',' . $this->_key) == $certificate);
	}
	
	private function check_client_for_site(&$variables)
	{
		$client = ORM::factory('client')->where('foreign_id', '=', $variables['client_id'])->find();
		if (!$client->loaded()) return false;
		$variables['client_id'] = $client->id;
		$variables['url'] = urldecode($variables['url']);
		return true;
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
		return (md5($client->name .',' . $client->login .',' . $this->_key) == $certificate);
	}

	private function check_certificate_client_delete($client, &$variables)
	{
		$certificate = arr::get($variables, 'certificate');
		return (md5($client->login .',' . $client->foreign_id .',' . $this->_key) == $certificate);
	}
	
	private function check_certificate_payment_revert(&$variables)
	{
		$transaction_id = arr::get($variables, 'transaction_id', NULL);
		$certificate = arr::get($variables, 'certificate');
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
	//--------------------Клиенты--------------------------
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
	
	protected function delete_client(array $variables)
	{
		$client = ORM::factory('client')
				->where('foreign_id', '=', $variables['foreign_id'])
				->find();

		if (!$client->loaded())
		{
			header('HTTP/1.1 404 Not Found');
			exit();
		}

		if (!$this->check_certificate_client_delete($client, $variables))
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		$client->delete();
		exit();
	}

	//-------------------------Платежи-------------------------
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
	//---------------------------Сайты---------------------
	protected function add_site($variables)
	{
		if (!$this->check_certificate_site($variables))
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}
		if (!$this->check_client_for_site($variables))
		{
			header('HTTP/1.1 404 Not Found');
			exit();
		}
		$site = ORM::factory('client_site')
				->values($variables);
		if (!$this->check($site))
		{
			header('HTTP/1.1 422 Unprocessable Entity');
			echo json_encode($this->_errors);
		}
		else 
		{
			$site->save();
		}
		exit();
	}
	
	protected function update_site($variables)
	{
		if (!$this->check_certificate_site($variables))
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}

		if (!$this->check_client_for_site($variables))
		{
			header('HTTP/1.1 404 Not Found');
			exit();
		}

		$site = ORM::factory('client_site')->where('foreign_id', '=', $variables['foreign_id'])->find();

		if (!$site->loaded())
		{
			header('HTTP/1.1 404 Not Found');
			exit();
		}

		$site->values($variables);

		if (!$this->check($site))
		{
			header('HTTP/1.1 422 Unprocessable Entity');
			echo json_encode($this->_errors);
		}
		else 
		{
			$site->save();
		}
		exit();
	}
	protected  function delete_site($variables)
	{
		if (!$this->check_certificate_site($variables))
		{
			header('HTTP/1.1 403 Forbidden');
			exit();
		}

		$site = ORM::factory('client_site')->where('foreign_id', '=', $variables['foreign_id'])->find();

		if (!$site->loaded())
		{
			header('HTTP/1.1 404 Not Found');
			exit();
		}

		$site->delete();
		exit();
	}

	//---------------------------Actions--------------------
	public function action_client()
	{
		$variables = array_map(function($var) { return arr::get($_GET, $var, NULL);}, self::$_client_variables);
		$this->register_client($variables);
		exit();
	}

	public function action_client_delete()
	{
		$variables = array_map(function($var) { return arr::get($_GET, $var, NULL);}, self::$_client_variables);
		$this->delete_client($variables);
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
	
	public function action_add_site()
	{
		$variables = array_map(function($var) { return arr::get($_GET, $var, NULL);}, self::$_site_variables);
		$this->add_site($variables);
		exit();
	}

	public function action_update_site()
	{
		$variables = array_map(function($var) { return arr::get($_GET, $var, NULL);}, self::$_site_variables);
		$this->update_site($variables);
		exit();
	}

	public function action_delete_site()
	{
		$variables = array_map(function($var) { return arr::get($_GET, $var, NULL);}, self::$_site_variables);
		$this->delete_site($variables);
		exit();
	}
	
}