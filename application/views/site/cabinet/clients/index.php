<?php defined('SYSPATH') or die('No direct script access.');
?>
<script type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>

<script>
	$(document).ready(function(){
		$("#client-table").tablesorter({cssDesc : "headerSortDown", cssAsc : "headerSortUp"});
		$('#sub').click(function(){
			$input = $('input[name=search]');
			if ($input.val() == 'поиск по логину или сайту...')
			{
				$input.val('');
			}
		});
		$('input[name=search]').bind( 'keyup change', function(){
			$("#client-table tbody tr").each(function(){
				var search_str = $('input[name=search]').val();
				if (($(this).children('.col1').html().search(new RegExp(search_str ,'gi')) != -1) ||
					($(this).children('.col2').html().search(new RegExp(search_str ,'gi')) != -1))
				{
					$(this).show();
				}
				else
				{
					$(this).hide();
				}
				
			});
		});
	});
</script>
<!-- clients block -->
<div class="sk-clients-block">

	<!-- search box -->
	<div class="search-box">
		<div class="search-line">
			<form action="" method="get" id="search-form">
				<input type="submit" class="button" value="" id="sub"/>
				<input type="text" name="search" class="text" onfocus="if(this.value=='поиск по логину или сайту...') this.value=''" onblur="if(this.value=='') this.value='поиск по логину или сайту...';" value="поиск по логину или сайту..."/>
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
		<table id="client-table">
			<thead>
				<tr>
					<th class="col1">логин</th>
					<th class="col2">сайты</th>
					<th class="col3">тариф</th>
					<th class="col4">дата.откл.</th>
					<th class="col5">дата рег.</th>
					<th class="col6">платежей</th>
					<th class="col7 last">заработано</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($clients as $client):?>
				<tr class="tr-light-green">
					<td class="col1">
						<?php echo $client->login?>
					</td>
					<td class="col2">
						<div class="client-site">
							<?php foreach ($client->sites->find_all() as $site): ?>
								<?php echo $site->url;?><br>
							<?php endforeach;?>
						</div>
					</td>
					<td class="col3">
						<?php echo $client->tariff;?>
					</td>
					<td class="col4">
						<?php echo is_null($client->date_expire) ? '--' : date('d.m.Y', $client->date_expire);?>
					</td>
					<td class="col5">
						<?php echo date( 'd.m.Y',$client->created_at)?>
					</td>
					<td class="col6">
						<?php echo isset($client_payments[$client->id]) ? $client_payments[$client->id]['payed'] : 0;?>
					</td>
					<td class="col7 last">
						<?php echo isset($partner_payments[$client->id]) ? $partner_payments[$client->id]['earned'] : 0;?>
					</td>

					
				</tr>
				<!--<tr class="tr-light-green">
				<tr class="tr-light-yellow">
				<tr class="tr-light-pink">-->
			<?php endforeach;?>
			</tbody>
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
