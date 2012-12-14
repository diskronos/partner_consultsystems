<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cabinet extends Controller_Auth
{
	protected $_user = FALSE;
	public function before() 
	{
		parent::before();
		$this->_user = Auth::instance()->get_user();
		$this->template->set_layout('global/global_cabinet');

		$this->template->user = $this->_user;
		$this->template->group = new Helper_Group($this->_user->money_earned, $this->_user->partner_group_id);
	}
	
	public function action_index()
	{
		$this->redirect('site-cabinet_statistics');
//		$this->set_view('index/index');
	}
	public function action_materials()
	{
		$this->template->active = 'materials';
		$this->template->page = ORM::factory('static_page')->where('page_name', '=', 'promo')->find();
		$this->set_view('cabinet/materials');
	}
}