<?php

defined('SYSPATH') or die('No direct script access.');
?>

<script>
	function fieldValid(fieldid,text)
	{
		$("#"+fieldid+"_block").css("background-color","#E9F6C9");
		$("#"+fieldid+"_block .form_error_block").html('<img src="/images/yes.png" />');
		$("#"+fieldid+"_block .form_hint_block").css('color','#1C8813');
		$("#"+fieldid+"_block .form_hint_block").html(text);
	}
	function fieldError(fieldid,text)
	{
		$("#"+fieldid+"_block").css("background-color","#FFDED3");
		$("#"+fieldid+"_block .form_error_block").html('<img src="/images/no.png" />');
		$("#"+fieldid+"_block .form_hint_block").css('color','#E13604');
		$("#"+fieldid+"_block .form_hint_block").html(text);
	}

	function validMail(){
		$.post("/<?php echo URL::url_to_route('site-cabinet_clients:ajax_signup_check_email')?>", { v: $("#user_mail").val() },
		function(data){
			if(data.result=='error') fieldError('user_mail',data.comment);            
			if(data.result=='valid') fieldValid('user_mail',data.comment);
		}, "json");
	}
	function validName(){
		$.post("/<?php echo URL::url_to_route('site-cabinet_clients:ajax_signup_check_name')?>", { v: $("#user_name").val() },
		function(data){
			if(data.result=='error') fieldError('user_name',data.comment);            
			if(data.result=='valid') fieldValid('user_name',data.comment);
		}, "json");
	}

	function validPass(){
		$.post("/<?php echo URL::url_to_route('site-cabinet_clients:ajax_signup_check_pass')?>", { v: $("#user_pass").val() },
		function(data){
			if(data.result=='error') fieldError('user_pass',data.comment);            
			if(data.result=='valid') fieldValid('user_pass',data.comment);
		}, "json");
	}
	function validPassAgain(){
		$.post("/<?php echo URL::url_to_route('site-cabinet_clients:ajax_signup_check_pass_confirm')?>", { v1: $("#user_pass").val(), v2: $("#user_pass_again").val() },
		function(data){
			if(data.result=='error') fieldError('user_pass_again',data.comment);            
			if(data.result=='valid') fieldValid('user_pass_again',data.comment);
		}, "json");
	}
	
	function validLogin(){
		$.post("/<?php echo URL::url_to_route('site-cabinet_clients:ajax_signup_check_login')?>", { v: $("#user_login").val() },
		function(data){
			if(data.result=='error') fieldError('user_login',data.comment);
			if(data.result=='valid') fieldValid('user_login',data.comment);
		}, "json");
	}
	

	function signUpSubmit(){
		$("#loading").show();
		$.post("/<?php echo URL::url_to_route('site-cabinet_clients:ajax_proceed_registration')?>", $('form').serialize(),
			function(data){
				$("#loading").hide();
				if(data.result=='regsuccess'){
					$('#signupblock').fadeOut('slow', function() {
						$('#aftersignupblock').fadeIn('slow');
					});
				}
				if(data.result=='haveerr'){
					validLogin();
					validPass();
					validPassAgain();
					validMail();
					validName();
					alert("Есть ошибки при вводе данных, пожалуйста исправьте их.\nВсе поля обязательны к заполнению.");
				}
			},"json");

		return false;
	}
	$(function(){
		$("#user_name").focus();
		$("#user_pass").blur(function() {
			validPass();
		});
		$("#user_pass_again").blur(function() {
			validPassAgain();
		});

		$("#user_mail").blur(function() {
			validMail();
		});
		$("#user_name").blur(function() {
			validName();
		});
		$("#user_login").blur(function() {
			validLogin();
		});

});
</script>
<div id="signupblock">
<br>
<h1>Регистрация клиента в системе WebConsult</h1>
<form action="/signup/" method="post">
	<input type="hidden" name="subm" value="1">
	<div id="user_login_block" class="form_elem">
		<div class="form_caption_block">логин:</div>
		<div class="form_input_block"><input class="forminput" type="text" id="user_login" name="login" value=""></div>
		<div class="form_hint_block">От 3 до 16 символов.<br> Только латинские буквы и цифры</div>
		<div class="form_error_block"></div>
	</div>
	<div class="clear"></div>

	<div id="user_name_block" class="form_elem">
		<div class="form_caption_block">имя:</div>
		<div class="form_input_block"><input class="forminput" type="text" id="user_name" name="name" value=""></div>
		<div class="form_hint_block">От 3 до 16 символов.<br> Только латинские буквы и цифры</div>
		<div class="form_error_block"></div>
	</div>
	<div class="clear"></div>
	<div id="user_mail_block" class="form_elem">
		<div class="form_caption_block">e-mail:</div>
		<div class="form_input_block"><input class="forminput" type="text" id="user_mail" name="email" value=""></div>
		<div class="form_hint_block">Укажите правильный адрес<br>электронной почты</div>    	
		<div class="form_error_block"></div>
	</div> 

	<div class="clear"></div>
		<div id="user_pass_block" class="form_elem">
		<div class="form_caption_block">пароль:</div>
		<div class="form_input_block"><input class="forminput" type="password" id="user_pass" name="password" value=""></div>
		<div class="form_hint_block">От 6 до 18 символов.</div>
		<div class="form_error_block"></div>
	</div>	
	<div class="clear"></div>
	<div id="user_pass_again_block" class="form_elem">
		<div class="form_caption_block">пароль:<br><span style="font-size:12px;">(ещё раз)</span></div>
		<div class="form_input_block"><input class="forminput" type="password" id="user_pass_again" name="password_confirm" value=""></div>
		<div class="form_hint_block">Введите, пожалуйста, пароль ещё раз,<br>Для исключения возможности опечатки</div>    	
		<div class="form_error_block"></div>
	</div> 
	<div class="clear"></div>


	<div id="user_site_block" class="form_elem">
		<div class="form_caption_block">сайт:</div>
		<div class="form_input_block"><input class="forminput" type="text" id="user_name" name="site" value=""></div>
		<div class="form_hint_block">Сайт клиента.</div>
		<div class="form_error_block"></div>
	</div> 
	<div class="clear"></div>

	<div id="user_tariff_block" class="form_elem">
		<div class="form_caption_block">тариф:</div>
		<div class="form_input_block"><input class="forminput" type="text" id="user_name" name="tariff" value=""></div>
		<div class="form_hint_block">Укажите тариф клиента</div>
		<div class="form_error_block"></div>
	</div> 
	<div class="clear"></div>

	<input type="hidden" name="partner_id" value="<?php if (isset($partner_id)) echo $partner_id?>">
	<in>
	<br>
	<div class="hr"></div>
	<br>
	<table>
		<tbody>
			<tr>
				<td>
					<input onclick="return signUpSubmit()" type="image" src="/images/register-submit.png">
				</td>
				<td width="20">&nbsp;</td>
<!--				<td>
					<input type="checkbox" checked="" value="y" id="user_subscribe" name="user_subscribe"> <label for="user_subscribe">получать на E-Mail новости и уведомления от WebConsult.</label>
				</td>-->
			</tr>
		</tbody>
	</table>
<div id="ajaxin">

</div>
</form>
</div>

<div id="aftersignupblock"  style="display: none;">
<br><br><br><br>
	<div id="afterregleft"><img src="/images/afterreg.png"></div>
	<div id="afterregright">
	<span class="big1">Поздравляем!</span><br><br>
	
	<span class="big3">Вы успешно зарегистрировали клиента в системе WebConsult. Информация о аккаунте отправлена на указанный почтовый ящик.</span>
	<br><br>
	<span class="big3"><strong>Нажмите "Далее" для продолжения.</strong></span>
	<br><br>
	<a href="/<?php echo URL::url_to_route('site-cabinet_clients')?>"><img src="/images/next.png" border="0"></a>
	</div>
</div>

<div class="clear"></div>

