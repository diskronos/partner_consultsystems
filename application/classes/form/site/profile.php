<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_Profile extends Form_Login_ChangePassword
{
	protected function init()
	{
		$this->add_plugin(new CM_Form_Plugin_ORM(array('password', 'email', 'name', 'fullname'), array(), Model_User::get_password_validation()));

		$this->set_field('name', new CM_Field_Label(), 10);
		$this->set_field('email', new CM_Field_Label(), 20);
		$this->set_field('fullname', new CM_Field_Label(), 30);

		$this->set_field('old_password', new CM_Field_Password(), 40);
		$this->get_field('old_password')->set_label('Старый пароль');

		$this->set_field('password', new CM_Field_Password(), 50);
		$this->set_field('password_confirm', new CM_Field_Password(), 60);
		$this->add_plugin(new CM_Form_Plugin_Labels(
				array(
					'name' => 'Логин',
					'fullname' => 'Контактное лицо/имя',
				)
			)
		);

	}

}

//new Form_Login_ChangePassword();