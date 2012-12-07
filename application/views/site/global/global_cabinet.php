<?php defined('SYSPATH') or die('No direct script access.');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Цены и тарифы - WebConsult - онлайн консультант для сайта</title>
    <meta name="keywords" content="" />
    <meta name="description" content="Тарифные планы на использование системы онлайн консультирования WebConsult" />
	<?php echo HTML::style('css/main.css');?>
	<?php echo HTML::script('js/jquery-1.6.2.min.js')?>
	<?php echo HTML::script('js/tabs.js')?>
	<?php echo HTML::script('js/tabs-2.js')?>
	<?php echo HTML::script('js/jquery.uniform.js')?>
</head>

<body>

<!-- container -->
<div id="container">
	
	<!-- header -->
	<div id="header">
		
		<?php echo Request::factory(URL::url_to_route('site-registration:cabinet_top_block_logged'))->execute();?>
		<!-- bottom head -->
		<div class="bottom-head">
			
			<div class="logo-box">
				<a href="#">панель партнера</a>
			</div>
			
			<div class="partner-counter">
				<div class="counter-logo"><img src="/images/counter-logo.png"/></div>
				<div class="counter-line">
					<div class="progress-bar" style="width:50%"></div>
				</div>
				до следующего уровня 13400 рублей
			</div>
			<div class="clear"></div>
			
		</div>
		<!-- end bottom head -->
		
	</div>
	<!-- end header -->
	
	<div class="inner-partner-container">
	
		<?php echo Request::factory(URL::url_to_route('site-additional:cabinet_menu_top'))->execute();?>
		<!-- payment box -->
		<?php if (!$user->requisites):?>
			<div class="sk-payment-box">
				<div class="inner-payment">
					<img src="/images/payment-img.png"/>
					Для активации вашего аккаунта Вам необходимо указать свои
					<a href="/<?php echo URL::url_to_route('site-cabinet_accounting');?>">платежные данные</a>
				</div>
			</div>
		<?php endif;?>
		<!-- end payment box -->
		
		<?php echo $content;?>
		<!-- footer -->
		<div id="footer">
			<div class="bottom-logo">
				<a href="#">панель партнера</a>
			</div>
		</div>
		<!-- end footer -->
	
	</div>
	
</div>
<!-- end container -->
</noindex></body>
</html>
