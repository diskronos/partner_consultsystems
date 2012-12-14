<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Partner_Requisites_Moderate extends Controller_Crud
{
	protected $_model = 'partner_requisites_legal';

	protected $_group_actions = array(
		'confirm' => array(
			'handler' => 'confirm_routine',
			'title' => 'Принять',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
			
		),
		'delete' => array(
			'handler' => 'delete_routine',
			'title' => 'Отклонить',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
		)
	);

	protected function get_route_name()
	{
		return 'admin-partner_requisites_moderate';
	}

	public function action_create()
	{
		$this->redirect('admin-partner_requisites_moderate:index');
	}

	public function before_fetch(ORM $item) 
	{
		return $item->where('confirmed', '=', 0);
	}

	public function action_confirm()
	{
		$this->confirm_routine(ORM::factory($this->_model, $this->param('id')));
		$this->redirect('admin-partner_requisites_moderate:index');
	}
	
	public function confirm_routine(ORM $item)
	{
		$item->confirmed = 1;
		$item->save();
	}
	public function get_filter_form(ORM $model) 
	{
		return new Form_Admin_Filter_Requisites_Moderate($model);
	}

	protected function process_form(ORM $item)
	{
		$this->set_view('partner_requisites_moderate/crud/edit');

		if (isset($_POST['cancel']))
		{
			$this->redirect($this->get_index_route());
		}

		$form = $item->form();

		if (isset($_POST['submit_and_confirm']) AND $form->submit())
		{
			$this->confirm_routine($item);
			$this->redirect($this->get_index_route());
		}
		
		if (isset($_POST['submit']) AND $form->submit())
		{
			$this->redirect($this->get_index_route());
		}

		$this->template->form = $form;
	}


}