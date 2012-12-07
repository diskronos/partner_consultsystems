<?php

defined('SYSPATH') or die('No direct script access.');

?>

<script type="text/javascript">

function showLogin()
{
	$("#logindialog").fadeIn(100);
	$("#auth_login").focus();
}	
function checkLogin(){
	$("#loginerr").html('<table><tr><td width="32" height="23"><img src="/images/login/loading.gif" /></td><td>&nbsp;&nbsp;Проверка данных...</td></tr></table>');
	$.post("/registration/ajax_check_login", {
		login: $("#login").val(),
		password: $("#password").val(),
		remember: $("#remember").attr("checked")
		},
	function(data){
		if(!data.result)
		{
			$("#loginerr").html('<table><tr><td width="32" height="23"><img src="/images/error.png" /></td><td>Неверный логин/пароль</td></tr></table>');
		}
		else
		{
			$("#loginerr").html('<table><tr><td width="32" height="23"><img src="/images/valid.png" /></td><td>Перенаправление...</td></tr></table>');
			window.location.href="/";
		}
	},"json");
}

function closeLogin()
	{
		$("#logindialog").fadeOut(100);
	}
</script>
<div id="account">
	<a href="<?php echo Url::url_to_route('site-registration:signup');?>"><img src="/images/signup.png" border="0" alt="Регистрация" /></a>
	<a href="javascript:showLogin();"><img src="/images/login.png" border="0" alt="Войти под паролем" /></a>
</div>
<!-- popup login_form -->
<noindex>
<div class="partner-login-popup" id="logindialog" style="display: none;">
	<div class="partner-login-block">
		<div class="login-top">
			<img src="/images/partner-form-key.png" alt="">
			<div class="partner-login-popup-title">
				Вход для клиентов
			</div>
			<div class="escape">
				<a href="javascript:closeLogin();"></a>
			</div>
			<div class="clear"></div>
		</div>

		<div class="login-form">
				<div class="input-line">
					<span>логин:</span>
					<input type="text" id="login" class="text">
				</div>

				<div class="input-line">
					<span class="bottom">пароль:</span>
					<input type="password" id="password" class="text">
				</div>

				<div class="checkbox-box" id="points">
					<input type="checkbox" value="y" id="remember">
					<label for="autologin">запомнить</label>
				</div>
				<div class="input-line button">
					<input type="button" class="button" onclick="checkLogin();" value="войти">
				</div>
				<div class="clear"></div>

				<div id="loginerr"></div>
				<div class="clear"></div>
				<div id="lostpass"><a href="/<?php echo Url::url_to_route('site-registration:reset_password');?>"><ins>Забыли пароль?</ins></a></div>
				<div class="clear"></div>

		</div>
	</div>
</div>
</noindex>
<!-- popup login_form -->

