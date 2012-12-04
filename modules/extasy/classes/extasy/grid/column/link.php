<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Extasy_Grid_Column_Link extends Grid_Column_Template
{
	protected $_route_str = NULL;
	protected $_title = NULL;
	protected $_confirm = NULL;

	public function __construct(array $column = array())
	{
		parent::__construct($column);

		$this->_route_str = Arr::get($column, 'route_str');
		$this->_title = Arr::get($column, 'title');
		$this->_confirm = Arr::get($column, 'confirm');
	}

	protected function _draw_field($obj)
	{
		$route_str = Extasy::obj_placeholders($obj, $this->_route_str);
		$title = Extasy::obj_placeholders($obj, $this->_title);
		$attributes = array();
		if($this->_confirm)
		{
			$attributes['onclick'] = 'javascript: return confirm("'.Extasy::obj_placeholders($obj, $this->_confirm).'")';
		}

		return '<td align="'.$this->_align.'">'.Html::link_to_route($route_str, $title, $attributes).'</td>';
	}

	protected function _field($obj)
	{
		$route_str = Extasy::obj_placeholders($obj, $this->_route_str);

		if ( ! ACL::is_route_allowed($route_str))
		{
			return '<td></td>';
		}

		return $this->_draw_field($obj);
	}
}