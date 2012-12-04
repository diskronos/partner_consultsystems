<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php 
$last = array_pop($crumbs);
array_pop($links);
?>
<div class="Crumbs">
<?php foreach($links as $link):?>
<?php echo $link?>
<?php echo html::image('extasy/img/icons/crumbs_normal.gif')?>
<?php endforeach;?>
<b><i><?php echo $last['title']?></i></b>
<?php echo html::image('extasy/img/icons/crumbs_cur.gif')?>
</div>
