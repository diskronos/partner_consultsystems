<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Controller_Admin_Auth extends Extasy_Auth_Controller_Base
{
	protected $_login_route = 'admin-auth:login';

	public function action_login()
	{
		if ($this->do_login())
		{
			$this->redirect('admin-index');
		}
	}

	public function action_logout()
	{
		if ($this->do_logout())
		{
			$this->redirect('admin-index');
		}
	}

	public function action_change_password()
	{
		$this->set_view('crud/form');

		if ($this->do_change_password())
		{
			$this->redirect('admin-index');
		}
	}

	public function action_reset_password_step_1()
	{
		if ($result = $this->do_reset_password_step_1())
		{
			$email_from = Kohana::$config->load('email.from');

			Email::send($result['email'], $email_from, Kohana::message('email', 'reset_password.admin'), View::factory('email/reset_password/admin', array(
				'code' => $result['code']
			)), FALSE);

			$this->redirect('admin-auth:reset_password_step_1_thankyou');
		}
	}

	public function action_reset_password_step_2()
	{
		if ($this->do_reset_password_step_2())
		{
			$this->redirect('admin-index');
		}
	}
}