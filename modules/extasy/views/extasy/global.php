<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Kohana::$charset?>" />
        <title><?php echo Navigation::instance()->title()?></title>
        <?php echo HTML::style('extasy/css/style.css').PHP_EOL;?>
        <?php echo HTML::style('extasy/css/jquery-ui-1.8.23.custom.css').PHP_EOL;?>
        
		<?php echo HTML::script('extasy/js/jquery-1.8.0.min.js').PHP_EOL?>
        <?php echo HTML::script('extasy/js/jquery-ui-1.8.23.custom.min.js').PHP_EOL?>
        

        <?php echo HTML::script('extasy/js/jquery.maskedinput.js').PHP_EOL?>
        <?php echo HTML::script('extasy/js/extasy.field.array.js').PHP_EOL?>
        <?php echo HTML::script('extasy/js/jquery.datepick-ru.js').PHP_EOL?>
        
        <?php echo HTML::script('extasy/js/cms.js').PHP_EOL?>
        <?php echo HTML::script('extasy/js/extasy.field.array.js').PHP_EOL?>
    </head>
    <body>
        <table>
            <tr>
                <td class="LayoutTop">
                    <table>
                        <tr>
                            <td class="SiteLogo"><?php echo HTML::image('extasy/img/layout/logo.gif')?></a></td>
                            <td class="SiteSection"></td>
<?php echo Request::factory(url::url_to_route('admin-auth:block'))->execute();?>
                        </tr>
                    </table>

                </td>
            </tr>
            <tr>
                <td>
<?php echo Navigation::instance()->crumbs()?>
                    <table class="LayoutCenter">
                        <tr>
                            <td class="LayoutCenterL" valign="top">
<?php echo Menu::instance('menu')?>
                            </td>
                            <td class="LayoutCenterR" valign="top" rowspan="2">
<?php echo ext::header(Navigation::instance()->title())?>
<?php echo ext::spacer()?>
<?php echo $content; ?>
                            </td>
                        </tr>
                    </table>
                    <div class="Footer">
                    	<?php echo Application::NAME?> v<?php echo Application::VERSION?>
                    	<br />
                        <a href="http://smartdesign.by/">«Extasy» CMS Kohana Core</a> v<?php echo Extasy::VERSION;?> © <a href="http://smartdesign.by/">«SmartDesign»</a>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>
