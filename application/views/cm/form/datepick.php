<?php

defined('SYSPATH') or die('No direct script access.');

?>
<script type="text/javascript">
	$(document).ready(function(){
		$( "#from" ).datepicker({
			dateFormat : 'dd.mm.yy',
			maxDate : "0",
			onClose: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			dateFormat : 'dd.mm.yy',
			maxDate : "0",
			minDate : "-7d",
			onClose: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	//	$("#from").datepicker("setDate", "-7d");
	//	$( "#to" ).datepicker("setDate", "0");
	});
</script>