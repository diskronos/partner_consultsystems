<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ticket_Branch extends Controller_Crud
{
	//protected $_group_actions = array();
	protected $_model = 'ticket_branch';

	protected $_group_actions = array(
		'close' => array(
			'handler' => 'close_routine',
			'title' => 'Закрыть',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
			
		),
		'delete' => array(
			'handler' => 'delete_routine',
			'title' => 'Удалить',
			'confirm' => 'Вы уверены?',
			'one_item' => TRUE
		)
	);

	public function action_close()
	{
		$this->close_routine(ORM::factory($this->_model, $this->param('id')));
		$this->redirect('admin-ticket_branch:index');
	}
	
	public function close_routine(ORM $item)
	{
		$item->status = 'closed';
		$item->new_messages_user = 0;
		$item->save();
	}
	
	public function action_edit()
	{
		parent::action_edit();
		$branch = ORM::factory($this->_model, $this->param('id'));
		$branch->new_messages_user = 0;
		$branch->save();
		$this->template->messages = $branch->messages->find_all();

		if (isset($_POST['close']))
		{
			$this->redirect('admin-ticket_branch:close?id='.$this->param('id'));
		}

	}

	
//	public function action_create()
//	{
//		$this->redirect('admin-partner_group:index');
//	}
//	
//	public function action_delete()
//	{
//		$this->redirect('admin-partner_group:index');
//	}
//	public function action_edit()
//	{
//		$this->redirect('admin-partner_group:index');
//	}

}