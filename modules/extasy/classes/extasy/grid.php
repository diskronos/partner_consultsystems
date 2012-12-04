<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Extasy_Grid extends Widget_Container
{
	protected $_orm = NULL;

	protected $_data = NULL;

	protected $_open_template = 'grid/open';
	protected $_close_template = 'grid/close';
	protected $_header_template = 'grid/header';
	protected $_data_template = 'grid/data';

	protected $_template = 'grid/all';

	protected $_pagination = NULL;

	protected $_options = NULL;

	protected $_group_actions = array();

	protected $_order_by = 'id';
	protected $_order_direction = 'ASC';
	protected $_order_per_page = 50;

	public function __construct(ORM $orm, array $columns = array(), $options = array())
	{
		$this->_options = $options;

		$this->set_name($orm->object_name());

		foreach($columns as $name => $column)
		{
			if( ! is_array($column))
			{
				$column = array(
					'type' => $column
				);
			}
			$column_cfg = array(
				'name' => $name,
				'header' => Arr::get($orm->labels(), $name),
				'params' => Arr::get($column, 'params', array())
			);
			$column = Arr::merge($column_cfg, (array) $column);
			$column = Grid_Column::factory($column);
			$this[$name] = $column;
		}

		$clone_orm = clone $orm;

		$pagination = Pagination::factory(array(
			'items_per_page' => arr::get($_GET, 'per_page', arr::get($this->_options, 'per_page', $this->_order_per_page)),
			'total_items' => $clone_orm->count_all(),
			'view' => 'extasy/pagination/basic'
		));

		$this->_order_by = arr::get($_GET, 'order_by', arr::get($this->_options, 'order_by', $this->_order_by));
		$this->_order_direction = arr::get($_GET, 'order_direction', arr::get($this->_options, 'order_direction', $this->_order_direction));

		if(isset($this[$this->_order_by]))
		{
			$this[$this->_order_by]->order_by($this->_order_direction);
		}

		$orm->order_by($this->_order_by, $this->_order_direction);

		$this->_orm = $orm;

		$offset = $pagination->current_first_item ? $pagination->current_first_item - 1 : 0;

		$this->_data = $orm
			->offset($offset)
			->limit($pagination->items_per_page)
			->find_all();

		$this->_pagination = $pagination;
	}

	static public function factory(ORM $orm, array $columns = array(), array $options = array())
	{
		return new Grid($orm, $columns, $options);
	}

	protected function _render()
	{
		return View::factory($this->_template, array(
			'grid' => $this
		));
	}

	public function set_group_actions($actions = array())
	{
		$this->_group_actions = $actions;
		return $this;
	}

	public function open()
	{
		return View::factory($this->_open_template, array(
			'grid' => $this,
			'items_per_page' => arr::get($_GET, 'per_page', arr::get($this->_options, 'per_page', $this->_order_per_page)),
		));
	}

	public function close()
	{
		return View::factory($this->_close_template, array(
			'grid' => $this,
			'group_actions' => $this->_group_actions,
			'items_per_page' => arr::get($_GET, 'per_page', arr::get($this->_options, 'per_page', $this->_order_per_page)),
		));
	}

	public function pagination()
	{
		return $this->_pagination;
	}

	public function header()
	{
		return View::factory($this->_header_template, array(
			'columns' => $this->subwidgets(),
			'draw_checkboxes' => (bool) count($this->_group_actions)
		));
	}

	public function data()
	{
		return View::factory($this->_data_template, array(
			'columns' => $this->subwidgets(),
			'data' => $this->_data,
			'draw_checkboxes' => (bool) count($this->_group_actions)
		));
	}
}