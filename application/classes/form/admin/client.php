<?php

defined('SYSPATH') or die('No direct script access.');

class Form_Admin_Client extends CM_Form_Abstract 
{
	private $_model = NULL;
	public function construct_form($param)
	{
		$this->_model = $param;
		$this->add_plugin(new CM_Form_Plugin_ORM(NULL,array('sites')));
		$this->set_field('name', new CM_Field_String(),10);
		$this->set_field('email', new CM_Field_String(),20);
		$this->set_field('partner_id', new CM_Field_Select_ORM_Autocomplete(ORM::factory('user'), 'name'),30);
		$this->set_field('tariff', new CM_Field_String(),40);
		$this->set_field('sites',new CM_Field_Array(new CM_Field_String()),50);
		$this->set_data();
	}
	
	public function set_data()
	{
		$result = array();
		foreach ($this->_model->sites->find_all() as $site)
		{
			$result[] = $site->url;
		}
		
		$this->get_field('sites')->set_raw_value(serialize($result));
	}

	public function after_plugin_submit()
	{
		$sites = unserialize($this->get_field('sites')->get_value()->get_raw());
		$sites = array_diff($sites, array(NULL, ''));
		$sites = array_unique($sites);

		db::delete('client_sites')
				->where('client_id', '=', $this->_model->id)
				->execute();
		
		if (!count($sites)) return;
		
		foreach ($sites as $site)
		{
			ORM::factory('client_site')
					->values(
							array(
								'client_id' => $this->_model->id,
								'url' =>$site,
								'foreign_id' => rand()
								)
					)
					->save();
		}
	}
}