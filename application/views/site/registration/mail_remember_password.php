<?php

defined('SYSPATH') or die('No direct script access.');
/**
 *  @author Astapenko Yakoy <y.astapenko@smartdesign.by>
 *  @copyright KRIOS GROUP
 */
?>
Кто-то, возможно Вы сделали запрос на смену пароля от аккаунта на <a href="<?php echo URL::base(TRUE,TRUE)?>"><?php echo URL::base(TRUE,TRUE)?></a>. Если Вы действительно хотите сменить пароль, пройдите по <a href="<?php echo URL::base(TRUE,TRUE).URL::url_to_route('site-registration_remp?code='.$code)?>">этой ссылке</a> и введите новый пароль

