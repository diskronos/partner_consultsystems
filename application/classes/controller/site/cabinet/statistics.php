<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cabinet_Statistics extends Controller_Site_Cabinet 
{

	public function action_index()
	{
		$balance = Webconsult_Balance::factory($this->_user->id);
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
		$this->template->balance = $balance;
		$this->set_view('cabinet/statistics');
	}
	
	public function get_stats($start_date = NULL, $final_date = NULL)
	{
		if (is_null($start_date))
		{
			$start_date = date('d.m.Y', time() - 7 * 86400);
			$final_date = date('d.m.Y');
		}
		
		$dates = array();
		$temp_date = $start_date;
		$dates[$temp_date] = 0;
		while ($temp_date != $final_date)
		{
			$temp_date = date('d.m.Y', strtotime($temp_date) + 86400);
			$dates[$temp_date] = 0;
		}
		
		///регистрации
		$registered = db::select(
						DB::expr('count(*) as number_registered'), 
						DB::expr('DATE_FORMAT(FROM_UNIXTIME(created_at), \'%d.%m.%Y\') as date')
					)
				->from('users')
				->where('referrer_id', '=', $this->_user->id)
				->and_where('created_at', '>=', date(strtotime($start_date)))
				->and_where('created_at', '<=', date(strtotime($final_date)))
				->group_by('date')
				->execute()
				->as_array('date', 'number_registered');
		
		//платежи
		
		$client_ids = array_keys($this->_user->clients->find_all()->as_array('id', NULL));
		if (!empty($client_ids))
		{

		$payed = db::select(
						DB::expr('sum(beneficiary_account_balance) as total_payed'), 
						DB::expr('DATE_FORMAT(FROM_UNIXTIME(created_at), \'%d.%m.%Y\') as date')
					)
				->from('transactions')
				->where('payer_id', 'in', db::expr('('.implode(',',$client_ids).')'))
				->and_where('created_at', '>=', date(strtotime($start_date)))
				->and_where('created_at', '<=', date(strtotime($final_date)))
				->group_by('date')
				->execute()
				->as_array('date', 'total_payed');
		
		//заработано
		
		$earned= db::select(
						DB::expr('sum(beneficiary_account_balance) + sum(beneficiary_account_hold_balance) as total_payed'), 
						DB::expr('DATE_FORMAT(FROM_UNIXTIME(created_at), \'%d.%m.%Y\') as date')
					)
				->from('transactions')
				->where('beneficiary_id', '=', $this->_user->id)
				->and_where('created_at', '>=', date(strtotime($start_date)))
				->and_where('created_at', '<=', date(strtotime($final_date)))
				->group_by('date')
				->execute()
				->as_array('date', 'total_payed');
		}
		else
		{
			$payed = array(); 
			$earned = array();
		
		}
		$registered = array_merge($dates, $registered);
		$payed = array_merge($dates, $payed);
		$earned = array_merge($dates, $earned);
		$this->template->registered = $registered;
		$this->template->payed = $payed;
		$this->template->earned = $earned;
		
		$this->template->graph_dates = json_encode(array_keys($dates));
		$this->template->graph_earned = json_encode(array_values($earned), JSON_NUMERIC_CHECK);
		$this->template->graph_payed = json_encode(array_values($payed), JSON_NUMERIC_CHECK);
	}
	
}