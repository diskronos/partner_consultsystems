<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 * @author Eugene Douanr <e.dounar@smartdesign.by>
 */
class Grabber_Callback
{
	protected $method;
	protected $params;

	public function  __construct($method, array $params = array())
	{
		$this->method = $method;
		$this->params = $params;
	}

	public function call(Grabber_Task_Abstract $target, Download_Result $result)
	{
		if ( ! method_exists($target, $this->method))
		{
			$task_class = get_class($target);
			throw new Exception("Invalid {$task_class} method {$this->method}");
		}
		$callback = array($target, $this->method);
		$params = array_merge(array($result), $this->params);
		call_user_func_array($callback, $params);
	}

}
