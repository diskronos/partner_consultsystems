<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Registration extends Extasy_Auth_Controller_Base
{

	public function action_logout()
	{
		if(parent::do_logout())
		{
			$this->redirect('site-index');
		}
	}
	protected function set_signup_form()
	{
		$signup_form = new Form_Site_User_Signup(ORM::factory('user'));
		if (isset($_POST['signup']) AND $signup_form->submit())
		{
			parent::do_logout();
			$_POST['login'] = true;
			$_POST['remember'] = false;
			parent::do_login();
			$this->redirect('site-index');
		}
		$this->template->signup_form = $signup_form;
	}
//-------------Виды регистрации--------------------------------------------
	public function action_signup_block()
	{
		$this->set_signup_form();
		$this->set_view('registration/signup_block');
	}

	public function action_signup_form()
	{
		$this->set_signup_form();
		$this->set_view('registration/signup_form');
	}
	
//	public function action_signup_client()
//	{
//		$this->template->referrer_id = Auth::instance()->get_user()->id;
//		$this->template->ref_route = Request::initial()->route()->get_route_str(array());
//		$this->set_view('registration/signup_form');
//	}
	
	public function action_signup()
	{
		$this->template->ref_route = 'site-index';
		$this->set_view('registration/signup_form');
	}
//---------------Виды регистрации---------------------------------------------
	public function action_top_login_block()
	{
		$user = Auth::instance()->get_user();
		if ($user)
		{
			$this->template->user = $user;
			$this->set_view('registration/top_block_logged');
		}
		else
		{
			$this->set_view('registration/top_block_unlogged');
		}
	}
	
	public function action_right_block()
	{
		$user = Auth::instance()->get_user();
		if ($user)
		{
			$this->template->user = $user;
			$this->set_view('registration/right_block_logged');
		}
		else
		{
			$this->set_view('registration/right_block_unlogged');
		}
	}
	
	
	public function action_cabinet_top_block_logged()
	{
		$this->template->user = Auth::instance()->get_user();
	}
//-------------------Восстановление пароля----------------------------------------	
	public function action_reset_password()
	{
		if($data = $this->do_reset_password_step_1())
		{
			Email::send(
					$data["email"], 
					Kohana::$config->load('mailer.from'),
					'Восстановление пароля',
					view::factory('registration/mail_remember_password',array('code'=> $data["code"]))->render(),
					TRUE
			);
			$this->redirect('site-registration:reset_password_step_1_thankyou');
		}	
		$this->set_view('registration/reset_password');
	}

	public function action_reset_password_2()
	{	
		$code = $this->param('code');
		$this->set_view('registration/remember_finish');
		if ( ! $code)
		{
			$this->template->message='Не указан код восстановления';
			return;
		}

		$user = ORM::factory('user', array(
			'reset_password_code' => $code
		));

		if ( ! $user->loaded())
		{
			$this->template->message='Код восстановления недействителен или устарел';
			return;
		}
		$new_password = md5(time());
		$user->password = $new_password;
		$user->reset_password_code = NULL;
		$user->save();
		Email::send(
				$user->email, 
				Kohana::$config->load('mailer.from'),
				'Восстановление пароля',
				view::factory('registration/mail_remember_password_step_2',array('login' => $user->name,'password'=> $new_password))->render(),
				TRUE
			);
		$this->template->message='Вам на почту выслан новый пароль';
	}
//-----------------Ajax проверки при регистрации{----------------------------
	public function action_ajax_check_login()
	{
		if (!Request::$initial->is_ajax()) exit();
		$_POST['email'] = ORM::factory('user')->where('name', '=', $_POST['login'])->find()->email;
		$_POST['remember'] = isset($_POST['remember']);
		echo json_encode(array('result' => parent::do_login()));
		exit;
	}
	
	public function action_ajax_signup_check_login()
	{
		if (!Request::$initial->is_ajax()) exit();
		$login = arr::get($_POST, 'v', '');
		$validation = Validation::factory(array('login' => $login))
			->rule('login', 'not_empty')
			->rule('login', 'min_length', array(':value', 3))
			->rule('login', 'max_length', array(':value', 16))
			->rule('login', 'regex', array(':value', '#^[a-z0-9\pL ]+$#iu'));

		$validation->check();

		if (orm::factory('user')->where('name', '=', $login)->find()->loaded())
		{
			$validation->error('login', 'in_use');
		}

		$errors = $validation->errors('registration');
		echo json_encode(
				array(
					'result' => empty($errors) ? 'valid' : 'error',
					'comment' => empty($errors) ? 'Вы можете использовать этот логин' : $errors['login'],
					)
				);
		exit;
		
	}
	public function action_ajax_signup_check_pass()
	{
		if (!Request::$initial->is_ajax()) exit();
		$password = arr::get($_POST, 'v', '');

		$validation = Validation::factory(array('password' => $password))
			->rule('password', 'not_empty')
			->rule('password', 'min_length', array(':value', 6))
			->rule('password', 'max_length', array(':value', 18));

		$validation->check();
		$errors = $validation->errors('registration');

		echo json_encode(
				array(
					'result' => empty($errors) ? 'valid' : 'error',
					'comment' => empty($errors) ? 'Вы можете использовать этот пароль' : $errors['password'],
					)
				);
		exit;
	}
	
	public function action_ajax_signup_check_pass_confirm()
	{
		if (!Request::$initial->is_ajax()) exit();

		$validation = Validation::factory(array('password' => arr::get($_POST, 'v1', ''), 'password_confirm' => arr::get($_POST, 'v2', '')))
			->rule('password_confirm', 'not_empty')
			->rule('password_confirm', 'min_length', array(':value', 6))
			->rule('password_confirm', 'max_length', array(':value', 18))
			->rule('password_confirm', 'matches', array(':validation', 'password', ':field'));

		$validation->check();
		$errors = $validation->errors('registration');

		echo json_encode(
			array(
				'result' => empty($errors) ? 'valid' : 'error',
				'comment' => empty($errors) ? 'Пароли совпадают' : $errors['password_confirm'],
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

		if (orm::factory('user')->where('email', '=', arr::get($_POST, 'v', ''))->find()->loaded())
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
	
	public function action_ajax_signup_check_name()
	{
		if (!Request::$initial->is_ajax()) exit();

		$name = arr::get($_POST, 'v', '');

		$validation = Validation::factory(array('name' => $name))
			->rule('name', 'not_empty');

		$validation->check();
		$errors = $validation->errors('registration');

		echo json_encode(
			array(
				'result' => empty($errors) ? 'valid' : 'error',
				'comment' => empty($errors) ? 'Имя задано' : $errors['name'],
				)
			);

		exit;
	}
	
	public function action_ajax_proceed_registration()
	{
		$form = new Form_Site_User_Register(ORM::factory('user'));
		if ($is_form_submitted = $form->submit())
		{
			$from = Kohana::$config->load('mailer.from');
			try
			{
				Email::send(
						$_POST['email'], 
						$from,
						'Успешная регистрация',
						View::factory('registration/mail_success_registration', array(
							'fullname' =>  $_POST['fullname'],
							'login' => $_POST['name'],
							'password' => $_POST['password'],
							))->render(),
						True
					);
			}
			catch (ErrorException $e){}
			if (empty($_POST['referrer_id']))
			{
				$_POST['login'] = true;
				$_POST['remember'] = 0;
				$this->do_login();
			}
		}

		echo json_encode(
			array(
				'result' => $is_form_submitted ? 'regsuccess' : 'haveerr',
				)
			);

		exit();
		
	}
}

