<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Download_Task class is a wrapper for some array of curl options.
 * Also it contains a handler Callback object that will be called
 * when download finishes.
 * Instance of this class is created by download manager and then passed to
 * Downloader instance.
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Download_Task
{
	/**
	 * @var Download_Handler
	 */
	protected $handler = NULL;

	/**
	 * @var Download_Result
	 */
	protected $result;

	protected $output;
	protected $curl_options = array();
	protected $force_sets = array();
	protected $counter = 0;

	public function  __construct(Download_Request $request)
	{
		$this->load_request($request);
		$this->set_follow_redirect(TRUE);
	}

	public function init()
	{
		$this->counter++;
		if (is_null($this->output))
		{
			$this->result = new Download_Result_Variable();
			$this->curl_options[CURLOPT_RETURNTRANSFER] = TRUE;
		}
		else
		{
			$this->result = new Download_Result_File($this->output);
			$this->curl_options[CURLOPT_RETURNTRANSFER] = FALSE;
			$this->curl_options[CURLOPT_FILE] = fopen($this->output, 'w');
		}
		$this->curl_options[CURLOPT_HEADERFUNCTION] = array($this->result, '__write_header');
	}

	public function load_result($info, $content, $error_code)
	{
		$this->result->load($info, $content, $error_code);
	}

	public function get_curl_options()
	{
		return $this->curl_options;
	}

	/**
	 * @return Download_Result
	 */
	public function get_result()
	{
		return $this->result;
	}

	/**
	 * @return Download_Handler
	 */
	public function get_handler()
	{
		return $this->handler;
	}

	public function set_handler(Download_Handler $handler)
	{
		$this->handler = $handler;
	}

	public function get_times_downloaded()
	{
		return $this->counter;
	}

	public function set_output($output)
	{
		$this->output = $output;
	}

	public function set_follow_redirect($value)
	{
		$this->curl_options[CURLOPT_FOLLOWLOCATION] = (bool)$value;
	}

	public function get_proxy()
	{
		return $this->curl_options[CURLOPT_PROXY];
	}

	public function set_proxy($proxy, $auth = FALSE)
	{
		$this->curl_options[CURLOPT_PROXY] = $proxy;
	}

	public function set_user_agent($user_agent)
	{
		$this->curl_options[CURLOPT_USERAGENT] = $user_agent;
	}

	public function set_timeout($timeout)
	{
		$this->curl_options[CURLOPT_TIMEOUT] = $timeout;
		$this->curl_options[CURLOPT_CONNECTTIMEOUT] = $timeout;
	}

	public function get_url()
	{
		return $this->curl_options[CURLOPT_URL];
	}

	protected function load_request(Download_Request $request)
	{
		$this->curl_options[CURLOPT_URL] = $request->url;
		if ($request->method == 'post')
		{
			$this->curl_options[CURLOPT_POST] = TRUE;
			$this->curl_options[CURLOPT_POSTFIELDS] = $request->post_data;
		}
		if ( ! empty($request->user_agent))
			$this->curl_options[CURLOPT_USERAGENT] = $request->user_agent;

		if (isset($request->addition_options))
		{
			foreach ($request->addition_options as $key => $value)
				$this->curl_options[$key] = $value;
		}

		if (isset($request->force_sets))
		{
			foreach ($request->force_sets as $key => $value)
				$this->force_sets[$key] = $value;
		}
	}

}
