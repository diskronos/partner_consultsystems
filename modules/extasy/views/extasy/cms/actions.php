<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php if( ! empty($actions)):?>
<?php echo ext::actions_begin()?>
<?php foreach($actions as $action):?>
	<?php echo ext::actions_row($action['route'], $action['title'])?>
<?php endforeach;?>
<?php echo ext::actions_end()?>
<?php endif;?>