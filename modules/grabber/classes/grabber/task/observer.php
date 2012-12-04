<?php defined('SYSPATH') or die('No direct script access.');

/**
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */

interface Grabber_Task_Observer
{
	public function on_task_complete(Grabber_Task $task);
}
