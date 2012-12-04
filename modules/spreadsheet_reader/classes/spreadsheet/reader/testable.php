<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Spreadsheet_Reader_Testable extends Spreadsheet_Reader
{
	protected function _get_parsed_data()
	{
		return unserialize($this->get_raw_data());
	}
}