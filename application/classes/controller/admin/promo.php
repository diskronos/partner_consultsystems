<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Promo extends Controller_Crud
{
	protected $_group_actions = array();
	protected $_model = 'static_page';

	public function action_create()
	{
		$this->redirect('admin-promo:edit');
	}
	public function action_index()
	{
		$this->redirect('admin-promo:edit');
	}
	public function action_delete()
	{
		$this->redirect('admin-promo:edit');
	}

	public function action_edit()
	{
		$item = ORM::factory($this->_model)->where('page_name', '=', 'promo')->find();

		$this->set_view('crud/form');

		$form = new Form_Admin_Promo($item);

		if (isset($_POST['submit']) AND $form->submit())
		{
			$a = 1;
		}

		$this->template->form = $form;
	}

}