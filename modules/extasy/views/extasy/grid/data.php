<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php $num = 0;?>
<?php foreach($data as $row):?>
<?php echo ext::table_row_begin()?>
<?php if ($draw_checkboxes):?>
<td><?php echo form::checkbox('ids[]', $row['id'], FALSE)?></td>
<?php endif;?>
<?php 	foreach($columns as $column):?>
		<?php echo $column->field($row)?>
<?php 	endforeach;?>
<?php echo ext::table_row_end()?>
<?php endforeach;?>