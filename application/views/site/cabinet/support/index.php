<?php

defined('SYSPATH') or die('No direct script access.');
?>
<?php if (isset($message)) echo $message;?>
<!-- support block -->
<div class="sk-support-block">

	<div class="left-column">
		<div class="support-title">Поддержка</div>

		<!-- support table -->
		<div class="support-table">
			<table>
				<?php foreach ($ticket_branches as $ticket_branch):?>
					<tr <?php if ($ticket_branch->new_messages_admin > 0) echo 'class="tr-light-yellow"'?>>
						<td class="col1">
							<div class="left-td">
								<a href="/<?php echo URL::url_to_route('site-cabinet_support:ticket?id='.$ticket_branch->id);?>" <?php if ($ticket_branch->new_messages_admin > 0) echo 'class="td-orange"'?>><?php echo $ticket_branch->topic?></a>
								<div class="clear"></div>
								<?php echo $ticket_branch->message_count?> сообщений <?php if ($ticket_branch->new_messages_admin > 0) echo '(есть новые)'?>
							</div>
						</td>
						<td class="col2 last"><?php echo date('d.m.Y', $ticket_branch->created_at)?></td>
					</tr>
				<?php endforeach;?>

			</table>
		</div>
		<!-- end support table -->

	</div>

	<div class="right-column legal">
		<div class="support-title">Новый запрос</div>

		<!-- request form -->
		<div class="request-form">
			<?php echo ext::form_begin(NULL,array('class' => 'ticket-form'));?>
<!--				<div class="input-line">
						<select>
								<option>Оригиналы документов</option>
								<option>документов</option>
								<option>Оригиналы документов</option>
						</select>
				</div>-->

				<div class="input-line">
					<label>Тема:</label>
					<?php echo $form->get_field('topic')->set_attributes(array('class'=>'text'))->render()?>
					<div class="clear"></div>
				</div>
				<?php echo $form->get_field('message_text')->set_attributes(array('class'=>'textarea'))->render()?>

				<div class="input-line bottom">
					<input type="submit" class="button" name="submit" value="отправить заявку" />
				</div>
				<div class="clear"></div>
			<?php echo ext::form_end();?>
		</div>
		<!-- end request form -->

	</div>
	<div class="clear"></div>

</div>
		<!-- end support block -->
