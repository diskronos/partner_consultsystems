<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::spacer()?>
<?php echo ext::buttons_begin()?>
<?php foreach($submits as $submit):?>
<?php echo ext::submit($submit['name'], $submit['value'])?>
<?php endforeach;?>
<?php echo ext::buttons_end()?>