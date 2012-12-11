<?php

defined('SYSPATH') or die('No direct script access.');

?>
<!-- top head -->
<div class="top-head">

	<div class="user-info">
		<span class="user-name"><?php echo $user->name;?></span>
		<span class="user-nikname">(<?php echo $user->name;?>)</span>
		<img src="/images/user-purse.png"/>
		<span class="user-purse"><?php echo $user->balance?> руб.</span>
	</div>

	<div class="top-links">
		<a href="/<?php echo URL::url_to_route('site-profile');?>" class="profile"><img src="/images/user-button.png"/>профиль</a>
		<a href="/<?php echo URL::url_to_route('site-registration:logout');?>"><img src="/images/exit-button.png"/>выход</a>
	</div>
	<div class="clear"></div>
</div>
<!-- end top head -->
