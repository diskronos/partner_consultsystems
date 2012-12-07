<?php defined('SYSPATH') or die('No direct script access.');?>

<!-- payment block -->
<div class="sk-payment-block">
	<?php echo Request::factory(Url::url_to_route('site-cabinet_accounting:main_block'))->execute();?>
	<?php echo Request::factory(Url::url_to_route('site-cabinet_accounting:requisites_block'))->execute();?>
</div>
<!-- end payment block -->
