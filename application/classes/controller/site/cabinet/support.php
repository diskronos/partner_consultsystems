<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cabinet_Support extends Controller_Site_Cabinet 
{
	public function before() {
		parent::before();
		$this->template->active = 'support';
	}

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

		$form = new Form_Site_Ticket_Branch(ORM::factory('ticket_branch'));
		if (isset($_POST['submit']) AND $form->submit())
		{
			$a = 1;
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

		$ticket_branch->new_messages_admin = 0;

		$form = new Form_Site_Ticket_Message($ticket_branch);
		if (isset($_POST['submit']) AND $form->submit())
		{
			$a = 1;
		}
		$this->template->branch = $ticket_branch;
		$this->template->messages = $ticket_branch->messages->find_all();
		$this->template->form = $form;
		$this->set_view('cabinet/support/ticket');
	}
	
//	public function action_new()
//	{
//		$this->set_view('cabinet/clients/register_client');
//	}
}