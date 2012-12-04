<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

return array(
	'simple' => array(
		'skin' => 'v2',
		'language' => 'ru',
		'toolbar' => 'Basic'
	),
	'default' => array(
		'skin' => 'v2',
		'language' => 'ru',
		'toolbar' => array(
			array('Source'),
			array('Undo','Redo','SelectAll','RemoveFormat'),
			array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
			array('NumberedList','BulletedList','Outdent','Indent'),
			array('Link','Unlink','Anchor'),
			array('Image', 'Table', 'HorizontalRule', 'SpecialChar'),
			'/',
			array('Format','Font','FontSize'),
			array('TextColor','BGColor'),
			array('Maximize', 'ShowBlocks','-','About')
		)
	)
);

/**
 Full = ['Source','-','Save','NewPage','Preview','-','Templates'],
	['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
	'/',
	['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	['BidiLtr', 'BidiRtl' ],
	['Link','Unlink','Anchor'],
	['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
	'/',
	['Styles','Format','Font','FontSize'],
	['TextColor','BGColor'],
	['Maximize', 'ShowBlocks','-','About']
 */