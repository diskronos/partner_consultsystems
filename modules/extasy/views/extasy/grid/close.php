<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo view::factory('grid/pagination_row', array(
	'grid' => $grid,
	'splitter_top' => TRUE,
	'items_per_page' => $items_per_page,
))?>
<?php echo ext::table_end()?>
<?php if ( ! empty($group_actions)):?>
<?php echo ext::spacer()?>
<?php echo ext::buttons_begin()?>
<?php foreach($group_actions as $name => $action):?>
	<?php echo ext::submit('action['.$name.']', $action['title'], arr::get($action, 'confirm'))?>
<?php endforeach;?>
<?php echo ext::buttons_end()?>
<?php endif;?>
<?php echo ext::form_end()?>