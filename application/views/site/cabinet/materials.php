<?php

defined('SYSPATH') or die('No direct script access.');
?>
<?php echo str_replace('%%id%%', $user->id, $page->page_content);?>
<?php if (($user->status == 'legal') AND ($user->requisites) AND ($user->requisites->confirmed)):?>
    <?php echo HTML::anchor(URL::url_to_route('site-template_doc?name='.$user->id),'Партнерский документ', array('target' => 'blank'));?>
<?php endif; ?>

