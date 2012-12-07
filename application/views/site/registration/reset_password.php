<?php

defined('SYSPATH') or die('No direct script access.');
?>
<div id="signupblock">
	<h1>Восстановление пароля:</h1>
	<?php echo ext::form_begin();?>
		<?php echo $form->get_field('email')->render();?>
		<input type="submit" name="submit" value="Восстановить пароль"></td>
		<span style="color:red">
			<?php echo $form->get_field('email')->get_error();?>
		</span>
	<?php echo ext::form_end();?>
</div>