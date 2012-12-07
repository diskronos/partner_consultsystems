<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Message_Type extends ORM
{
	protected $_table_name = 'message_types';
	
	protected $_grid_columns = array(
		'title' => array(
			'orderable' => false,
		),
		'edit' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-message_type:edit?id=${id}',
			'title' => 'Шаблон',
		),

	);
	
	public function form()
	{
		return new Form_Admin_Message_Type($this);
	}
	
	public function get_template_path()
	{
		return DOCROOT.
				'data'.DIRECTORY_SEPARATOR.
				'templates'.DIRECTORY_SEPARATOR.
				'messages'.DIRECTORY_SEPARATOR .
				$this->template;
	}

}