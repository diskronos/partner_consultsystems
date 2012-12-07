<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Template extends Controller_Site {

	public function action_generate_doc()
	{
		header ("Content-Type: application/vnd.ms-word");
		header ("Content-Disposition: attachment;Filename=document_name.doc");
		echo '<html>';
		echo '<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">';
		echo '<body>';
		echo '<div style="width:200px">fdgdsf</div><div style="float:left;width:200px">11111</div><b>My first document</b>';
		echo '</body>';
		echo '</html>';
		exit();
	}
}