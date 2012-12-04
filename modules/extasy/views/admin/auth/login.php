<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::form_begin()?>
<?php echo form::hidden('return', $return);?>
<?php echo ext::form_fields_begin()?>
<?php echo ext::form_row(
	form::input('email', $email, array('style' => 'width:150px')),
	form::label('email', 'E-mail')
)?>
<?php echo ext::form_row(
	form::password('password', NULL, array('style' => 'width:150px')),
	form::label('password', 'Пароль')
)?>
<?php echo ext::form_row(
	form::checkbox('remember', '1', $remember, array('style' => 'width: 10px')),
	form::label('remember', 'Запомнить меня')
)?>
<?php if($error):?>
<?php echo ext::form_row(
	'',
	'',
	$error
)?>
<?php endif;?>
<?php echo ext::form_fields_end()?>
<?php echo ext::spacer()?>
<?php echo ext::buttons_begin()?>
<?php echo ext::submit('login', 'Вход')?>
<?php echo ext::buttons_end()?>
<?php echo ext::form_end()?>