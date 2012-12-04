<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::form_fields_begin()?>
<?php foreach($fields as $field):?>
<?php echo $field?>
<?php endforeach;?>
<?php echo ext::form_fields_end()?>