<?php defined('SYSPATH') or die('No direct script access.');
?>
<!-- clients block -->
<div class="sk-clients-block">

	<!-- search box -->
	<div class="search-box">
		<div class="search-line">
			<form action="">
				<input type="button" class="button" value="" />
				<input type="text" class="text" onfocus="if(this.value=='поиск по логину или сайту...') this.value=''" onblur="if(this.value=='') this.value='поиск по логину или сайту...';" value="поиск по логину или сайту..."/>
			</form>
			<div class="clear"></div>
		</div>

		<div class="client-registration">
			<a href="/<?php echo URL::url_to_route('site-cabinet_clients:new');?>">зарегистрировать клиента</a>
		</div>
		<div class="clear"></div>
	</div>
	<!-- end search box -->

	<!-- clients table -->
	<div class="clients-table">
		<table>
			<tr>
				<td class="col1">логин</td>
				<td class="col2">сайты</td>
				<td class="col3">тариф</td>
				<td class="col4">дата.откл.</td>
				<td class="col5">дата рег.<img src="/images/table-arrow.png"/></td>
				<td class="col6">платежей</td>
				<td class="col7 last">заработано</td>
			</tr>
<!--			<tr class="tr-light-green">
				<td class="col1">test1</td>
				<td class="col2">
					<div class="client-site">

					</div>
				</td>
				<td class="col3">оптимальный</td>
				<td class="col4">12.11.2012</td>
				<td class="col5">26.10.2012</td>
				<td class="col6">12000 руб.</td>
				<td class="col7 last">4000 руб.</td>
			</tr>-->
			<?php foreach ($clients as $client):?>
				<tr class="tr-light-green">
					<td class="col1">
						<?php echo $client->name?>
					</td>
					<td class="col2">
						<div class="client-site">
							<?php echo 'сайт';?>
						</div>
					</td>
					<td class="col3">
						<?php echo 'тариф';?>
					</td>
					<td class="col4">
						<?php echo 'дата чегото';?>
					</td>
					<td class="col5">
						<?php echo date( 'd.m.Y',$client->created_at)?>
					</td>
					<td class="col6">
						<?php echo 'сумма всех платежей';?>
					</td>
					<td class="col7 last">
						<?php echo 'заработано на посане'?>
					</td>

					
				</tr>
				<!--<tr class="tr-light-green">
				<tr class="tr-light-yellow">
				<tr class="tr-light-pink">-->
			<?php endforeach;?>
		</table>
	</div>
	<!-- end clients table -->

	<!-- info block -->
	<div class="info-block">

<!--		<div class="navi-box">
			<span>Страницы:</span>
			<ul>
				<li class="selected"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
			</ul>
			<div class="clear"></div>
		</div>-->

		<div class="counter-box">
			<span>Всего:</span> <?php echo $clients->count();?> клиентов
		</div>
		<div class="clear"></div>
	</div>
	<!-- end info block -->

</div>
<!-- end clients block -->
