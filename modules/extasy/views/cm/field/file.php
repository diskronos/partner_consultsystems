<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

$function_pref = preg_replace('#[^_a-z0-9]#i', '_', $name);

$onchange_function_name = $function_pref.'_on_file_change';
$ondelete_function_name = $function_pref.'_on_delete';

?>

<?php if ( ! $is_ajax):?>

<?php echo html::script('extasy/js/ajaxfileupload.js')?>
<div id="<?php echo $name?>_file_container">
<?php echo form::file($name.'_file', array(
	'id' => $name.'_file',
	'onchange' => $onchange_function_name.'();',
	'style' => 'width: 40%'
))?>
<?php if (count($field->get_allowed_extensions()) == 0):?>
Разрешены файлы любого типа
<?php else:?>
Разрешены файлы со следующими расширениями: <strong><?php echo implode(', ', $field->get_allowed_extensions())?></strong>
<?php endif;?>
</div>
<div style="margin-top: 4px;" id="<?php echo $name?>_additional_inputs">
<?php echo $field->render_additional_inputs(); ?>
</div>
<script type="text/javascript">
<!--
var <?php echo $onchange_function_name?> = function()
{
	$('#<?php echo $name?>_description_container').html('Loading...');

	$.ajaxFileUpload({
		url:'<?php echo url::query(array('file_upload' => $name))?>',
		secureuri:false,
		fileElementId:'<?php echo $name.'_file'?>',
		dataType: 'html',
		success: function (data, status)
		{
			$('#<?php echo $name?>_description_container').html(data);
			// reset file field
			$('#<?php echo $name?>_file_container').html(
				$('#<?php echo $name?>_file_container').html()
			);
		}
	});
}

var <?php echo $ondelete_function_name ?> = function()
{
	$('#<?php echo $name?>_description_container').html('<input type="hidden" name="<?php echo $name?>" value="" />');
}
//-->
</script>
<div id="<?php echo $name?>_description_container">

<?php endif; // if ( ! $is_ajax)?>

<?php echo form::hidden($name, $value->get_download_filename())?>
<?php if ( ! $value->is_empty()):?>
<br>
<table>
<tr>
<td>
<?php echo $field->render_icon()?>
</td>
<td>
<?php foreach ($field->get_description() as $descr_name => $descr_value):?>
<?php echo $descr_name?>: <?php echo $descr_value?><br>
<?php endforeach;?><br>
<a href="javascript:void(0);" onclick="javascript: <?php echo $ondelete_function_name?>();" class="ajax">Очистить</a>
</td>
</tr>
</table>
<?php endif;?>
<?php if ($upload_error):?>
<br>
<?php echo form::label($name.'_file', $upload_error, array('class' => 'error'))?>
<?php endif;?>

<?php if ( ! $is_ajax):?>
</div>
<hr>
<?php endif; // if ( ! $is_ajax)?>