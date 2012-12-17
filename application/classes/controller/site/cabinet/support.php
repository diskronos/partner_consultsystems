<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cabinet_Support extends Controller_Site_Cabinet 
{
//	public function before() {
//		parent::before();
//		$this->template->active = 'support';
//	}

	protected function check_existance(ORM $item)
	{
		if (!$item->loaded())
		{
			$this->forward_404();
		}
	}
	protected function check_branch_ownage(ORM $branch)
	{
		if ($branch->starter_id != $this->_user->id)
		{
			$this->forward_403();
		}
	}
	public function action_index()
	{
		$this->set_tdk('Панель партнера - Поддержка');
		$session = Session::instance();

		$form = new Form_Site_Ticket_Branch(ORM::factory('ticket_branch'));

		if ($message = $session->get('ticket_added')) 
		{
			$this->template->message = $message;
			$session->delete('ticket_added');
		}

		if (isset($_POST['submit']) AND $form->submit())
		{
			$session->set('ticket_added', 'Запрос добавлен');
			$this->redirect('site-cabinet_support');
		}

		$ticket_branches = ORM::factory('ticket_branch')
				->select(db::expr('greatest(created_at, ifnull(updated_at, 0)) as last_update'))
				->where('starter_id', '=', $this->_user->id)
				->and_where('status', '=', 'open')
				->order_by('last_update','desc')
				->find_all();

		$this->template->ticket_branches = $ticket_branches;
		$this->template->form = $form;
		$this->set_view('cabinet/support/index');
	}
	
	public function action_ticket()
	{
		$ticket_branch = ORM::factory('ticket_branch', $this->param('id'));
		$this->check_existance($ticket_branch);
		$this->check_branch_ownage($ticket_branch);

		$this->set_tdk('Панель партнера - Поддержка ('. $ticket_branch->topic .')');

		$ticket_branch->new_messages_admin = 0;
		$ticket_branch->save();

		$form = new Form_Site_Ticket_Message($ticket_branch);
		if (isset($_POST['submit']) AND $form->submit())
		{
			$this->redirect('site-cabinet_support:ticket?id=' . $this->param('id'));
		}
		$this->template->branch = $ticket_branch;
		$this->template->messages = $ticket_branch->messages->find_all();
		$this->template->form = $form;
		$this->set_view('cabinet/support/ticket');
	}
	
}