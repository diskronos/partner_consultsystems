<?php

defined('SYSPATH') or die('No direct script access.');

?>
		<!-- statistic block -->
<div class="sk-statistic-block">

	<div class="left-column">

		<div class="graphic-block">
			<div class="graphic-sort">
				<form action="#">
					<span>с</span>
					<input type="text" class="text" id="from" value="11.11.2012" />
					<span>по</span>
					<input type="text" class="text" id="to" value="11.11.2012" />
					<input type="button" class="button" value="" id="button"/>
					<div class="clear"></div>
				</form>
			</div>
		</div>

		<!-- statistic table -->
		<div class="statistic-table">
			<table>
				<tr>
					<td class="col1">дата</td>
					<td class="col2">переходов</td>
					<td class="col3">регистраций</td>
					<td class="col4">платежей</td>
					<td class="col5 last">заработано</td>
				</tr>

				<tr>
					<td class="col1">26.10.2012</td>
					<td class="col2">233</td>
					<td class="col3">5</td>
					<td class="col4">12000 руб.</td>
					<td class="col5 last">4000 руб.</td>
				</tr>
				<tr>
					<td class="col1">27.10.2012</td>
					<td class="col2">133</td>
					<td class="col3">0</td>
					<td class="col4">12000 руб.</td>
					<td class="col5 last">4000 руб.</td>
				</tr>
				<tr>
					<td class="col1">27.10.2012</td>
					<td class="col2">155</td>
					<td class="col3">3</td>
					<td class="col4">12000 руб.</td>
					<td class="col5 last">4000 руб.</td>
				</tr>
				<tr>
					<td class="col1">27.10.2012</td>
					<td class="col2">633</td>
					<td class="col3">0</td>
					<td class="col4">12000 руб.</td>
					<td class="col5 last">4000 руб.</td>
				</tr>
				<tr class="last">
					<td class="col1"></td>
					<td class="col2">2300</td>
					<td class="col3">8</td>
					<td class="col4">48000 рублей</td>
					<td class="col5 last">16000 рублей</td>
				</tr>
			</table>
		</div>
		<!-- end statistic table -->

	</div>

	<div class="right-column">

		<!-- clients box -->
		<div class="clients-box">
			<div class="number">11</div>
			<div class="text-box">
				клиентов
				<a href="#">посмотреть список</a>
			</div>
			<div class="clear"></div>
		</div>
		<!-- clients box -->

		<!-- earning block -->
		<div class="earning-block">

			<div class="earning-box">
				1400
				<span class="value">руб.</span>
				<span class="name">в ожидании</span>
			</div>

			<div class="earning-box orange">
				3400
				<span class="value">руб.</span>
				<span class="name">на балансе</span>
			</div>

			<div class="earning-box green">
				12600
				<span class="value">руб.</span>
				<span class="name">всего заработано</span>
			</div>

			<div class="earning-box blue">
				5600
				<span class="value">руб.</span>
				<span class="name">выплачено</span>
			</div>

		</div>			
		<!-- end earning block -->

	</div>
	<div class="clear"></div>

</div>
<!-- end statistic block -->
