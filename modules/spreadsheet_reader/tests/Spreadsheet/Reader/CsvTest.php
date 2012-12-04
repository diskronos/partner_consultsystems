<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */


/**
 * @group spreadsheet_reader
 * @group spreadsheet_reader.csv
 */
class Spreadsheet_Reader_CsvTest extends Kohana_Unittest_TestCase
{
	public function testConvert_data1()
	{
		$data1 = Spreadsheet_Reader_TestHelper::get_data1();
		
		$data1_csv = Spreadsheet_Reader_TestHelper::get_data1_csv();
		
		$reader = Spreadsheet_Reader::create_from_file($data1_csv);
		
		$this->assertEquals(count($data1), count($reader));
		
		$this->assertSame($data1, $reader->as_array());
	}
	
	public function testConvert_data2()
	{
		$data2 = Spreadsheet_Reader_TestHelper::get_data2();
		
		$data2_csv = Spreadsheet_Reader_TestHelper::get_data2_csv();
		
		$reader = Spreadsheet_Reader::create_from_file($data2_csv);
		
		$this->assertEquals(count($data2), count($reader));
		
		$this->assertSame($data2, $reader->as_array());
	}
	
	public function testConvert_price1()
	{
		$price1 = Spreadsheet_Reader_TestHelper::get_price1();
		
		$price1_csv = Spreadsheet_Reader_TestHelper::get_price1_csv();
		
		$reader = Spreadsheet_Reader::create_from_file($price1_csv);
		
		$this->assertEquals(count($price1), count($reader));
		
		$this->assertSame($price1, $reader->as_array());
	}
}