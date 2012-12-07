<?php

defined('SYSPATH') or die('No direct script access.');

?>
<div id="account">
	<div id="autoauth">Приветствуем Вас, <strong><?php echo $user->name?></strong>.<br>
		<table>
			<tbody><tr>
            <td width="20"><img src="/images/icon_cp.png"></td>
            <td><a href="/<?php echo Url::url_to_route('site-cabinet');?>">панель управления</a></td>
            <td width="20">&nbsp;</td>
			<td width="20"><img src="/images/user-button.png"></td>
            <td><a href="/<?php echo URL::url_to_route('site-profile')?>">профиль</a></td>
            <td width="20">&nbsp;</td>
            <td width="20"><img src="/images/icon_exit.png"></td>
			<td><a href="/<?php echo URL::url_to_route('site-registration:logout');?>">выход</a></td>
            </tr>
			</tbody>
		</table>
	</div>
</div>