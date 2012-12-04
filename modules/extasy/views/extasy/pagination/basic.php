<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */
$num = 3;
?>
<!--
	<?php if ($first_page !== FALSE): ?>
		<a href="<?php echo $page->url($first_page) ?>"><?php echo '&lt;&lt;' ?></a>
	<?php else: ?>
		<?php echo '&lt;&lt;' ?>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo $page->url($previous_page) ?>"><?php echo '&lt;' ?></a>
	<?php else: ?>
		<?php echo '&lt;' ?>
	<?php endif ?>
-->
<?php $prev = '';?>
	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

<?php //if(abs($i - $current_page) > $num AND $i > $num AND $total_pages - $i > $num - 1 AND $i % 100 != 0): ?>
<?php if(!(abs($i - $current_page) <= $num OR $i <= $num OR $total_pages - $i < $num OR ($i % 100 == 0 AND (/*($i > floor($total_pages / 200 - $num) * 100 AND $i < floor($total_pages / 200 + $num) * 100) OR */($i > ceil($current_page / 100 - $num) * 100) AND $i < ceil($current_page / 100 + $num) * 100)))): ?>
	<?php $prev = '...';?>
	<?php continue;?>
<?php endif;?>

<?php echo $prev;?>
<?php $prev = '';?>
		<?php if ($i == $current_page): ?>
			<strong><?php echo $i ?></strong>
		<?php else: ?>
			<a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a>
		<?php endif ?>

	<?php endfor ?>
<!--
	<?php if ($next_page !== FALSE): ?>
		<a href="<?php echo $page->url($next_page) ?>"><?php echo '&gt;' ?></a>
	<?php else: ?>
		<?php echo '&gt;' ?>
	<?php endif ?>

	<?php if ($last_page !== FALSE): ?>
		<a href="<?php echo $page->url($last_page) ?>"><?php echo '&gt;&gt;' ?></a>
	<?php else: ?>
		<?php echo '&gt;&gt;' ?>
	<?php endif ?>
-->
