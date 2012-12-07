<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cabinet_Accounting extends Controller_Site_Cabinet 
{

	public function action_index() 
	{
		$this->set_view('cabinet/accounting/index');
	}
	
	public function action_main_block()
	{
		$this->template->set_layout(NULL);
		$this->set_view('cabinet/accounting/main_block');
	}

	public function partner_legal()
	{
		$this->template->requisites_shortnames = ORM::factory('partner_requisites_legal')->requisites_shortnames;
	}
	
	public function partner_individual()
	{
	}

	public function action_requisites_block()
	{
		$this->template->set_layout(NULL);
		$status = $this->_user->status;
		
		$model_name = 'partner_requisites_' . $status;
		$form_class = 'Form_Site_Partner_Requisites_' . ucfirst($status);
		$action_name = 'partner_' . $status;
		$view_name = 'cabinet/accounting/requisites_block_' . $status;

		$requisites = ORM::factory($model_name);
		$form = new $form_class($requisites);

		if (isset($_POST['send_reqs']))
		{
			if (!$form->submit())
			{
				$this->template->form_error = true;
			}
		}
		$this->template->form = $form;
		$this->$action_name();
		$this->set_view($view_name);
	}
}

