<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sends all messages to /dev/null
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */

class Logger_Blackhole extends Logger_Abstract
{
	public function add($type, $message, $sender=NULL)
	{

	}
}