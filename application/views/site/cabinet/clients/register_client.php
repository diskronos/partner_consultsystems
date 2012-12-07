<?php

defined('SYSPATH') or die('No direct script access.');
?>
<?php echo Request::factory(URL::url_to_route('site-registration:signup_client'))->execute()?>