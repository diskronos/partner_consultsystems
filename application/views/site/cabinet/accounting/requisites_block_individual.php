<?php

defined('SYSPATH') or die('No direct script access.');

?>
<div class="right-column">
	<!-- warning box -->
	<div class="warning-box">
			<div class="inner-warning">
				Не указаны реквизиты!
				<span>Укажите WMR кошелек для вывода средств</span>
			</div>
	</div>
	
	<?php if (isset($form_error)):?>
		<div class="warning-box">
			<div class="inner-warning">
				Ошибка при вводе реквизитов!
				<span>Все поля должны быть заполнены</span>
			</div>
		</div>
	<?php endif;?>
	<!-- end warning box -->

	<!-- partner info -->
	<div class="partner-info">

		<div class="info">
			<span>Вы зарегистрированы как: </span>физ. лицо
		</div>

		<div class="info">
			<span>На балансе: </span>3400 рублей
		</div>

	</div>
	<!-- end partner info -->

	<!-- purse form -->
	<div class="purse-form">
		WMR кошелек для вывода средств:

		<?php echo ext::form_begin(NULL,array('class' => 'req-form'));?>
			<?php echo $form->get_field('wmz_purse_number')->set_attributes(array('class' => 'text'))->render()?>
			<input type="submit" name="send_reqs"class="button" value="" />
			<div class="clear"></div>
		<?php echo ext::form_end()?>

		Указывается один раз, изменить нельзя
	</div>
</div>
<div class="clear"></div>
