<?php

defined('SYSPATH') or die('No direct script access.');
?>
<script>
	function confirm_message()
	{
		return confirm("Вы уверены, что указали правильные данные? После отправки запроса кошелек можно будет изменить только через службу поддержки");
	}
	function check_payout()
	{
		<?php if ($available_balance > 0):?>
			if (confirm_message())
			{
				$('#pay-form').submit();
			}
		<?php else:?>
			alert('Нет денег для вывода');
		<?php endif;?>
	}

</script>
<div class="right-column legal">
	<!-- warning box -->
	<?php if (!$requisites):?>
	<div class="warning-box">
		<div class="inner-warning">
			Ваш аккаунт не активирован!
			<span>Укажите реквизиты как юридического лица</span>
		</div>
	</div>
	<?php elseif (!$requisites->confirmed):?>
	<div class="warning-box">
		<div class="inner-warning">
			Ваш аккаунт не активирован!
			<span>Реквизиты на модерации</span>
		</div>
	</div>
	<?php endif;?>
	<!-- end warning box -->

	<?php if (isset($form_error)):?>
	<div class="warning-box">
		<div class="inner-warning">
			Ошибка при вводе реквизитов!
			<span>Все поля должны быть заполнены</span>
		</div>
	</div>
	<?php endif;?>
	<!-- partner info -->
	<div class="partner-info">
		<div class="info">
			<span>Вы зарегистрированы как: </span>юр. лицо
		</div>
	</div>
	<!-- end partner info -->

	<!-- legal form -->
	<div class="legal-form">
		<?php echo ext::form_begin(NULL,array('class' => 'req-form'));?>
			<?php foreach ($requisites_shortnames as $req_eng => $req_rus):?>
				<div class="input-line">
					<label><?php echo $req_rus?></label>
					<?php echo $form->get_field($req_eng)->set_attributes(array('id' => $req_eng, 'class' => 'text'))->render();?>
					<div class="clear"></div>
				</div>
			<?php endforeach;?>
		<?php if (!$requisites):?>
			<div class="input-line bottom">
				<input type="submit" name="send_reqs" class="button" onclick='javascript : return confirm_message();' value="отправить заявку" />
			</div>
		<?php endif;?>
		<?php echo ext::form_end();?>
	</div>
	<?php if (($requisites) AND ($requisites->confirmed)):?>
		<div class="partner-info">
			<?php if (isset($message)):?>
				<div class="info" style="color:green;">
					<?php echo $message;?>
				</div>
			<?php endif;?>

			<div class="info">
				<span>На балансе: </span><?php echo $current_balance?> рублей
			</div>

			<div class="info">
				<span>Доступно для снятия: </span><?php echo $available_balance?> рублей
			</div>

			<div class="info">
				<span>Ближайшая дата выплат: </span><?php echo $payout_date?>
			</div>
		</div>
		<!-- end partner info -->

		<div class="purse-button">
			<div class="purse-form">
				<?php echo ext::form_begin(NULL, array('id' => 'pay-form'));?>
					<input type="hidden" name="payout_submit" value="submit"/>
					<a href="#" onclick="javascript:check_payout();">
						вывести
						<span>на расчетный счет</span>
					</a>
				<?php echo ext::form_end();?>
			</div>
		</div>
	<?php endif;?>
</div>
<div class="clear"></div>

