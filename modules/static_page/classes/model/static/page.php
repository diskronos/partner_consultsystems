<?php defined('SYSPATH') or die('No direct script access.');

class Model_Static_Page extends ORM {
	
	protected $_table_name = 'static_pages';
	
	//protected $_updated_column = array('column' => 'created_at','format' => TRUE);
	//protected $_created_column = array('column' => 'updated_at','format' => TRUE);

	protected $_grid_columns = array(
		'page_name' => NULL,		
		'url' => array(
			'type' => 'link',
			'route_str' => 'static_page?url=${url}',
			'title' => '/legal/${url}.html',
		),
		'seo_page_title' => 'starttext',
		'seo_page_description' => 'bool',
		'seo_page_keywords' => 'bool',
		//'updated_at' => 'timestamp',
		'edit' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-static_page:edit?id=${id}',
			'title' => '[*]',
			'alternative' => '[*]',
		)	
	);

	protected $_form_fields = array
	(				
		'page_content' => 'HTML',		
		'seo_page_description' => 'textarea',
		'seo_page_keywords' => 'textarea',
		'seo_page_title' => NULL,
	);

	protected $_labels = array(
		'page_name' => 'Название страницы',
		'url' => 'URL',
		'updated_at' => 'Последнее обновление',
		'seo_page_title' => 'Заголовок страницы',
		'seo_page_description' => 'Описание страницы',
		'seo_page_keywords' => 'Ключевые слова',
		'page_content' => 'Содержание страницы',
		'active' => 'Отображать на сайте',
	);
	
}