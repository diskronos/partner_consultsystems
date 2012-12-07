<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Partner_Requisites_Edit extends Controller_Admin
{
	public function action_edit()
	{
		$user = orm::factory('user', $this->param('id'));
		if (!$user) $this->forward_404 ();
		
		$model_name = 'partner_requisites_' . $user->status;
		$form_class = 'Form_Admin_Requisites_' . ucfirst($user->status);
		
		$requisites = ORM::factory($model_name)->where('partner_id', '=', $user->id)->find();
		$requisites->partner_id = $user->id;
		$form = new $form_class($requisites);

		if (isset($_POST['cancel']))
		{
			$this->redirect('admin-user');
		}

		if (isset($_POST['submit']) AND $form->submit())
		{
			$this->redirect('admin-user');
		}

		$this->template->form = $form;
	}
}