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
//		if (is_null($start_date))
//		{
//			$start_date = date('d.m.Y', time() - 7 * 86400);
//			$final_date = date('d.m.Y');
//		}
//		
//		$dates = array();
//		$temp_date = $start_date;
//		$dates[$temp_date] = 0;
//		while ($temp_date != $final_date)
//		{
//			$temp_date = date('d.m.Y', strtotime($temp_date) + 86400);
//			$dates[$temp_date] = 0;
//		}
//		
//		///регистрации
//		$registered = db::select(
//						DB::expr('count(*) as number_registered'), 
//						DB::expr('DATE_FORMAT(FROM_UNIXTIME(created_at), \'%d.%m.%Y\') as date')
//					)
//				->from('users')
//				->where('referrer_id', '=', $this->_user->id)
//				->and_where('created_at', '>=', date(strtotime($start_date)))
//				->and_where('created_at', '<=', date(strtotime($final_date)))
//				->group_by('date')
//				->execute()
//				->as_array('date', 'number_registered');
//		
//		//платежи
//		
//		$client_ids = array_keys($this->_user->clients->find_all()->as_array('id', NULL));
//
//		$payed = db::select(
//						DB::expr('sum(beneficiary_account_balance) as total_payed'), 
//						DB::expr('DATE_FORMAT(FROM_UNIXTIME(created_at), \'%d.%m.%Y\') as date')
//					)
//				->from('transactions')
//				->where('payer_id', 'in', db::expr('('.implode(',',$client_ids).')'))
//				->and_where('created_at', '>=', date(strtotime($start_date)))
//				->and_where('created_at', '<=', date(strtotime($final_date)))
//				->group_by('date')
//				->execute()
//				->as_array('date', 'total_payed');
//		
//		//заработано
//		
//		$earned= db::select(
//						DB::expr('sum(beneficiary_account_balance) + sum(beneficiary_account_hold_balance) as total_payed'), 
//						DB::expr('DATE_FORMAT(FROM_UNIXTIME(created_at), \'%d.%m.%Y\') as date')
//					)
//				->from('transactions')
//				->where('beneficiary_id', '=', $this->_user->id)
//				->and_where('created_at', '>=', date(strtotime($start_date)))
//				->and_where('created_at', '<=', date(strtotime($final_date)))
//				->group_by('date')
//				->execute()
//				->as_array('date', 'total_payed');
//		$registered = array_merge($dates, $registered);
//		$payed = array_merge($dates, $payed);
//		$earned = array_merge($dates, $earned);
//		$this->template->registered = $registered;
//		$this->template->payed = $payed;
//		$this->template->earned = $earned;
//		
//		$this->template->graph_dates = json_encode(array_keys($dates));
//		$this->template->graph_earned = json_encode(array_values($earned), JSON_NUMERIC_CHECK);
//		$this->template->graph_payed = json_encode(array_values($payed), JSON_NUMERIC_CHECK);
	}


	public function action_index() 
	{
		$this->set_view('cabinet/accounting/index');
	}
	
	public function action_main_block()
	{
		$this->template->set_layout(NULL);
		$form = new Form_Site_Additional_Datepick();
		$this->template->form = $form;
		if (isset($_POST['from']) && $form->submit())
		{
//			$this->get_stats(
//					$form->get_field('from')->get_value()->get_raw(),
//					$form->get_field('to')->get_value()->get_raw()
//					);
		}
		else
		{
	//		$this->get_stats();
		}
		//$this->template->balance = $balance;

		$this->set_view('cabinet/accounting/main_block');
	}

	public function partner_legal()
	{
		$this->template->requisites_shortnames = ORM::factory('partner_requisites_legal')->requisites_shortnames;
	}
	
	public function partner_individual()
	{
	}

	public function show_requisites_block()
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
	
	public function show_payout_block()
	{
		$balance = Webconsult_Balance::factory($this->_user->id);
		$form = new Form_Site_Partner_Payout(
				ORM::factory('money_payout'));
		if (isset($_POST['payout_sum']))
		{
			if (!$form->submit())
			{
				$this->template->form_error = 'Неверно введена сумма';
			}
			else
			{
				$this->template->form_warning = 'Запрос отправлен';
			}
		}
		
		$this->template->balance = $balance;
		$this->template->form_payout = $form;
		$this->set_view('cabinet/accounting/payout_block_' . $this->_user->status);
	}
	
	
	public function action_additional_block()
	{
		$this->get_payout_date();
		$this->template->set_layout(NULL);
		if (($this->_requisites) AND ($this->_requisites->confirmed))
		{
			$this->show_payout_block();
		}
		else
		{
			$this->show_requisites_block();
		}
	}
}

