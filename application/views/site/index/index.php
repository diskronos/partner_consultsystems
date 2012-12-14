<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php // $a = new CM_Field_HTML();
//$a->set_name('zsdfg');
//$a->set_raw_value($result);
//echo $a->render();
?>
<?php //echo $result; ?>
<div class="sk-top-content">

	<!-- programm box -->
	<div class="programm-box">
		<div class="title">Партнерская программа</div>
		WebConsult - онлайн консультант для сайта, который позволяет общаться с клиентами в реальном времени, при этом клиенту нужно всего-лишь нажать на кнопку вызова консультанта.
	</div>
	<!-- end programm box -->
	<?php echo Request::factory(URL::url_to_route('site-registration:right_login_block'))->execute();?>

	<div class="clear"></div>
</div>
<!-- end sk top content -->


<!-- sk content -->
<div class="sk-content">

	<!-- sk programm tab -->
	<div class="sk-programm-tab">
		<ul class="tabs">
			<li class="current"><span>Для кого</span></li>
			<li><span>Как привлекать?</span></li>
			<li><span>Выплаты</span></li>
			<li><span>С чего начать?</span></li>
			<li><span>Вопрос - ответ</span></li>
		</ul>
		<div class="clear"></div>
	</div>
	<!-- end sk programm tab -->

	<!-- left column -->
	<div class="left-column visible">

			<!-- for box -->
			<div class="for-box">
				<div class="image-box"><img src="images/for-image-5.png" alt="" /></div>
				<div class="text-box">
					<div class="title">Дизайн студиям</div>
					WebConsult - онлайн консультант для сайта, который позволяет общаться с клиентами в реальном времени, при этом клиенту нужно всего-лишь нажать на кнопку вызова консультанта. 
				</div>
				<div class="clear"></div>
			</div>
			<!-- end for box -->

			<!-- for box -->
			<div class="for-box">
				<div class="image-box"><img src="images/for-image-4.png" alt="" /></div>
				<div class="text-box">
					<div class="title">Дизайн студиям</div>
					WebConsult - онлайн консультант для сайта, который позволяет общаться с клиентами в реальном времени, при этом клиенту нужно всего-лишь нажать на кнопку вызова консультанта. 
				</div>
				<div class="clear"></div>
			</div>
			<!-- end for box -->

			<!-- for box -->
			<div class="for-box">
				<div class="image-box"><img src="images/for-image-3.png" alt="" /></div>
				<div class="text-box">
					<div class="title">Дизайн студиям</div>
					WebConsult - онлайн консультант для сайта, который позволяет общаться с клиентами в реальном времени, при этом клиенту нужно всего-лишь нажать на кнопку вызова консультанта. 
				</div>
				<div class="clear"></div>
			</div>
			<!-- end for box -->

			<!-- for box -->
			<div class="for-box">
				<div class="image-box"><img src="images/for-image-2.png" alt="" /></div>
				<div class="text-box">
					<div class="title">Дизайн студиям</div>
					WebConsult - онлайн консультант для сайта, который позволяет общаться с клиентами в реальном времени, при этом клиенту нужно всего-лишь нажать на кнопку вызова консультанта. 
				</div>
				<div class="clear"></div>
			</div>
			<!-- end for box -->

			<!-- for box -->
			<div class="for-box">
				<div class="image-box"><img src="images/for-image.png" alt="" /></div>
				<div class="text-box">
					<div class="title">Дизайн студиям</div>
					WebConsult - онлайн консультант для сайта, который позволяет общаться с клиентами в реальном времени, при этом клиенту нужно всего-лишь нажать на кнопку вызова консультанта. 
				</div>
				<div class="clear"></div>
			</div>
			<!-- end for box -->

	</div>
	<!-- end left column -->

	<!-- left column -->
	<div class="left-column">

		<div class="attraction-box">
			<div class="title">1. Реферальная ссылка</div>
			<div class="text-box">
				После регистрации вы получаете персональную ссылку для привлечения клиентов. Если клиент зашел по этой ссылке и зарегистрировался, то клиент закрепляется за нами.
				<p>Ссылка имеет вид:
				<span>http://consultsystems.ru/p/xxxxxxx/</span></p>
			</div>
		</div>

		<div class="attraction-box bottom">
			<div class="title">2. Прямая регистрация аккаунта в личном кабинете партнера</div>
			<div class="text-box">
				Вы можете зарегистрировать новый аккаунт из личного кабинета, который будет привязан к Вам, а значит вы будете получать процент со всех оплат произведенных ваших клиентом.
			</div>
		</div>

	</div>
	<!-- end left column -->

	<!-- left column -->
	<div class="left-column top">

		<!-- pay box -->
		<div class="pay-box" title="Junior-partner">
			<div class="left-box">
				<div class="inner-left">начальный уровень партнера</div>
			</div>
			<div class="right-box">
				40%
				<span>от платежей</span>
			</div>
			<div class="clear"></div>
		</div>
		<!-- end pay box -->

		<!-- pay box -->
		<div class="pay-box premium" title="Premium-partner">
			<div class="left-box">
				<div class="inner-left">
					Привлеченных платежей
					<br/>более <span>25000 рублей</span>
				</div>
			</div>
			<div class="right-box">
				50%
				<span>от платежей</span>
			</div>
			<div class="clear"></div>
		</div>
		<!-- end pay box -->

		<!-- pay box -->
		<div class="pay-box gold" title="Gold-partner">
			<div class="left-box">
				<div class="inner-left">
					Привлеченных платежей
					<br/>более <span>50000 рублей</span>
				</div>
			</div>
			<div class="right-box">
				60%
				<span>от платежей</span>
			</div>
			<div class="clear"></div>
		</div>
		<!-- end pay box -->
		<div class="bottom-text">
		Выплаты осуществляются через WebMoney (для физ.лиц) и безналичным расчетом для юридических лиц и ИП.
		</div>

	</div>
	<!-- end left column -->

	<!-- left column -->
	<div class="left-column top">

		<!-- begin box -->
		<div class="begin-box active">
			<div class="image-box"><img src="images/begin-bg.png" alt="" /></div>
			<div class="text-box">
				<div class="title">Зарегистрируйтесь</div>
				Посетитель, находясь на вашем сайте, всегда видит небольшую кнопку, предлагающую вызвать консультанта на разговор.
			</div>
			<div class="clear"></div>
			<div class="begin-arrow"><img src="images/begin-arrow.png" alt="" /></div>
		</div>
		<!-- end begin box -->

		<!-- begin box -->
		<div class="begin-box">
			<div class="image-box"><img src="images/begin-bg-2.png" alt="" /></div>
			<div class="text-box">
				<div class="title">Получите код реферальной ссылки</div>
				Посетитель, находясь на вашем сайте, всегда видит небольшую кнопку, предлагающую вызвать консультанта на разговор.
			</div>
			<div class="clear"></div>
			<div class="begin-arrow"><img src="images/begin-arrow.png" alt="" /></div>
		</div>
		<!-- end begin box -->

		<!-- begin box -->
		<div class="begin-box">
			<div class="image-box"><img src="images/begin-bg-3.png" alt="" /></div>
			<div class="text-box">
				<div class="title">Заполните платежную информацию</div>
				Посетитель, находясь на вашем сайте, всегда видит небольшую кнопку, предлагающую вызвать консультанта на разговор.
			</div>
			<div class="clear"></div>
			<div class="begin-arrow"><img src="images/begin-arrow.png" alt="" /></div>
		</div>
		<!-- end begin box -->

		<!-- begin box -->
		<div class="begin-box client">
			<div class="image-box"><img src="images/begin-bg-4.png" alt="" /></div>
			<div class="text-box">
				<div class="title">Начинайте привлекать клиентов</div>
				Посетитель, находясь на вашем сайте, всегда видит небольшую кнопку, предлагающую вызвать консультанта на разговор.
			</div>
			<div class="clear"></div>
			<div class="begin-arrow"><img src="images/begin-arrow.png" alt="" /></div>
		</div>
		<!-- end begin box -->

	</div>
	<!-- end left column -->

	<!-- left column -->
	<div class="left-column top">

		<!-- question box -->
		<div class="question-box">
			<div class="question">
				<img src="images/question-arrow.png" alt="" />
				Когда производяться выплаты?
			</div>
			<div class="answer">
				WebConsult - онлайн консультант для сайта, который позволяет общаться с клиентами в реальном времени, при этом клиенту нужно всего-лишь нажать на кнопку вызова консультанта. 
			</div>
		</div>
		<!-- end question box -->

		<!-- question box -->
		<div class="question-box">
			<div class="question">
				<img src="images/question-arrow.png" alt="" />
				Когда производяться выплаты?
			</div>
			<div class="answer">
				WebConsult - онлайн консультант для сайта, который позволяет общаться с клиентами в реальном времени, при этом клиенту нужно всего-лишь нажать на кнопку вызова консультанта. 
			</div>
		</div>
		<!-- end question box -->

	</div>
	<!-- end left column -->

	<!-- right column -->
	<div class="right-column">
		<?php echo Request::factory(URL::url_to_route('site-registration:signup_block'))->execute();?>
	</div>
	<!-- end right column -->

	<div class="clear"></div>
</div>
<!-- end sk content -->
			

