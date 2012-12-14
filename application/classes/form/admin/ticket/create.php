<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Ticket_Create extends CM_Form_Abstract
{
	private $_model = NULL;

	protected function construct_form($param) 
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,array('message_text')));
		$this->set_field('starter_id', new CM_Field_Select_ORM_Autocomplete(ORM::factory('user'), 'name'),10);
		$this->set_field('topic', new CM_Field_String(),20);
		$this->set_field('message_text', new CM_Field_Text(),30);
		$this->get_field('message_text')->set_label('Сообщение');
	}

	
	protected function after_submit() 
	{
		$this->_model->new_messages_admin = 1;
	}
	
	protected function after_plugin_submit() 
	{
		$message = ORM::factory('ticket_message');
		$message->author_id = Auth::instance()->get_user()->id;
		$message->message_text = $this->get_field('message_text')->get_value()->get_raw();
		$message->branch_id = $this->_model->id;
		$message->save();
		
	}
}