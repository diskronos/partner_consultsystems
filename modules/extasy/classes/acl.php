<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class ACL extends Extasy_ACL
{
	protected function init() 
	{
		$this->add_role('user', 'logged');

		$this->add_resource('site_registration','admin_auth');

		$this->allow('guest','site_registration',array(
			'top_login_block',
			'right_login_block',
			'ajax_check_login',
			'signup_block',
			'signup',
			'reset_password',
			'reset_password_1_thankyou',
			'reset_password_2',
			'logout',
			'ajax_signup_check_login',
			'ajax_signup_check_pass',
			'ajax_signup_check_pass_confirm',
			'ajax_signup_check_email',
			'ajax_signup_check_name',
			'ajax_proceed_registration',
			'reset_password',
			)
		);
		$this->allow('logged', 'site_registration',array('cabinet_top_block_logged', 'signup_client'));
		$this->deny('logged','site_registration',array('signup'));

		$this->add_resource('ajexfilemanager','admin_auth');	
		$this->allow('logged','ajexfilemanager',array('index','ajax'));

		$this->add_resource('site_cabinet_clients','admin_auth');
		$this->allow('logged','site_cabinet_clients',array(
			'index',
			'new',
			'ajax_signup_check_name',
			'ajax_signup_check_pass',
			'ajax_signup_check_pass_confirm',
			'ajax_signup_check_email',
			'ajax_proceed_registration',
		));

		$this->add_resource('site_cabinet_statistics','admin_auth');
		$this->allow('logged','site_cabinet_statistics',array(
			'index'
		));

		$this->add_resource('site_cabinet_accounting','admin_auth');
		$this->allow('logged','site_cabinet_accounting',array(
			'index',
			'main_block',
			'requisites_block',
			'payout_block',
			'additional_block'
		));

		$this->add_resource('site_cabinet_support','admin_auth');
		$this->allow('logged','site_cabinet_support',array(
			'index',
			'ticket'
		));
		
		$this->add_resource('site_cabinet','admin_auth');
		$this->allow('logged','site_cabinet',array(
			'index',
			'main_block',
			'materials',
			'profile'
			
		));
	}
}