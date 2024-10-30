<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


	//Get the targeted string from settings page
	$targetedString1 = get_option('cl_aff_comp_target_urls');
	$targetedInArray = explode(',', $targetedString1);


	//Get the contents from settings page
	$compContents = get_option('cl_aff_comp_content');

	/*Add Main function*/
	function cl_aff_comp_filter_content($contents){

		global $targetedInArray, $markupClass, $compContents;

		if(is_single()){

			$FindaTag = preg_match_all('/href="(.*?)"/s', $contents, $Atags);
			$myLinks = implode($Atags[1]);


					function strposa($haystack, $needle, $offset=0) {

					    if(!is_array($needle)) $needle = array($needle);



					    foreach($needle as $query) {

					        if(strpos($haystack, $query, $offset) !== false) 
					        	add_action('wp_footer','cl_aff_comp_add_script');
								break;
					    }	


					    return false;
					}

					$string = $myLinks;
					$array  = $targetedInArray;


					if($array[0] == !null){
						strposa($string, $array);
					}




			return $contents;
			
		}//end is_single

		return $contents;

	}
	add_filter('the_content','cl_aff_comp_filter_content');



//Get the title of the post based on added trigger class
function cl_aff_comp_add_script(){ 

	global $compContents;
	if ( $compContents ) {
		
	$FinalContent = "<div class='comp-text'>";
	$FinalContent .= $compContents;
	$FinalContent .= "</div>";
	echo $FinalContent;

	?>

		<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery('.comp-text').insertBefore('.single-post article.post');	
		});
		</script>
	<?php }
}



