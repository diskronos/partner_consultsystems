<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo form::input($name, $value, array('size' => 10));?>
<script type="text/javascript">
$(':input[name=<?php echo $name?>]').mask("99.99.9999").width(60).datepicker({dateFormat : 'dd.mm.yy'});
</script>