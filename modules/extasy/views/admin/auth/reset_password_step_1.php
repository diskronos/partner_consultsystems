<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::form_begin(NULL, array('method' => 'POST'))?>

<?php $form->get_field('email')->set_attributes(array('style' => 'width:150px;'))?>

<?php echo $form->render()?>
<?php echo ext::spacer()?>
<?php echo ext::buttons_begin()?>
<?php echo ext::submit('submit', 'Отправить инструкции на почту')?>
<?php echo ext::buttons_end()?>
<?php echo ext::form_end()?>