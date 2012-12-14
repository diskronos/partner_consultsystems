<?php

defined('SYSPATH') or die('No direct script access.');

?>
<!-- sk inner menu -->
<div class="sk-inner-menu">
	<ul>
		<li class="item-1<?php if ($active == 'statistics') echo ' selected';?>"><a href="/<?php echo URL::url_to_route('site-cabinet_statistics');?>">Статистика</a></li>
		<li class="item-2<?php if ($active == 'clients_new') echo ' selected';?>"><a href="/<?php echo URL::url_to_route('site-cabinet_clients:new');?>">Зарегистрировать</a></li>
		<li class="item-3<?php if ($active == 'materials') echo ' selected';?>"><a href="/<?php echo URL::url_to_route('site-cabinet?action=materials');?>">Материалы</a></li>
		<li class="item-4<?php if ($active == 'clients') echo ' selected';?>"><a href="/<?php echo URL::url_to_route('site-cabinet_clients');?>">Клиенты</a></li>
		<li class="item-5<?php if ($active == 'accounting') echo ' selected';?>"><a href="/<?php echo URL::url_to_route('site-cabinet_accounting');?>">Бухгалтерия</a></li>
		<li class="item-6<?php if ($active == 'support') echo ' selected';?>"><a href="/<?php echo URL::url_to_route('site-cabinet_support');?>">Поддержка</a></li>
	</ul>
	<div class="clear"></div>
</div>
<!-- end sk inner menu -->
