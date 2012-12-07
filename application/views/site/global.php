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

	<!--uniform-->
	<script type="text/javascript" charset="utf-8">
		$(function(){
			$("input#uniform, select#uniform").uniform();
		});
	</script>
	<!--end uniform-->
</script>
</head>

<body>
	
		<div id="logobar">
			<div id="logo">
				<a href="/"><img src="/images/logo.png" border="0" alt="WebConsult - онлайн консультант для сайта" /></a>
				<div class="logodesc">онлайн консультант для сайта</div>
			</div>
			<div id="logoright" align="right">
				<noindex>
					<?php echo Request::factory(URL::url_to_route('site-registration:top_login_block'))->execute();?>
				</noindex>
				<?php echo Request::factory(URL::url_to_route('site-additional:site_menu_top'))->execute();?>
			</div>
		</div>
		<div class="clear"></div>
		<!-- sk container -->
		<div id="container">
			<?php echo $content;?>
		</div>
		<!-- end sk container -->
</body>
</html>
