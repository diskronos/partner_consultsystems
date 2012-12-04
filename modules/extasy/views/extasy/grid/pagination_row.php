<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php if($grid->pagination()->total_items > $items_per_page) :?>
<?php if(isset($splitter_top) AND $splitter_top):?>
<tr>
	<td colspan="100" class="HeaderSplitter"><div></div></td>
</tr>
<?php endif;?>
<tr>
	<td colspan="100" align="right">
<span style="float: left;">
<?php echo $grid->pagination();?>
</span>
<span style="float: right;">
Показывать записей:&nbsp;
<?php foreach(array(10, 50, 100, 250, 500, 1000) as $cur_per_page):?>
<?php if($items_per_page == $cur_per_page):?>
<?php echo $cur_per_page;?>
<?php else:?>
<?php echo html::anchor(URL::site(Request::initial()->uri()).URL::query(array('per_page' => $cur_per_page)), $cur_per_page);?>
<?php endif;?>&nbsp;
<?php endforeach;?>
</span>
	</td>
</tr>
<?php if(isset($splitter_bottom) AND $splitter_bottom):?>
<tr>
	<td colspan="100" class="HeaderSplitter"><div></div></td>
</tr>
<?php endif;?>
<?php endif;?>
