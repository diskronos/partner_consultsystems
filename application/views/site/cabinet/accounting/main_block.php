<?php

defined('SYSPATH') or die('No direct script access.');

?>

<div class="left-column">
	<div class="progress-sort">
		<span>Движения средств</span>
		<div class="graphic-sort">
			<form action="#">
				<span>с</span>
				<input type="text" class="text" id="from" value="11.11.2012" />
				<span>по</span>
				<input type="text" class="text" id="to" value="11.11.2012" />
				<input type="button" class="button" value="" />
				<div class="clear"></div>
			</form>
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

			<tr class="tr-green">
				<td class="col1">40% процентов за оплату (логин test2)</td>
				<td class="col2">+2300 руб.</td>
				<td class="col3 last">14.11.2012</td>
			</tr>
			<tr class="tr-yellow">
				<td class="col1">Вывод средств с баланса (на R3223444345)</td>
				<td class="col2">-2300 руб.</td>
				<td class="col3 last">12.11.2012</td>
			</tr>
			<tr class="tr-gray">
				<td class="col1">40% процентов за оплату (логин test2)</td>
				<td class="col2">+2300 руб.</td>
				<td class="col3 last">14.11.2012</td>
			</tr>
		</table>
	</div>
	<!-- end payment table -->

	<!-- payment navi -->
		<div class="navi-box">
			<span>Страницы:</span>
			<ul>
				<li class="selected"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
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
