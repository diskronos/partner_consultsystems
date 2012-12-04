<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */
?>
<?php if ($filter_form):?>
<?php echo ext::form_begin(NULL, array('method' => 'GET')) ?>

<?php echo $filter_form->render()?>

<?php echo ext::spacer();?>

<?php echo ext::buttons_begin()?>
<?php echo ext::submit('filter', 'Фильтр')?>
<?php echo ext::submit('filter_cancel', 'Очистить')?>
<?php echo ext::buttons_end()?>

<?php echo ext::form_end() ?>

<?php echo ext::spacer();?>
<?php endif;?>
<?php echo Navigation::instance()->actions()?>
<?php echo $grid; ?>