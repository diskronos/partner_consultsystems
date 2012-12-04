<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */
?>
                            <td class="SiteControls" >
<?php if($is_logged):?>
Здравствуйте, <?php echo $username?><br />
<?php echo html::link_to_route('admin-auth:change_password', 'Изменить пароль')?>&nbsp;
<?php echo html::link_to_route('admin-auth:logout', 'Выйти')?>
<?php else:?>
Здравствуйте, Гость<br />
<?php echo html::link_to_route('admin-auth:login', 'Войти')?>&nbsp;
<?php echo html::link_to_route('admin-auth:reset_password_step_1', 'Забыл пароль')?>
<?php endif;?>
                            </td>