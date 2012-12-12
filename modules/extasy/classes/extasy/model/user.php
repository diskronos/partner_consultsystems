<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Extasy_Model_User extends ORM
{
	protected $_has_many = array(
		'clients' => array(
			'model' => 'user',
			'foreign_key' => 'referrer_id',
			),
		);
	protected $_belongs_to = array(
		'partner' => array(
			'model' => 'user',
			'foreign_key' => 'referrer_id',
		),
		'partner_group' => array(
			'model' => 'partner_group',
			'foreign_key' => 'partner_group_id',
		),
	);
	
	protected $_created_column = array('column' => 'created_at','format'=>TRUE);
	protected $_updated_column = array('column' => 'updated_at','format'=>TRUE);

	protected $_render_options = array(
		'status' => array(
			'legal'		 => 'юр. лицо',
			'individual' => 'физ. лицо'
		)
	);
	
	protected $_grid_columns = array(
		'id' => NULL,
		'email' => NULL,
		'name' => NULL,
		'status' => array(
			'type' => 'template',
			'template' => '${status_rendered}',
		),
		'roles_rendered' => array(
			'orderable' => FALSE
		),
		'created_at' => 'timestamp',
		'updated_at' => 'timestamp',
		'requisites' => array(
			'type' => 'link',
			'route_str' => 'admin-partner_requisites_edit:edit?id=${id}',
			'title' => 'Реквизиты',
		),
		'change_password' => array(
			'type' => 'link',
			'route_str' => 'admin-user:change_password?id=${id}',
			'title' => '[Сменить пароль]',
		),
		'login_as' => array(
			'type' => 'link',
			'route_str' => 'admin-user:login_as?id=${id}',
			'title' => '[Войти под аккаунтом]',
		),
		'edit' => array(
			'type' => 'link',
			'route_str' => 'admin-user:edit?id=${id}',
			'title' => '[*]',
		),
		'delete' => array(
			'width' => '50',
			'type' => 'link',
			'route_str' => 'admin-user:delete?id=${id}',
			'title' => '[X]',
			'confirm' => 'Вы уверены?'
		)
	);

	public function labels()
	{
		return array(
			'roles_rendered' => 'Роли',
			'email' => 'E-Mail',
			'password' => 'Пароль',
			'password_confirm' => 'Подтверждение пароля',
			'roles'     => 'Роли',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата изменения',
			'name' => 'Имя',
			'send_orders' => 'Отправлять заказы на почту',
			'id' => 'ID',
			'status' => 'Статус',
		);
	}

	public function rules()
	{
		return array(
			'name' => array(				//это ник он же логин
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 16)),
				array('regex', array(':value', '#^[a-z0-9\pL ]+$#iu')),
				array(array($this, 'unique'), array('name', ':value')),
			),
			'email' => array(
				array('not_empty'),
				array('email'),
				array(array($this, 'unique'), array('email', ':value')),
			),
			'fullname' => array(
				array('not_empty'),
			),
		);
	}

	public function filters()
	{
		return array(
			'password' => array(
				array(array(Auth::instance(), 'hash'))
			)
		);
	}

	public static function get_password_validation()
	{
		return Validation::factory(array())
			->rule('password', 'not_empty')
			->rule('password', 'min_length', array(':value', 6))
			->rule('password', 'max_length', array(':value', 18))
			->rule('password_confirm', 'matches', array(':validation', 'password', ':field'));
	}

	public function form()
	{
		return new Form_User($this);
	}

	public function where_has_role($role)
	{
		$role_mask = Kohana::$config->load('auth.roles.'.$role);
		return $this->where('roles', '&', $role_mask);
	}

	public function add_role($role)
	{
		$role_mask = Kohana::$config->load('auth.roles.'.$role);
		$this->roles |= $role_mask;
	}

	public function get_roles_list()
	{
		$roles = array();

		foreach (Kohana::$config->load('auth.roles') as $role => $bit)
		{
			if ($bit & $this->roles)
			{
				$roles[] = $role;
			}
		}

		return $roles;
	}

	public function get_roles_rendered()
	{
		$roles_rendered = array();
		foreach ($this->get_roles_list() as $role)
		{
			$roles_rendered[] = arr::get(Kohana::$config->load('auth')->roles_labels, $role, $role);
		}
		return implode(', ', $roles_rendered);
	}

	public function password_validate(Validate $array, $field)
	{
		if($this->loaded() && ! array_key_exists($field, $this->_changed))
		{
			return TRUE;
		}

		if( ! Validate::min_length($array[$field], 3))
		{
			$array->error($field,'min_length', array(5));
			return FALSE;
		}
		if( ! Validate::max_length($array[$field], 50))
		{
			$array->error($field,'max_length', array(50));
			return FALSE;
		}

		return TRUE;
	}

	public function delete($id = NULL)
	{
		if(Auth::instance()->get_user()->id == $this->id || Auth::instance()->get_user()->id == $id)
		{
			return;
		}
		parent::delete($id);
	}

	public function complete_login()
	{
		if ($this->_loaded)
		{
			// Update the number of logins
			$this->logins = new Database_Expression('logins + 1');

			// Set the last login date
			$this->last_login = time();

			// Save the user
			$this->update();
		}
	}
	
	public function get_requisites()//возвращает - реквизиты -  
	{
		$result = orm::factory('partner_requisites_' . $this->status)
				->where('partner_id', '=', $this->id)
				->find();

		return ($result->loaded())? $result : FALSE;
	}
	public function get_status_rendered()
	{
		return $this->get_rendered('status');
	}
	
	public function get_clients_transactions()
	{
		$ids = array_keys($this->clients->find_all()->as_array('id', NULL));
		return orm::factory('money_transaction')->where('payor_id', 'in', '(' . implode(',', $ids).')');
	}
}
