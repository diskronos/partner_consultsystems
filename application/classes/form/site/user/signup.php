<?php defined('SYSPATH') or die('No direct script access.');

 class Form_Site_User_Signup extends CM_Form_Abstract
{
	private $_model = NULL;

	protected function construct_form($param) 
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL, array('password_confirm')));
		$this->set_field('email', new CM_Field_String());
		$this->set_field('name', new CM_Field_String());
		$this->set_field('company_name', new CM_Field_String());
		$this->set_field('password', new CM_Field_Password());
		$this->set_field('password_confirm', new CM_Field_Password());
		$this->add_plugin(new CM_Form_Plugin_Validate(Model_User::get_password_validation()));
	}
	protected function populate() 
        {
            $this->_model->fullname = $this->get_field('name')->get_value()->get_raw();
        }

        protected function after_submit() 
	{
		$this->_model->status = isset($_POST['company_name']) ? 'legal' : 'individual';
		$this->_model->roles = 2;
	}
}