<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
interface Download_Handler
{
	public function on_download_complete(Download_Result $result);
}
