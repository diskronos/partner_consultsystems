<?php

defined('SYSPATH') or die('No direct script access.');

?>
<div class="right-column legal">
	<!-- warning box -->
	<?php if (!$user->requisites):?>
	<div class="warning-box">
		<div class="inner-warning">
			Ваш аккаунт не активирован!
			<span>Укажите реквизиты как юридического лица</span>
		</div>
	</div>
	<?php elseif (!$user->requisites->confirmed):?>
	<div class="warning-box">
		<div class="inner-warning">
			Ваш аккаунт не активирован!
			<span>Реквизиты на модерации</span>
		</div>
	</div>
	<?php endif;?>
	<!-- end warning box -->

	<?php if (isset($form_error)):?>
	<div class="warning-box">
		<div class="inner-warning">
			Ошибка при вводе реквизитов!
			<span>Все поля должны быть заполнены</span>
		</div>
	</div>
	<?php endif;?>
	<!-- partner info -->
	<div class="partner-info">
		<div class="info">
			<span>Вы зарегистрированы как: </span>юр. лицо
		</div>
	</div>
	<!-- end partner info -->

	<!-- legal form -->
	<?php if (!$user->requisites):?>
	<div class="legal-form">
		<?php echo ext::form_begin(NULL,array('class' => 'req-form'));?>
<!--			<div class="input-line">
				<label>Название:</label>
				<input type="text" class="text"/>
				<div class="clear"></div>
			</div>-->
			<?php foreach ($requisites_shortnames as $req_eng => $req_rus):?>
				<div class="input-line">
					<label><?php echo $req_rus?></label>
					<?php echo $form->get_field($req_eng)->set_attributes(array('id' => $req_eng, 'class' => 'text'))->render();?>
					<div class="clear"></div>
				</div>
			<?php endforeach;?>

			<div class="input-line bottom">
				<input type="submit" name="send_reqs" class="button" value="отправить заявку" />
			</div>
		<?php echo ext::form_end();?>
	</div>
	<?php endif;?>
	<!-- end legal form -->

	<!-- partner info -->
<!--	<div class="partner-info">

		<div class="info">
			<span>На балансе: </span>3400 рублей
		</div>

		<div class="info">
			<span>Доступно для снятия: </span>2400 рублей
		</div>

		<div class="info">
			<span>Ближайшая дата выплат: </span>10.11.2012
		</div>
	</div>-->
	<!-- end partner info -->

<!--	<div class="purse-button">
		<a href="#">
			вывести
			<span>на расчетный счет</span>
		</a>
	</div>-->

</div>
<div class="clear"></div>

