<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

/**
 * @group spreadsheet_reader
 */
class Spreadsheet_ReaderTest extends Kohana_Unittest_TestCase
{
	public function testCount()
	{
		$reader = Spreadsheet_Reader::factory(serialize(Spreadsheet_Reader_TestHelper::get_data1()), 'Testable');
		$this->assertEquals(3, count($reader));
	}
	
	public function testAs_array()
	{
		$reader = Spreadsheet_Reader::factory(serialize(Spreadsheet_Reader_TestHelper::get_data1()), 'Testable');
		$this->assertSame(Spreadsheet_Reader_TestHelper::get_data1(), $reader->as_array());
	}
	
	public function testIterate()
	{
		$reader = Spreadsheet_Reader::factory(serialize(Spreadsheet_Reader_TestHelper::get_data1()), 'Testable');
		
		$data = array();
		foreach ($reader as $row)
		{
			$data[] = $row;
		}
		
		$this->assertSame(Spreadsheet_Reader_TestHelper::get_data1(), $data);
	}
	
	public function testEmptyArray()
	{
		$reader = Spreadsheet_Reader::factory(serialize(array()), 'Testable');
		$this->assertSame(array(), $reader->as_array());
		$this->assertEquals(0, count($reader));
		
		$data = array();
		foreach ($reader as $row)
		{
			$data[] = $row;
		}
		$this->assertSame(array(), $data);
	}
}