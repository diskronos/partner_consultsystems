<?php

defined('SYSPATH') or die('No direct script access.');
?>
<h2> Профиль</h2>
<?php if (isset($message)) echo $message; ?>
<?php echo ext::form_begin();?>
<?php echo $form->render();?>
<input type="submit" name="submit" value="сменить пароль">
<?php echo ext::form_end();?>