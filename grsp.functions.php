<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//Add Admin Menu Item

function grsp_settings_menu() {
  add_menu_page( 'GetResponse Sending', 'GetResponse Sending Platform', 'manage_options', 'grsp-settings-menu', 'grsp_settings_page','dashicons-email-alt','15.3');
}
add_action( 'admin_menu', 'grsp_settings_menu' );


// ------------------------------------------------------------------
// Add all your sections, fields and settings during admin_init
// ------------------------------------------------------------------
//

function grsp_settings_page(){
    ?>
	    <div class="wrap">
	    <h2>GetResponse Sending Platform</h2>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("grsp_settings_section");
	            do_settings_sections("grsp-settings-options");
	            submit_button();
	        ?>
	    </form>
		</div>
	<?php
}

function grsp_settings_apikey_callback() {
 echo '<input name="grsp_settings_apikey" class="grsp_input" value="'.get_option( 'grsp_settings_apikey', '' ).'" placeholder="Enter API Key"> ';
}

function grsp_settings_api_init() {
 add_settings_section('grsp_settings_section', 'All Settings', NULL, 'grsp-settings-options');
 add_settings_field('grsp_settings_apikey', 'GetResponse API Key', 'grsp_settings_apikey_callback', 'grsp-settings-options', 'grsp_settings_section');
 register_setting( 'grsp_settings_section', 'grsp_settings_apikey' );
}
add_action("admin_init", "grsp_settings_api_init");

?>
