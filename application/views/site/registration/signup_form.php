<?php

defined('SYSPATH') or die('No direct script access.');

?>
<script>
	$(document).ready(function(){
		<?php if (isset($error_message)):?>
			alert('<?php echo $error_message?>');
		<?php endif;?>
	});
</script>
<div class="sk-content">
	<div class="right-column">
		<?php echo $form->render()->set_filename('signup_block')?>
	</div>	
</div>