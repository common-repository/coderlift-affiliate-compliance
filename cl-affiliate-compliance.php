<?php
/*
Plugin Name: Coderlift Affiliate Compliance
Plugin URI: https://coderlift.com/coderlift-affiliate-compliance/
Description: This plugin will detect if there is any affiliate link and generate compliance content
Version: 1.0.0
Author: CoderLift
Author URI: https://www.coderlift.com
License: GPLv2 or later
Text Domain: cl-aff-comp
Domain Path: /languages/
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if (!defined('CL_AFF_COMP_THEME_DIR'))
    define('CL_AFF_COMP_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('CL_AFF_COMP_PlUGIN_FILE'))
    define('CL_AFF_COMP_PlUGIN_FILE', plugin_basename(__FILE__), '/');

if (!defined('CL_AFF_COMP_PLUGIN_NAME'))
    define('CL_AFF_COMP_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('CL_AFF_COMP_PLUGIN_DIR'))
    define('CL_AFF_COMP_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . CL_AFF_COMP_PLUGIN_NAME);

if (!defined('CL_AFF_COMP_PLUGIN_URL'))
    define('CL_AFF_COMP_PLUGIN_URL', WP_PLUGIN_URL . '/' . CL_AFF_COMP_PLUGIN_NAME);


/*Text domain loading*/
function cl_aff_comp_load_textdomain() {
    load_plugin_textdomain( 'cl-aff-comp', false, CL_AFF_COMP_PLUGIN_DIR . "/languages" );

}
add_action( "plugins_loaded", 'cl_aff_comp_load_textdomain' );


//enqueue assets
function cl_aff_comp_assets(){

    wp_enqueue_style('main-css', CL_AFF_COMP_PLUGIN_URL.'/assets/style.css');
    wp_enqueue_script('main-js', CL_AFF_COMP_PLUGIN_URL.'/assets/main-script.js',array('jquery'),false, true);

}
add_action('wp_enqueue_scripts','cl_aff_comp_assets');




/*Add Main Function*/
require_once(CL_AFF_COMP_PLUGIN_DIR.'/cl-aff-comp-main-function.php');

/*Add Settings Page*/
require_once(CL_AFF_COMP_PLUGIN_DIR.'/cl-aff-comp-settings.php');

/*Add Admin Script*/
require_once(CL_AFF_COMP_PLUGIN_DIR.'/cl-aff-comp-admin-script.php');


/*Delete all the options from Database while deactivate the plugin*/
function cl_aff_comp_deactivation_hook(){

	delete_option( 'cl_aff_comp_target_word1' );
	delete_option( 'cl_aff_comp_class' );
	delete_option( 'cl_aff_comp_content' );
}
register_deactivation_hook(__FILE__,"cl_aff_comp_deactivation_hook");