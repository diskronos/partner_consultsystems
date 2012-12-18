<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Ticket_Message extends ORM
{
	protected $_table_name = 'ticket_messages';
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);
	
	protected $_belongs_to = array(
		'author' => array(
			'model' => 'user',
			'foreign_key'=> 'author_id',
		),
	);
	public function save(Validation $validation = NULL)
	{
		$this->message_text = htmlspecialchars($this->message_text, ENT_COMPAT, 'UTF-8', false);
		return parent::save($validation);
	}
}