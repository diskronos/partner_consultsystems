<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::form_fields_begin() ?>
<?php foreach ($fieldgroups as $fieldgroup_name => $fieldgroup):?>
<tbody id="fieldgroup_<?php echo md5($fieldgroup_name)?>">
<?php echo ext::table_header_begin()?>
<th colspan="100"><?php echo $fieldgroup_name?></th>
<?php echo ext::table_header_end()?>
<?php foreach ($fieldgroup as $name => $field):?>
<?php echo ext::form_row(
	$field->render(),
	form::label($name, $field->get_label()),
	$form->get_error($name)
	? form::label($name, $form->get_error($name), array('class' => 'error'))
	: ''
) ?>
<?php endforeach;?>
<tr>
	<td class="HeaderSplitter" colspan="100"><div></div></td>
</tr>
</tbody>
<?php endforeach;?>
<?php echo ext::form_fields_end() ?>