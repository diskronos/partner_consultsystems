<?php defined('SYSPATH') or die('No direct script access.');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php if (isset($title)) echo $title;?></title>
	<meta name="keywords" content="<?php if (isset($keywords)) echo $keywords;?>" />
	<meta name="description" content="<?php if (isset($description)) echo $description;?>" />
	<?php echo HTML::style('css/main.css');?>
	<?php echo HTML::style('extasy/css/jquery-ui-1.8.23.custom.css');?>
	<?php echo HTML::script('js/jquery-1.6.2.min.js')?>
	<?php echo HTML::script('js/jquery-ui-1.8.24.custom.min.js')?>
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
				<div class="counter-logo"><img src="<?php echo $user->partner_group->logo?>"></div>
				<div class="counter-line">
					<div class="progress-bar" style="width:<?php echo $group->get_percentage_filled()?>"></div>
				</div>
				<?php if ($user->partner_group->id != 3):?>
					до следующего уровня <?php echo $group->get_remaining()?> рублей
				<?php endif;?>
			</div>
			<div class="clear"></div>
			
		</div>
		<!-- end bottom head -->
		
	</div>
	<!-- end header -->
	
	<div class="inner-partner-container">
		<?php echo Request::factory(URL::url_to_route('site-additional:cabinet_menu_top'))->execute();?>
		<!-- payment box -->
		<?php if ($user->status == 'legal' AND !$user->requisites):?>
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
