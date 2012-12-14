<?php

defined('SYSPATH') or die('No direct script access.');

?>
		<script src="/js/highcharts.js"></script>
		<script type="text/javascript">
		$(function () {//var dates = <?php //echo $dates?>;
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'graph-container',
					type: 'line',
					marginRight: 25,
					marginBottom: 25
				},
				xAxis: {
					categories: <?php echo $graph_dates?>
				},
				title: {
					text: 'График клиентских платежей',
					x: -20 //center
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -10,
					y: 100,
					borderWidth: 0
				},
				series: [{
					name: 'Заработано',
					data: <?php echo $graph_earned?>
						},{
					name: 'Платежи',
					data: <?php echo $graph_payed?>
				}]
			})

//		var chart;
//		$(document).ready(function() {
//			chart = new Highcharts.Chart({
//				chart: {
//					renderTo: 'container',
//					type: 'line',
//					marginRight: 130,
//					marginBottom: 25
//				},
//				title: {
//					text: 'Monthly Average Temperature',
//					x: -20 //center
//				},
//				subtitle: {
//					text: 'Source: WorldClimate.com',
//					x: -20
//				},
//				xAxis: {
//					categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
//						'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
//				},
//				yAxis: {
//					title: {
//						text: 'Temperature (°C)'
//					},
//					plotLines: [{
//						value: 0,
//						width: 1,
//						color: '#808080'
//					}]
//				},
//				tooltip: {
//					formatter: function() {
//							return '<b>'+ this.series.name +'</b><br/>'+
//							this.x +': '+ this.y +'°C';
//					}
//				},
//				legend: {
//					layout: 'vertical',
//					align: 'right',
//					verticalAlign: 'top',
//					x: -10,
//					y: 100,
//					borderWidth: 0
//				},
//				series: [{
//					name: 'Tokyo',
//					data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
//				}, {
//					name: 'New York',
//					data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
//				}, {
//					name: 'Berlin',
//					data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
//				}, {
//					name: 'London',
//					data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
//				}]
//			});
//		});

	});
		</script>

<script type="text/javascript">
	var check_and_submit = function(){
		$('#form-stat').submit();
	};
</script>
<?php echo $form->render_jq();?>

<!-- statistic block -->
<div class="sk-statistic-block">

	<div class="left-column">

		<div class="graphic-block">
			<div class="graphic-sort">
				<?php echo ext::form_begin(NULL,array('id' => 'form-stat'));?>
					<span>с</span>
					<?php echo $form->get_field('from')->render();?>
					<span>по</span>
					<?php echo $form->get_field('to')->render();?>
					<input type="submit" onclick="javascript: check_and_submit(); return false;"class="button" value="" id="button"/>
					<div class="clear"></div>
				<?php echo ext::form_end();?>
			</div>
			<div class="graphic-block graph-cont" id="graph-container">
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
				<?php foreach ($registered as $date => $value):?>
					<tr>
						<td class="col1"><?php echo $date;?></td>
						<td class="col2">?</td>
						<td class="col3"><?php echo $registered[$date]?></td>
						<td class="col4"><?php echo $payed[$date]?></td>
						<td class="col5 last"><?php echo $earned[$date]?>.</td>
					</tr>
				<?php endforeach;?>
				<tr class="last">
					<td class="col1"></td>
					<td class="col2">?</td>
					<td class="col3"><?php echo array_sum($registered)?></td>
					<td class="col4"><?php echo array_sum($payed)?> рублей</td>
					<td class="col5 last"><?php echo array_sum($earned)?> рублей</td>
				</tr>
			</table>
		</div>
		<!-- end statistic table -->

	</div>

	<div class="right-column">

		<!-- clients box -->
		<div class="clients-box">
			<div class="number"><?php echo $user->clients->find_all()->count()?></div>
			<div class="text-box">
				клиентов
				<a href="/<?php echo URL::url_to_route('site-cabinet_clients');?>">посмотреть список</a>
			</div>
			<div class="clear"></div>
		</div>
		<!-- clients box -->

		<!-- earning block -->
		<div class="earning-block">
			<div class="earning-box">
				<?php  echo $balance->get_money_holded()?>
				<span class="value">руб.</span>
				<span class="name">в ожидании</span>
			</div>

			<div class="earning-box orange">
				<?php echo $user->balance//$user->balance;?>
				<span class="value">руб.</span>
				<span class="name">на балансе</span>
			</div>

			<div class="earning-box green">
				<?php  echo $user->money_earned?>
				<span class="value">руб.</span>
				<span class="name">всего заработано</span>
			</div>

			<div class="earning-box blue">
				<?php echo $balance->get_money_paidout()?>
				<span class="value">руб.</span>
				<span class="name">выплачено</span>
			</div>
		</div>			
		<!-- end earning block -->
	</div>
	<div class="clear"></div>

</div>
<!-- end statistic block -->
