<?php

defined('SYSPATH') or die('No direct script access.');


class Xhtml
{
	static function get_from_docx_file()
	{
		require Kohana::find_file('vendor', 'docx/classes/CreateDocx');
		require Kohana::find_file('vendor', 'docx/classes/TransformDoc');

		$document = new TransformDoc();
		$document->setStrFile('w:/Projects/example_title.docx');
		$document->generateXHTML();
		$document->validatorXHTML();
		return $document->getStrXHTML();
	}
	public function __construct() 
	{
		$document = new TransformDoc();
		$document->setStrFile('w:/Projects/example_title.doc');
		$document->generateXHTML();
		$document->validatorXHTML();
		echo $document->getStrXHTML();
	
	}
}