<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */
?>
<?php echo ext::form_begin(NULL, array('method' => 'POST'))?>
<?php echo $form->render()?>
<?php if ($write_allowed):?>
<?php echo ext::spacer()?>
<?php echo ext::buttons_begin()?>
<?php echo ext::submit('submit', 'Сохранить')?>
<?php echo ext::submit('cancel', 'Отмена')?>
<?php echo ext::buttons_end()?>
<?php endif;?>
<?php echo ext::form_end()?>