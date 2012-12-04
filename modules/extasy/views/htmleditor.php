<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php if ( ! $initialized):?>
<?php echo html::script('ckeditor/ckeditor.js'); ?>
<?php echo html::script('ajexFileManager/ajex.js'); ?>
<?php endif;?>
<script type="text/javascript">
<!--
$(document).ready(function(){
	var ckeditor = CKEDITOR.replace('<?php echo $name ?>', <?php echo ! empty($config) ? json_encode($config) : '{}'?>);
	AjexFileManager.init ({ 
		returnTo: 'ckeditor',
		editor: ckeditor,
		skin: 'light'
	});
});
//-->
</script>