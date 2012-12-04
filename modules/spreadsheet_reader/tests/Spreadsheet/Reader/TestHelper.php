<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

class Spreadsheet_Reader_TestHelper
{
	static public function get_data1()
	{
		return array(
			array('cell11', 'cell12', 'cell13'),
			array('cell21', 'cell22', 'cell23'),
			array('cell31', 'cell32', 'cell33'),
		);
	}
	
	static public function get_data1_csv()
	{
		return dirname(__FILE__).'/../../_files/data1.csv';
	}
	
	static public function get_data2()
	{
		return array(
			array('cell11', 'cell12', 'cell13'),
			array('cell21', 'cell2;2', 'cell2""3'),
			array('cell3;;;1', 'cell3";"2', 'cell33')
		);
	}
	
	static public function get_data2_csv()
	{
		return dirname(__FILE__).'/../../_files/data2.csv';
	}
	
	static public function get_price1()
	{
		return array(
			array('Amtel  155/70  R13  75  T  Planet T-301 K-309 /3237/',                 '1',    '600'),
			array('Amtel  165/65  R14  79  T  Planet T-301 K-317 /A101010011/',           '80',   '3100'),
			array('Amtel  165/70  R13  79  T  Planet 3 К-361 /A101006004/',               '82',   '1200'),
			array('Amtel  175/65  R14  82  Q  Nord Master ST 310 К263  ш /B101004002/',   '8407', '1400'),
			array('Amtel  175/70  R13  82  H  NEK-S 102B',                                '1',    '970'),
			array('Amtel  175/70  R13  82  Q  Nord Master ST310   К262  ш /B101004004/',  '1',    '1160'),
			array('Amtel  175/70  R14  84  H  Planet T-301 K-316 /A101010006/',           '1',    '1300'),
			array('Amtel  175/70  R14  84  Q  NordMaster ST 310 K-270  ш /B101005003/',   '1',    '1370'),
			array('Amtel  175/70  R14  84  T  Nord Master CL 240В /B101003006/',          '1',    '1440'),
			array('Amtel  185/55  R15  82  H  Planet T-301 K-315',                        '2',    '1900'),
			array('Amtel  185/60  R15  84  H  Planet T-301 K-257 /3653/',                 '33',   '1880'),
			array('Amtel  185/65  R14  86  Q  Nord Master K-245  ш /50321307/',           '1',    '1400'),
			array('Amtel  185/65  R14  86  T  Nord Master 2 M-503  ш /50321307/',         '1',    '1460'),
			array('Amtel  185/70  R14  88  H  Planet DC K-288 /A101007005/',              '1',    '1300'),
			array('Amtel  195/50  R15  82  H  Planet T301 K-313 /4000/',                  '1',    '1300'),
			array('Amtel  195/60  R15  88  H  Planet 2P К-236',                           '4',    '1880'),
			array('Amtel  195/60  R15  88  H  Planet T-301 K-256 /A101010003/',           '85',   '1700'),
			array('Amtel  195/65  R15  91  H  Planet 2P K-234 /A101005007/',              '44',   '1740'),
			array('Amtel  195/65  R15  91  H  Planet DC 108B /A101007001/',               '84',   '1800'),
			array('Amtel  195/65  R15  91  H  Planet T-301 K-310 /A101010002/',           '72',   '2150'),
			array('Amtel  195/65  R15  91  Q  NordMaster ST 221В  ш /B101004013/',        '98',   '1620'),
			array('Amtel  195/65  R15  91  T  Nord Master 2M-502  ш /B101002002/',        '6304', '1660'),
			array('Amtel  205/50  R15  86  H  Planet T-301 K-281 /3942/',                 '3',    '2700'),
			array('Amtel  205/50  R16  87  V  Planet FT-501 K-261',                       '2',    '2800'),
			array('Amtel  205/60  R15  91  H  Planet T-301 К-280 /A101010007/',           '8',    '2510'),
			array('Amtel  205/65  R15  94  H  Planet 2P К-248 /A101005002/',              '143',  '2000'),
			array('Amtel  205/65  R15  94  H  Planet NV-116 /3299/',                      '107',  '2300'),
			array('Amtel  205/65  R15  94  Q  NordMaster K-246  ш /B101001006/',          '29',   '2160'),
			array('Amtel  205/65  R15  94  Q  NordMaster K-246  ш DOT 05 /B101001003/',   '78',   '1300'),
			array('Amtel  205/65  R15  94  Q  NordMaster ST 223В  ш /B101004012/',        '18',   '1980'),
			array('Amtel  205/65  R15  94  Q  NordMaster ST 223В  ш DOT 05 /B101004011/', '5',    '1190'),
			array('Amtel  205/65  R15  94  Q  NordMaster ST-310 K-266  ш /B101005007/',   '18',   '2250'),
			array('Amtel  205/65  R15  94  T  NordMaster CL 233В /B101003009/',           '8',    '2300'),
			array('Amtel  215/55  R16  93  V  Planet FT-501 K-283 /A101008002/',          '47',   '3300'),
			array('Amtel  215/65  R15  96  S  NordMaster ST 310 K-269  ш /B101004008/',   '1',    '2160'),
			array('Amtel  225/50  R16  92  V  Planet FT-501 K-320 /A101008001/',          '51',   '3600'),
			array('Barum  175  R14C  99/98  Q  OR 56 Cargo /A102004001/',                 '4',    '2590')
		);
	}
	
	static public function get_price1_csv()
	{
		return dirname(__FILE__).'/../../_files/price1.csv';
	}
}