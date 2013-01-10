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
		$this->message_text = nl2br($this->message_text);
		$this->message_text = preg_replace("#[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]#is", "<a href=\"\\0\">\\0</a>", $this->message_text);
		return parent::save($validation);
	}
	public function get_message_params()
	{
		return array(
			'ticket_id' => '<a href="/' . URL::url_to_route('site-cabinet_support:ticket?id='.$this->branch_id). '">Перейти</a>',
		);
	}
}