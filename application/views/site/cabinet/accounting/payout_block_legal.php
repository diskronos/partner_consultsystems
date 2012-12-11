<?php

defined('SYSPATH') or die('No direct script access.');

?>
<div class="right-column legal">
	<?php if (isset($form_error)):?>
		<div class="warning-box">
			<div class="inner-warning">
				Ошибка!
				<span><?php echo $form_error?></span>
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

	<!-- partner info -->
	<div class="partner-info">

		<div class="info">
			<span>На балансе: </span><?php echo $balance->get_money_balance()?> рублей
		</div>

		<div class="info">
			<span>Доступно для снятия: </span><?php echo $balance->get_money_available()?> рублей
		</div>

		<div class="info">
			<span>Ближайшая дата выплат: </span><?php echo $payout_date?>
		</div>
	</div>
	<!-- end partner info -->

	<div class="purse-button">
		<div class="purse-form">
			<?php echo ext::form_begin(NULL, array('id' => 'pay-form'));?>
				<?php echo $form_payout->get_field('payout_sum')->set_attributes(array('class' => 'text', 'width' => 'auto'))->render();?>
				<br><br><br><br>
				<a href="#" onclick="javascript:$('#pay-form').submit();">
					вывести
					<span>на расчетный счет</span>
				</a>
			<?php echo ext::form_end();?>
		</div>
	</div>
</div>
<div class="clear"></div>

