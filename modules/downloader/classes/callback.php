<?php defined('SYSPATH') or die('No direct script access.');

/**
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
class Callback
{

	protected $callback;
	protected $params;

	/**
	 * Generic callback with predefined appended params
	 * @param callback $callback Callback type
	 * @param array $params Params that will be appended when function is called
	 */
	public function  __construct($callback, $params = array())
	{
		if ( ! is_callable($callback))
		{
			$callback_dump = print_r($callback, TRUE);
			throw new Exception("Invalid callback {$callback_dump}");
		}
		$this->callback = $callback;
		$this->params = $params;
	}

	public function call(array $params)
	{
		$params = array_merge($params, $this->params);
		call_user_func_array($this->callback, $params);
	}
}
