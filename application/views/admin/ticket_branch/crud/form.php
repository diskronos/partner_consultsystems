<?php

defined('SYSPATH') or die('No direct script access.');

?>
<?php echo ext::form_begin(NULL, array('method' => 'POST'))?>
<?php echo form::hidden('return_location', $return_location)?>
<?php echo ext::table_begin();?>
<?php foreach ($messages as $message):?>
			<?php echo ext::table_row_begin();?>
				<td class="FieldName"><?php echo $message->author->name . ' (' . date('d.m.Y H:i', $message->created_at) . '):'?></td>
				<td class="field">
				<?php echo $message->message_text;?>
				</td>
			<?php echo ext::table_row_end();?>
<?php endforeach;?>
<?php echo ext::table_end();?>
<?php echo ext::spacer();?>


<?php echo $form->render()?>
<?php echo ext::spacer()?>
<?php echo ext::buttons_begin()?>
<?php echo ext::submit('submit', 'Ответить');?>
<?php echo ext::submit('close', 'Закрыть');?>
<?php echo ext::submit('cancel', 'Отмена')?>
<?php echo ext::buttons_end()?>
<?php echo ext::form_end()?>
