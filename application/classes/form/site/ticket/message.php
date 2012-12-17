<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_Ticket_Message extends CM_Form_Abstract
{
	private $_model = NULL;

	protected function construct_form($param) 
	{
		$this->_model = $param;
		$this->set_field('message_text', new CM_Field_Text());
	}

	
	protected function after_submit() 
	{
		$this->_model->new_messages_user += 1;
		$this->_model->save();
	}
	
	protected function after_plugin_submit() 
	{
		$message = ORM::factory('ticket_message');
		$message->author_id = Auth::instance()->get_user()->id;
		$message_text = strip_tags($this->get_field('message_text')->get_value()->get_raw());
		$message->message_text = $message_text;
		$message->branch_id = $this->_model->id;
		$message->save();
	}
}