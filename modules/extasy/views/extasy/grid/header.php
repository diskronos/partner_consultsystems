<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::table_header_begin()?>
<?php if ($draw_checkboxes):?>
<th><?php echo form::checkbox('ids_all', '1', FALSE, array('onclick' => "$('[type=checkbox][name=ids[]]').attr('checked', $(this).attr('checked'))"))?></th>
<?php endif;?>
<?php foreach($columns as $column):?>
<?php echo $column?>
<?php endforeach;?>
<?php echo ext::table_header_end()?>