<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
    document.write(d);
<?php if( ! is_null($open_id)):?>
        d.openTo(<?php echo $open_id?>, true);
<?php endif;?>
	d.openAll();
        // ]]>
                                    </script>
                                </div>