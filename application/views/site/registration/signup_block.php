<?php

defined('SYSPATH') or die('No direct script access.');

?>
<script type="text/javascript">
	var form_hints = {
		'reg-name': 'логин',
		'reg-email': 'e-mail',
		'reg-pass': 'пароль',
		'reg-pass-confirm': 'пароль (еще раз)',
		'reg-company-name': 'название компании',
		'reg-fullname': 'контактное лицо'
	};

	$(document).ready(function(){
		$('#reg-email, #reg-pass, #reg-pass-confirm, #reg-company-name, #reg-name, #reg-fullname')
			.bind('focus', function(){
				if ($(this).attr('placeholder') == form_hints[$(this).attr('id')])
				{
					$(this).attr('placeholder', '');
				}
			})
			.bind('blur', function(){
				if ($(this).attr('placeholder') == '')
					$(this).attr('placeholder', form_hints[$(this).attr('id')]);
			});
		$('#reg-email, #reg-pass, #reg-pass-confirm, #reg-company-name, #reg-name, #reg-fullname').attr('placeholder', '').blur();
		<?php if (isset($error_message)):?>
			alert('<?php echo $error_message?>');
		<?php endif;?>
	});
</script>

<div class="form-tab">
	<ul class="tab">
		<li class="current">Юр. лицо (ИП)</li>
		<li>Физ. лицо</li>
	</ul>
	<div class="clear"></div>
</div>
<!-- form box -->
	<div class="form-box visible">
		<?php echo ext::form_begin(NULL,array('class' => 'reg-form'));?>
			<div class="input-line">
				<?php echo $form->get_field('name')->set_attributes(array('class'=> 'text', 'id'=>'reg-name'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('email')->set_attributes(array('class'=> 'text', 'id'=>'reg-email'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('password')->set_attributes(array('class'=> 'text', 'id'=>'reg-pass'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('password_confirm')->set_attributes(array('class'=> 'text', 'id'=>'reg-pass-confirm'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('company_name')->set_attributes(array('class'=> 'text', 'id'=>'reg-company-name'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('fullname')->set_attributes(array('class'=> 'text', 'id'=>'reg-fullname'))->render();?>
			</div>
			<div class="input-line bottom">
				<input type="submit" class="button" name="signup" value="стать партнером"/>
			</div>
		<?php echo ext::form_end();?>
	</div>
<!-- end form box -->

<!-- form box -->
	<div class="form-box">
		<?php echo ext::form_begin(NULL,array('class' => 'reg-form'));?>
			<div class="input-line">
				<?php echo $form->get_field('name')->set_attributes(array('class'=> 'text', 'id'=>'reg-name'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('email')->set_attributes(array('class'=> 'text', 'id'=>'reg-email'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('password')->set_attributes(array('class'=> 'text', 'id'=>'reg-pass'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('password_confirm')->set_attributes(array('class'=> 'text', 'id'=>'reg-pass-confirm'))->render();?>
			</div>
			<div class="input-line">
				<?php echo $form->get_field('fullname')->set_attributes(array('class'=> 'text', 'id'=>'reg-fullname'))->render();?>
			</div>
			<div class="input-line bottom">
			<input type="submit" class="button" name="signup" value="стать партнером"/>
			</div>
		<?php echo ext::form_end();?>
	</div>
