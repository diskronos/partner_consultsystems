<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Spreadsheet_Reader_Csv extends Spreadsheet_Reader
{
	protected function _get_parsed_data()
	{
		$raw_data = iconv('Windows-1251', 'UTF-8', $this->get_raw_data());

		$tmp_stream = fopen("php://memory", "rw");
		fwrite($tmp_stream, $raw_data);
		fseek($tmp_stream, 0);

		$data = array();

		while ($row = fgetcsv($tmp_stream, NULL, ';', '"'))
		{
			$data[] = $row;
		}

		return $data;
	}
}