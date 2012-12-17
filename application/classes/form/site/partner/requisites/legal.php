<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Site_Partner_Requisites_Legal extends CM_Form_Abstract //legal - юридическое лицо
{
	//CREATE TABLE `legal_requisites` (
//	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//	`partner_id` INT(10) UNSIGNED NOT NULL,
//	`individual_number` VARCHAR(15) NOT NULL,
//	`reason_registration_code` VARCHAR(15) NOT NULL,
//	`bank` VARCHAR(100) NOT NULL,
//	`bank_identification_code` VARCHAR(20) NOT NULL,
//	`payment_account` VARCHAR(20) NOT NULL,
//	`legal_address` VARCHAR(100) NOT NULL,
//	`represented` VARCHAR(50) NOT NULL,
//	`on_authority` VARCHAR(50) NOT NULL,
//	`fullname` VARCHAR(50) NOT NULL,
//	`confirmed` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
//	PRIMARY KEY (`id`),
//	INDEX `legal_requisites_partner_fk1` (`partner_id`),
//	CONSTRAINT `legal_requisites_partner_fk1` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
//)
//COLLATE='utf8_general_ci'
//ENGINE=InnoDB;
	private $_model = NULL;

	public function construct_form($param)
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,NULL));
		foreach (array_keys($this->_model->requisites_names) as $requsite_name)
		{
			$field_class = $this->_model->loaded() ? 'CM_Field_Label' : 'CM_Field_String';
			$this->set_field($requsite_name, new $field_class());
		}
	}
	
	public function after_submit() 
	{
		$this->_model->partner_id = Auth::instance()->get_user()->id;
	}
	
}