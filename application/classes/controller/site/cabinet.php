<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Cabinet extends Controller_Auth
{
	protected $_user = FALSE;
	public function before() 
	{
		parent::before();
		$this->_user = Auth::instance()->get_user();
		if (!$this->_user)
		{
			$this->redirect('site-index');
		}

		$this->template->set_layout('global/global_cabinet');

		$this->template->user = $this->_user;
		$this->template->group = new Helper_Group($this->_user->money_earned, $this->_user->partner_group_id);
		$this->set_tdk('Панель партнера');
	}
	
	public function set_tdk($title = '', $description = '', $keywords = '')
	{
		$this->template->title = $title;
		$this->template->description = $description;
		$this->template->keywords = $keywords;
	}
	
	public function action_index()
	{
		$this->redirect('site-cabinet_statistics');
//		$this->set_view('index/index');
	}
	public function action_materials()
	{
		$this->set_tdk('Панель партнера - Материалы');
		$this->template->active = 'materials';
		$this->template->page = ORM::factory('static_page')->where('page_name', '=', 'promo')->find();
		$this->set_view('cabinet/materials');
	}

	public function action_profile()
	{
		$this->set_tdk('Панель партнера - Профиль');
		$form = new Form_Site_Profile($this->_user);
		
		if (isset($_POST["submit"]) AND $form->submit())
		{
			$this-> template->message = 'Пароль успешно изменен';
		}
		$this->template->form = $form;
	}
}