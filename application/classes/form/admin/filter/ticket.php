<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Filter_Ticket extends CM_Form_Abstract
{
	protected function  construct_form($param) {
		$this->_model_obj = $param;

		//категория, название, урл, статус, владелец.
		$this->set_method('get');
		$this->add_plugin(new CM_Form_Plugin_ORM_Labels());

		$this->add_plugin(new CM_Form_Plugin_ORM_Filter_Equals('status', TRUE, TRUE));
		$this->add_plugin(new CM_Form_Plugin_ORM_Filter_Iszero('new_messages_user'));
		$this->add_plugin(new CM_Form_Plugin_ORM_Filter_Equals('starter_id'));
		$this->set_field('starter_id', new CM_Field_Select_ORM_Autocomplete(ORM::factory('user'), 'name'), 10);
		$this->set_field('status', new CM_Field_Select(array('open' => 'Открыта', 'closed' => 'Закрыта')), 20);
		$this->set_field('new_messages_user', new CM_Field_Boolean(), 30);
		$this->get_field('new_messages_user')->set_label('Hoвые сообщения');
	}
}