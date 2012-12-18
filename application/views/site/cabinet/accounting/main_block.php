<?php

defined('SYSPATH') or die('No direct script access.');

?>
<script type="text/javascript">
	var check_and_submit = function(){
		$('#form-move').submit();
	};
</script>

<?php echo $form->render_jq();?>

<div class="left-column">
	<div class="progress-sort">
		<span>Движения средств</span>
		<div class="graphic-sort">
			<?php echo ext::form_begin(NULL,array('id' => 'form-move'));?>
				<span>с</span>
				<?php echo $form->get_field('from')->render();?>
				<span>по</span>
				<?php echo $form->get_field('to')->render();?>
				<input type="submit" onclick="javascript: check_and_submit(); return false;"class="button" value="" id="button"/>
				<div class="clear"></div>
			<?php echo ext::form_end();?>
		</div>
		<div class="clear"></div>
	</div>

	<!-- payment table -->
	<div class="payment-table">
		<table>
			<tr>
				<td class="col1">описание</td>
				<td class="col2">сумма</td>
				<td class="col3 last">дата</td>
			</tr>

			<?php foreach ($payments_as_partner as $payment):?>
				<tr class="tr-<?php echo $payment->color; ?>">
					<td class="col1"><?php echo $payment->commentary?></td>
					<td class="col2"><?php echo $payment->payment_sum_signed?></td>
					<td class="col3 last"><?php echo $payment->date?></td>
				</tr>
			<?php endforeach;?>
			<?php foreach ($payouts as $payout):?>
				<tr class="tr-<?php echo $payout->color; ?>">
					<td class="col1"><?php echo $payout->commentary?></td>
					<td class="col2"><?php echo $payout->balance_change?></td>
					<td class="col3 last"><?php echo $payout->date?></td>
				</tr>
			<?php endforeach;?>

		</table>
	</div>
	<!-- end payment table -->

	<!-- payment navi -->
<!--		<div class="navi-box">
			<span>Страницы:</span>
			<ul>
				<li class="selected"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>-->
	<!-- end payment navi -->

	<!-- description block -->
	<div class="description-block">

		<div class="description-box">
			<div class="color"></div>
			<div class="text">- деньги доступны для снятия</div>
			<div class="clear"></div>
		</div>

		<div class="description-box gray-box">
			<div class="color"></div>
			<div class="text">- деньги в ожидании</div>
			<div class="clear"></div>
		</div>

		<div class="description-box yellow-box">
			<div class="color"></div>
			<div class="text">- вывод средств на кошелек</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<!-- end description block -->
</div>
