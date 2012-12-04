<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site extends Extasy_Controller
{
	public function before() {
		parent::before();
		$this->template->set_layout('global/global_site');
	}
	
	public function set_seo_params(
			$search_value,
			$search_field = 'url',
			$table_name = 'additional_pages',
			$page_text_field = 'page_content',
			$page_title_field = 'seo_page_title',
			$page_keyword_field = 'seo_page_keywords',
			$page_description_field = 'seo_page_description'
	)
	{
		$page_data = db::select()
			->from($table_name)
			->where($search_field, '=', $search_value)->execute();
		$this->template->page_text_field = $page_data->get($page_text_field);
		$this->template->page_title_field = $page_data->get($page_title_field);
		$this->template->page_keyword_field = $page_data->get($page_keyword_field);
		$this->template->page_description_field = $page_data->get($page_description_field);
	}
}
