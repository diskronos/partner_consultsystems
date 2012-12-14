<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Ticket_Branch extends CM_Form_Abstract 
{
	private $_model = NULL;

	public function construct_form($param)
	{
		$this->_model = $param;
		$this->set_field('message_text', new CM_Field_Text());
		$this->get_field('message_text')->set_label('Ответ');
	}

	protected function after_submit() 
	{
		$this->_model->new_messages_admin += 1;
		$this->_model->save();
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