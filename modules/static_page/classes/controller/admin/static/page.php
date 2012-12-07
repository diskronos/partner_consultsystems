<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Static_Page extends Controller_Crud
{
	protected $_model = 'static_page';
	protected $_group_actions = array();
	
	public function action_create()
	{
		$this->redirect('admin-static_page:index');
	}
	
	public function action_delete()
	{
		$this->redirect('admin-static_page:index');
	}

	protected function  before_create(ORM $item) {
		if(isset($_POST['url']) and !$_POST['url'])
		{
			$_POST['url'] = strtolower(Helper_Translit::translit($_POST['page_name']));
		}	
		return parent::before_create($item);
	}	
}
