<?php

class Log_File extends Logger_Abstract
{
	/**
	 * Name of the log file
	 * @var string
	 */
	protected $filename;

	/**
	 * File handler
	 * @var handler 
	 */
	protected $file_handle;

	/**
	 * Creates logger object and opens file for writing
	 * @param string $filename Name of the log file
	 */
	public function  __construct($filename) {
		$this->filename = $filename;
		$this->file_handle = fopen($filename, 'w');
	}

	function  __destruct() {
		fclose($this->file_handle);
	}

	/**
	 * Adds a message
	 * @param int $type message type (Logger::MSG, Logger::ERR, Logger:: WARN)
	 * @param string $message message text
	 * @param string $sender sender class
	 */
	public function add($type, $message, $sender=NULL) {
		if ( ! empty ($sender))
		{
			$msg = date('[d.m.y H:i:s]')." {$sender}: {$message}\n";
		}
		else
		{
			$msg = date('[d.m.y H:i:s]')." {$message}\n";
		}
		fwrite($this->file_handle, $msg);
		fflush($this->file_handle);
	}
}
?>
