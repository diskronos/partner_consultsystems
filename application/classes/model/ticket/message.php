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
		'branch' => array(
			'model' => 'ticket_branch',
			'foreign_key' => 'branch_id',
		),
	);
	public function save(Validation $validation = NULL)
	{
		$this->message_text = htmlspecialchars($this->message_text, ENT_COMPAT, 'UTF-8', false);
		$this->message_text = nl2br($this->message_text);
		$this->message_text = preg_replace("#[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]#is", "<a href=\"\\0\" target=\"_blank\">\\0</a>", $this->message_text);
		return parent::save($validation);
	}
	public function get_message_params()
	{
		return array(
			'ticket_id' => $this->branch_id,
			'message_text' => $this->message_text,
			'message_date' => date('d.m.Y', $this->created_at),
			'topic' => $this->branch->topic,
		);
	}
}