<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

Route::set('unittest', 'unittest(/<action>)')
	->defaults(array(
		'controller' => 'unittest',
		'action'     => 'index',
	));