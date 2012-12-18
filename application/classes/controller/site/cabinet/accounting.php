<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cabinet_Accounting extends Controller_Site_Cabinet 
{
	private $_requisites = NULL;
	public function before()
	{
		parent::before();
		$this->_requisites = $this->_user->requisites;
		$this->template->requisites = $this->_requisites;
	}
	public function get_payout_date()
	{
		$day = date('d');
		$month = date('m');
		$year = date('Y');
		if ($month == 2)
		{
			if ($day > 15 AND $day <= 28) $day = 28;
			else $day = 15;
			if ($day == 29) $month += 1;
		}
		else
		{
			if ($day >15 AND $day <= 30) $day = 30;
			else $day = 15;
			if ($day == 31) $month+= 1;
			
		}
		$this->template->payout_date = date('d.m.Y', mktime(0, 0, 0, $month, $day, $year));
	}

	public function get_stats($start_date = NULL, $final_date = NULL)
	{
		if (is_null($start_date))
		{
			$start_date = time() - 7 * 86400;
			$final_date = time();
		}
		else 
		{
			$start_date = strtotime($start_date . ' 00:00:00');
			$final_date = strtotime($final_date . ' 23:59:59');
		}

		$payments_as_partner = ORM::factory('money_payment_partner')
				->where('partner_id', '=', $this->_user->id)
				->and_where('status', '<>', 'reverted')
				->and_where('created_at', '>=', $start_date)
				->and_where('created_at', '<=', $final_date)
				->find_all();
		
		$payouts = ORM::factory('money_payout')
				->where('partner_id', '=', $this->_user->id)
				->and_where('created_at', '>=', $start_date)
				->and_where('created_at', '<=', $final_date)
				->find_all();

		$this->template->payments_as_partner = $payments_as_partner;

		$this->template->payouts = $payouts;
	}


	public function action_index() 
	{
		$this->set_tdk('Панель партнера - Бухгалтерия');
		$this->set_view('cabinet/accounting/index');
	}
	
	public function action_main_block()
	{
		$this->template->set_layout(NULL);
		$form = new Form_Site_Additional_Datepick();
		$this->template->form = $form;
		if (isset($_POST['from']) && $form->submit())
		{
			$this->get_stats(
					$form->get_field('from')->get_value()->get_raw(),
					$form->get_field('to')->get_value()->get_raw()
					);
		}
		else
		{
			$this->get_stats();
		}
		$this->set_view('cabinet/accounting/main_block');
	}

	public function partner_legal()
	{
		$this->template->requisites_shortnames = ORM::factory('partner_requisites_legal')->requisites_shortnames;
	}
	
	public function partner_individual()
	{
	}

	public function set_payout_block()
	{
		$session = Session::instance();
		$balance = Webconsult_Balance::factory($this->_user->id);

		$balance_available = $balance->get_money_available();

		if ($message = $session->get('payout_query_success')) 
		{
			$this->template->message = $message;
			$session->delete('payout_query_success');
		}

		if (isset($_POST['payout_submit']) AND ($balance_available > 0))
		{
			Webconsult_Transaction::money_payout_query(
				$this->_user->id, 
				$balance_available
			);
			$session->set('payout_query_success', 'Запрос на вывод средств отправлен');
			$this->redirect('site-cabinet_accounting');
		}
		
		$this->template->current_balance = $balance->get_money_balance();
		$this->template->available_balance = $balance_available;
		$this->set_view('cabinet/accounting/payout_block_' . $this->_user->status);
	}

	public function set_requisites_block()
	{
		$status = $this->_user->status;
		
		$form_class = 'Form_Site_Partner_Requisites_' . ucfirst($status);
		$action_name = 'partner_' . $status;
		$requisites = $this->_user->requisites_ORM;
		$form = new $form_class($requisites);

		if (isset($_POST['send_reqs']))
		{
			if (!$form->submit())
			{
				$this->template->form_error = true;
			}
			else 
			{
				$this->redirect('site-cabinet_accounting');
			}
		}
		$this->template->form = $form;
		$this->$action_name();
	}
	
	public function action_additional_block()
	{
		$this->template->set_layout(NULL);

		$this->get_payout_date();
		$this->template->set_layout(NULL);
		$this->set_requisites_block();
		$this->set_payout_block();
		$this->set_view('cabinet/accounting/additional_block_' . $this->_user->status);
	}
}

