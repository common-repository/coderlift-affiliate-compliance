<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//Admin footer script
function cl_aff_comp_add_admin_script(){ 

	global $compContents;

	?>

<script type="text/javascript">
	(function( $ ) {

	//add class name to the settings field
    $("#cl_aff_comp_target_urls").addClass("regular-text");
    
})( jQuery );
</script>
	<?php }


add_action( 'admin_footer', 'cl_aff_comp_add_admin_script', 0 );