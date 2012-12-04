<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::buttons_begin()?>
<?php foreach($buttons as $button):?>
	<?php echo $button?>
<?php endforeach;?>
<?php echo ext::buttons_end()?>