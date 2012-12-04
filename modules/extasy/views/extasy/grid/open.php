<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::form_begin()?>
<?php echo form::hidden('group_actions', 1)?>
<?php echo ext::table_begin()?>
<?php echo view::factory('grid/pagination_row', array(
	'grid' => $grid,
	'splitter_bottom' => TRUE,
	'items_per_page' => $items_per_page,
))?>