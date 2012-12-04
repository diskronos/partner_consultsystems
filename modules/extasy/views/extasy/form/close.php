<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
<?php echo ext::form_end()?>
<script type="text/javascript">

$('#<?php echo $id?>').validate(<?php echo json_encode($validate)?>);

</script>