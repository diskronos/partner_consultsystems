<?php

defined('SYSPATH') or die('No direct script access.');


class Controller_Site_Cabinet_Clients extends Controller_Site_Cabinet 
{	
	public function before() {
		parent::before();
		$this->template->active = 'clients';
	}

	public function action_index()
	{
		$clients = $this->_user->clients->find_all();
		$this->template->clients = $clients;
		if ($clients->count())
		{
			$clients_ids = array_keys($clients->as_array('id', NULL));
			$client_payments = db::select('client_id', db::expr('sum(payment_sum) as payed'))
									->from('payments_client')
									->where('status', '<>', 'reverted')
									->and_where('client_id', 'in', DB::expr('( '.implode(',', $clients_ids).' )'))
									->group_by('client_id')
									->execute()
									->as_array('client_id');
			$partner_payments = db::select('client_id', DB::expr('sum(payments_partner.payment_sum) as earned'))
									->from('payments_client')
									->join('payments_partner')
									->on('payments_partner.client_payment_id', '=', 'payments_client.id')
									->where('payments_partner.status', '<>', 'reverted')
									->and_where('payments_client.client_id', 'in', DB::expr('( '.implode(',', $clients_ids).' )'))
									->group_by('client_id')
									->execute()
									->as_array('client_id');
			$this->template->client_payments = $client_payments;
			$this->template->partner_payments = $partner_payments;
		}
		$this->set_view('cabinet/clients/index');
	}
	
	public function action_new()
	{
		$this->template->active = 'clients_new';
		$this->template->partner_id = Auth::instance()->get_user()->id;
		$this->set_view('cabinet/clients/register_client');
	}
	//-----------------Ajax проверки при регистрации{----------------------------
	
	public function action_ajax_signup_check_name()
	{
		if (!Request::$initial->is_ajax()) exit();
		$name = arr::get($_POST, 'v', '');
		$validation = Validation::factory(array('client_name' => $name))
			->rule('client_name', 'not_empty')
			->rule('client_name', 'min_length', array(':value', 3))
			->rule('client_name', 'max_length', array(':value', 16))
			->rule('client_name', 'regex', array(':value', '#^[a-z0-9\pL ]+$#iu'));

		$validation->check();

		if (orm::factory('client')->where('name', '=', $name)->find()->loaded())
		{
			$validation->error('client_name', 'in_use');
		}

		$errors = $validation->errors('registration');
		echo json_encode(
				array(
					'result' => empty($errors) ? 'valid' : 'error',
					'comment' => empty($errors) ? 'Вы можете использовать это имя' : $errors['client_name'],
					)
				);
		exit;
		
	}

	public function action_ajax_signup_check_email()
	{
		if (!Request::$initial->is_ajax()) exit();

		$validation = Validation::factory(array('email' => arr::get($_POST, 'v', '')))
			->rule('email', 'not_empty')
			->rule('email', 'email');
		$validation->check();

		if (orm::factory('client')->where('email', '=', arr::get($_POST, 'v', ''))->find()->loaded())
		{
			$validation->error('email', 'in_use');
		}

		$errors = $validation->errors('registration');

		echo json_encode(
			array(
				'result' => empty($errors) ? 'valid' : 'error',
				'comment' => empty($errors) ? 'Адрес задан' : $errors['email'],
				)
			);

		exit;
		
	}

	public function action_ajax_proceed_registration()
	{
		$form = new Form_Site_User_Client(ORM::factory('client'));
		if ($is_form_submitted = $form->submit())
		{
			$from = Kohana::$config->load('mailer.from');
			try
			{
				Email::send(
						$_POST['email'], 
						$from,
						'Успешная регистрация',
						View::factory('cabinet/clients/mail_success_registration', array(
							'name' =>  $_POST['name'],
							))->render(),
						True
					);
			}
			catch (ErrorException $e){}
		}

		echo json_encode(
			array(
				'result' => $is_form_submitted ? 'regsuccess' : 'haveerr',
				)
			);

		exit();
	}
}