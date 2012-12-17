<?php

defined('SYSPATH') or die('No direct script access.');
?>
<script>
	function confirm_message()
	{
		return confirm("Вы уверены, что указали правильные данные? После отправки запроса кошелек можно будет изменить только через службу поддержки");
	}
</script>
<div class="right-column">
	<!-- warning box -->
	<?php if (!$requisites):?>
		<div class="warning-box">
				<div class="inner-warning">
					Не указаны реквизиты!
					<span>Укажите WMR кошелек для вывода средств</span>
				</div>
		</div>
	<?php endif; ?>

	<?php if (isset($form_error)):?>
		<div class="warning-box">
			<div class="inner-warning">
				Ошибка при вводе реквизитов!
				<span>Все поля должны быть заполнены</span>
			</div>
		</div>
	<?php endif;?>
	<!-- end warning box -->

	<!-- partner info -->
	<div class="partner-info">

		<div class="info">
			<span>Вы зарегистрированы как: </span>физ. лицо
		</div>

	</div>
	<!-- end partner info -->

	<!-- purse form -->
	<div class="purse-form">
		WMR кошелек для вывода средств:

		<?php echo ext::form_begin(NULL,array('class' => 'req-form'));?>
			<?php echo $form->get_field('wmz_purse_number')->set_attributes(array('class' => 'text'))->render()?>
				<?php if (!$requisites):?>
		<input type="submit" name="send_reqs"class="button" onclick='javascript : return confirm_message();' value="" />
				<?php endif;?>
			<div class="clear"></div>
		<?php echo ext::form_end()?>

		Указывается один раз, изменить нельзя
	</div>

	<!--	 partner info -->
	<div class="partner-info">

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
	<?php if ($requisites): ?>
		<div class="purse-button">
			<?php echo ext::form_begin(NULL, array('id' => 'pay-form'));?>
				<input type="hidden" name="payout_submit" value="submit"/>
				<a href="#" onclick="javascript:$('#pay-form').submit();">
					вывести
					<span>на кошелек</span>
				</a>
			<?php echo ext::form_end();?>
		</div>
	<?php endif; ?>
</div>
<div class="clear"></div>
