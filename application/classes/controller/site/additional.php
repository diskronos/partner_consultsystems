<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Additional extends Controller
{
	public function action_site_menu_top()
	{
		$this->set_view('additional/site_menu_top');
	}
	public function action_cabinet_menu_top()
	{
		$this->template->active = '';
		$controller = Request::$initial->controller();
		$action = Request::$initial->action();
		if ($controller == 'cabinet_statistics')
		{
			$this->template->active = 'statistics';
		}
		elseif (($controller == 'cabinet_clients') AND ($action == 'new'))
		{
			$this->template->active = 'clients_new';
		}
		elseif (($controller == 'cabinet') AND ($action == 'materials'))
		{
			$this->template->active = 'materials';
		}
		elseif (($controller == 'cabinet_clients') AND ($action == 'index'))
		{
			$this->template->active = 'clients';
		}
		elseif ($controller == 'cabinet_accounting')
		{
			$this->template->active = 'accounting';
		}
		elseif ($controller == 'cabinet_support')
		{
			$this->template->active = 'support';
		}
	}
}