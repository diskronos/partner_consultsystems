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
		$("#user_mail").blur(function() {
			validMail();
		});
		$("#user_name").blur(function() {
			validName();
		});
});
</script>
<div id="signupblock">
<br>
<h1>Регистрация клиента в системе WebConsult</h1>
<form action="/signup/" method="post">
	<input type="hidden" name="subm" value="1">
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

