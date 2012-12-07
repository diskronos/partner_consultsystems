<?php

defined('SYSPATH') or die('No direct script access.');
?>
<!-- support block -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.message-box:last').addClass('bottom');
	});
</script>
<div class="sk-support-block">

	<div class="dialog-column">

		<div class="back-link">
			<a href="/<?php echo URL::url_to_route('site-cabinet_support:index');?>">вернуться назад</a>
		</div>

		<div class="dialog-title"><?php echo $branch->topic;?></div>
		<?php foreach ($messages as $message):?>
			<div class="message-box<?php if ($message->author_id != $user->id) echo ' admin'?>">
				<div class="text">
					<?php echo $message->message_text;?>
				</div>
				<span class="date"><?php echo date('d.m.Y H:i', $message->created_at);?></span>
				<span class="name"><?php echo ($message->author_id == $user->id) ? 'Ваше сообщение' : 'Администратор';?></span>
			</div>
		<?php endforeach;?>
		<?php echo ext::form_begin(NULL,array('class' => 'ticket-form'));?>
			<?php echo $form->get_field('message_text')->set_attributes(array('class'=>'textarea'))->render()?>
			<div class="input-line bottom">
				<input type="submit" class="button" name="submit" value="отправить" />
			</div>
		<?php echo ext::form_end();?>
	</div>

</div>
		<!-- end support block -->
