<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Controller_Admin_Config extends Controller_Admin
{
	public function action_index()
	{
		$write_allowed = ACL::is_action_allowed('admin', 'config', 'write');

		$this->template->write_allowed = $write_allowed;

		if (isset($_POST['cancel']))
		{
			$this->redirect('admin-config');
		}

		$form = new Form_Config();
		if ( ! $write_allowed)
		{
			$form->set_read_only();
		}

		if ($write_allowed AND isset($_POST['submit']) AND $form->submit())
		{
			$this->redirect('admin-config');
		}

		$this->template->form = $form;
	}
}