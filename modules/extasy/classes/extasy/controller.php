<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

abstract class Extasy_Controller extends Kohana_Controller
{
	protected $template = null;

	private $_view = null;

	private $_return_location = NULL;

	public function before()
	{
		$this->_view = $this->request->action();

		$this->template = View::factory();

		if($this->request->is_initial())
		{
			$layout = Kohana::$config->load('layout')->default;
			$this->template->set_layout($layout);
		}

		$this->_return_location = arr::get(
			$_POST,
			'return_location',
			arr::get(
				$_GET,
				'return_location',
				arr::get(
					$_SERVER,
					'HTTP_REFERER'
				)
			)
		);
		$this->template->return_location = $this->_return_location;
	}

	protected function param($key)
	{
		return $this->request->param($key);
	}

	protected function forward_403()
	{
		throw new HTTP_Exception_403();
	}

	protected function forward_404()
	{
		throw new HTTP_Exception_404();
	}

	protected function set_view($view)
	{
		$this->_view = $view;
	}

	public function after()
	{
		$this->template->set_filename($this->_view);

		$response = (string) $this->template;

		if (DebugToolbar::is_enabled())
		{
			$toolbar = DebugToolbar::render(FALSE)->set_layout(NULL);
			$response = str_ireplace('</body>', $toolbar.'</body>', $response);
		}

		$this->response->body($response);
	}

	protected function redirect($route)
	{
		return $this->request->redirect(url::url_to_route($route), 302);
	}

	public function back($default_route)
	{
		$url = $this->_return_location;
		if (is_null($url))
		{
			$url = url::url_to_route($default_route);
		}
		$this->request->redirect($url);
	}
}