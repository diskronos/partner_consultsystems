<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Ticket_Branch extends ORM
{
	protected $_table_name = 'ticket_branches';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);
	protected $_updated_column = array('column' => 'updated_at','format'=>TRUE);
	protected $_has_many = array(
		'messages' => array(
			'model' => 'ticket_message',
			'foreign_key' => 'branch_id',
		),
	);
	
	protected $_belongs_to = array(
		'author' => array(
			'model' => 'user',
			'foreign_key' => 'starter_id',
		),
	);
	
	protected $_grid_columns = array(
		'topic' => NULL,
		'starter_id' => array(
			'type' => 'template',
			'template' => '${author.name}',
		),
		'status' => array(
			'type' => 'template',
			'template' => '${status_rendered}',
		),
		'new_messages' => array(
			'type' => 'template',
			'template' => '${new_messages_rendered}',
		),

		'edit' => array(
			'width' => '80',
			'type' => 'link',
			'route_str' => 'admin-ticket_branch:edit?id=${id}',
			'title' => '${allow_answer}',
		),
		
		'close' => array(
			'width' => '80',
			'type' => 'link',
			'route_str' => 'admin-ticket_branch:close?id=${id}',
			'title' => '${allow_close}',
		),
		'delete' => array(
			'width' => '80',
			'type' => 'link',
			'route_str' => 'admin-ticket_branch:delete?id=${id}',
			'title' => '[х]',
			'confirm' => 'Вы уверены?'
		)

	);

	public function labels()
	{
		return array(
			'topic' => 'Тема',
			'starter_id' => 'Пользователь',
			'status' => 'Статус',
			'new_messages' => 'Новые сообщения',
		);
	}

	public function rules()
	{
		return array(
			'starter_id' => array(				//это ник он же логин
				array('not_empty'),
			),
		);
	}


	public function form()
	{
		return new Form_Admin_Ticket_Branch($this);
	}
	public function create_form()
	{
		return new Form_Admin_Ticket_Create($this);
	}
	
	public function get_message_count()
	{
		return $this->messages->find_all()->count();
	}
	public function get_status_rendered()
	{
		return ($this->status == 'open') ? '<span style="color:green">Открыта</span>' :
			'<span style="color:red">Закрыта</span>';
	}
	public function get_new_messages_rendered()
	{
		return ($this->new_messages_user > 0) ? '<span style="color:red">Есть</span>' :
			'<span style="color:green">Нет</span>';
	}
	
	public function get_allow_close()
	{
		return ($this->status =='closed') ? '': '[Закрыть]';
	}

	public function get_allow_answer()
	{
		return ($this->status =='closed') ? '': '[Ответить]';
	}

	public function save(Validation $validation = NULL)
	{
		$this->topic = htmlspecialchars($this->topic, ENT_COMPAT, 'UTF-8', false);
		return parent::save($validation);
	}


}