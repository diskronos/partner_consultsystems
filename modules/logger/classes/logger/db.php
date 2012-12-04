<?php
/**
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */

class Logger_Db extends Logger_Abstract
{
	protected $model_name = 'logger';

	/**
	 * Create new log object
	 * @param string $model last part of log model classname (log if class is Model_Logger)
	 */
	public function  __construct($model_name = 'logger') {
		$this->model_name = $model_name;
	}

	/**
	 * Adds a message
	 * @param int $type message type (Logger::MSG, Logger::ERR, Logger:: WARN)
	 * @param string $message message text
	 * @param string $sender sender class
	 */
	public function add($type, $message, $sender=NULL) {
		$db_message = ORM::factory($this->model_name);

		$db_message->type = $type;
		$db_message->message = $message;
		$db_message->sender = $sender;
		$db_message->time = time();

		$db_message->save();
	}
}
