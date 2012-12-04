<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

?>
                                <div class="SiteTreeContainer">
<?php echo HTML::script('extasy/js/dtree.js')?>
                                    <script type="text/javascript">
                                        // <![CDATA[
                                        d = new dTree('d');
                                        d.icon =
<?php
$folder = URL::base().'extasy/img/submenu/';
echo json_encode(
    array(
        'root'          => $folder.'folder.gif',
        'folder'        => $folder.'folder.gif',
        'folderOpen'    => $folder.'folderopen.gif',
        'node'          => $folder.'page.gif',
        'empty'         => $folder.'empty.gif',
        'line'          => $folder.'line.gif',
        'join'          => $folder.'join.gif',
        'joinBottom'	=> $folder.'joinbottom.gif',
        'plus'          => $folder.'plus.gif',
        'plusBottom'	=> $folder.'plusbottom.gif',
        'minus'         => $folder.'minus.gif',
        'minusBottom'	=> $folder.'minusbottom.gif',
        'nlPlus'		=> $folder.'nolines_plus.gif',
        'nlMinus'		=> $folder.'nolines_minus.gif'
    )
);
?>;
<?php echo ext::menu_row(0, $root)?>
