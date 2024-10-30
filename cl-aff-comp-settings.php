<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Settings Page: CL Affiliate Compliance
class Cl_Aff_Comp_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'cl_aff_comp_create_settings' ) );
		add_action( 'admin_init', array( $this, 'cl_aff_comp_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'cl_aff_comp_setup_fields' ) );
	}

	public function cl_aff_comp_create_settings() {
		$page_title = __('CL Affiliate Compliance Settings','cl-aff-comp');
		$menu_title = __('CL Affiliate Compliance','cl-aff-comp');
		$capability = 'manage_options';
		$slug = 'cl-aff-comp';
		$callback = array($this, 'cl_aff_comp_settings_content');
		add_options_page($page_title, $menu_title, $capability, $slug, $callback);
	}

	public function cl_aff_comp_settings_content() { ?>
		<div class="wrap">
			<h1><?php _e('CL Affiliate Compliance Settings','cl-aff-comp') ?></h1>
	
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'cl_aff_comp' );
					do_settings_sections( 'cl_aff_comp' );
					submit_button();
				?>
			</form>
		</div> <?php
	}

	public function cl_aff_comp_setup_sections() {
		add_settings_section( 'cl_aff_comp_section', __('Use the following field to get the best output','cl-aff-comp'), array(), 'cl_aff_comp' );
	}

	public function cl_aff_comp_setup_fields() {
		$fields = array(
			array(
				'label' => __('Targeted Words To Be Filtered','cl-aff-comp'),
				'id' => 'cl_aff_comp_target_urls',
				'type' => 'text',
				'section' => 'cl_aff_comp_section',
				'desc' => __('Put the words, seperated by comma. If any of these word is available in urls used in your posts the, compliance message will be shown before the post automatically. EX: amazon,ebay','cl-aff-comp'),
				'placeholder' => __('amazon,ebay','cl-aff-comp'),
			),
			array(
				'label' => __('Compliance Content Before Post','cl-aff-comp'),
				'id' => 'cl_aff_comp_content',
				'type' => 'wysiwyg',
				'section' => 'cl_aff_comp_section',
			),
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'cl_aff_comp_field_callback' ), 'cl_aff_comp', $field['section'], $field );
			register_setting( 'cl_aff_comp', $field['id'] );
		}
	}

	public function cl_aff_comp_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
				case 'wysiwyg':
					wp_editor($value, $field['id']);
					break;
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
}
new Cl_Aff_Comp_Settings_Page();


// Settings Link in plugin list table: CL Affiliate Compliance
add_filter( 'plugin_action_links_cl-affiliate-compliance/cl-affiliate-compliance.php', 'cl_aff_settings_link' );
function cl_aff_settings_link( $links ) {
	// Build and escape the URL.
	$url = esc_url( add_query_arg(
		'page',
		'cl-aff-comp',
		get_admin_url() . 'admin.php'
	) );
	// Create the link.
	$settings_link = "<a href='$url'>" . __( 'Settings','cl-aff-comp' ) . '</a>';
	// Adds the link to the end of the array.
	array_push(
		$links,
		$settings_link
	);
	return $links;
}//end cl_aff_settings_link()