<?php

defined('SYSPATH') or die('No direct script access.');
?>
<div class="right-column">
	<!-- warning box -->
	<?php if (isset($form_error)):?>
		<div class="warning-box">
			<div class="inner-warning">
				Ошибка!
				<span><?php echo $form_error?></span>
			</div>
		</div>
	<?php endif;?>
	<!-- end warning box -->

	<!-- partner info -->
	<div class="partner-info">

		<div class="info">
			<span>Вы зарегистрированы как: </span>физ. лицо
		</div>

		<div class="info">
			<span>На балансе: </span><?php echo $balance->get_money_balance()?> рублей
		</div>

	</div>
	<!-- end partner info -->
<!--	 partner info -->
	<div class="partner-info">

		<div class="info">
			<span>Доступно для снятия: </span><?php echo $balance->get_money_available()?> рублей
		</div>

		<div class="info">
			<span>Ближайшая дата выплат: </span><?php echo $payout_date?>
		</div>

	</div>
	<div class="purse-button">
		<?php echo ext::form_begin(NULL, array('id' => 'pay-form'));?>
			<?php echo $form_payout->get_field('payout_sum')->set_attributes(array('class' => 'text'))->render();?>
			<br><br><br><br>
			<a href="#" onclick="javascript:$('#pay-form').submit();">
				вывести
				<span>на кошелек</span>
			</a>
		<?php echo ext::form_end();?>
	</div>
</div>
<div class="clear"></div>

