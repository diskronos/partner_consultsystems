<?php

defined('SYSPATH') or die('No direct script access.');
?>
<?php echo str_replace('%%id%%', $user->id, $page->page_content);?>