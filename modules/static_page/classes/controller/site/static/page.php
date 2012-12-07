<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Site_Static_Page extends Controller_Site
{
	public function action_index()
	{		
		$url = $this->param('url');
		$this->get_kdt($url);
		$memorials = orm::factory('static_page')->where('url','=',$url)->find_all();
		if(!$memorials->count())
		{
			$this->forward_404();
		}

		else
		{
			$this->template->page = $memorials;
		}
		$this->set_view('static_page/index');
	}
}

