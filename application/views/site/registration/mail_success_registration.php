<?php

defined('SYSPATH') or die('No direct script access.');
?>

Уважаемый(-ая) <?php echo $fullname?>, поздравляем с успешной регистрацией на сайте <?php echo URL::site('', TRUE, TRUE);?>!<br>
Ваш логин: <?php echo $login;?><br>
Ваш пароль: <?php echo $password;?><br>
С уважением, команда сайта <?php echo URL::site('', TRUE, TRUE);?>.