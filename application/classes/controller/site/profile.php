<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Profile extends Controller_Site {

	public function action_index()
	{
		$user = Auth::instance()->get_user();
		if (!$user)
		{
			$this->redirect('site-index');
		}
		$form = new Form_Login_ChangePassword($user);
		
		if (isset($_POST["submit"]) AND $form->submit())
		{
			$this-> template->message = 'Пароль успешно изменен';
		}
		$this->template->user = $user;
		$this->template->form = $form;
		
	}
}