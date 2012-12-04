<?php defined('SYSPATH') or die('No direct script access.');

abstract class Logger_Abstract
{
	/**
	 * Adds a message
	 * @param int $type message type (Logger::MSG, Logger::ERR, Logger:: WARN)
	 * @param string $message message text
	 * @param string $sender sender class
	 */
	public abstract function add($type, $message, $sender=NULL);
}