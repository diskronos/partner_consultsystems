<?php

defined('SYSPATH') or die('No direct script access.');

?>
<?php echo ext::form_begin(NULL, array('method' => 'POST'))?>
<?php echo form::hidden('return_location', $return_location)?>
<?php echo $form->render()?>
<?php echo ext::spacer()?>
<?php echo ext::buttons_begin()?>
<?php echo ext::submit('submit_and_confirm', 'Сохранить и утвердить')?>
<?php echo ext::submit('submit', 'Сохранить без утверждения')?>
<?php echo ext::submit('cancel', 'Отмена')?>
<?php echo ext::buttons_end()?>
<?php echo ext::form_end()?>
