<?php

defined('SYSPATH') or die('No direct script access.');
?>
Логин: <?php echo $user->name;?><br><br>
Имя: <?php echo $user->fullname;?><br><br>
Статус: <?php echo $user->status_rendered;?><br><br>



<?php if (isset($message)) echo $message; ?>
<?php echo ext::form_begin();?>
<?php echo $form->render();?>
<input type="submit" name="submit" value="сменить пароль">
<?php echo ext::form_end();?>