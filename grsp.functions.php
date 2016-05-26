<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//Add Admin Menu Item
function grsp_settings_menu() {
  add_menu_page( 'GetResponse Sending', 'GetResponse Sending Platform', 'manage_options', 'grsp-settings-menu', 'grsp_settings_page','dashicons-email-alt','15.3');
}
add_action( 'admin_menu', 'grsp_settings_menu' );

//Enqueue Admin JS and CSS
function grsp_css_enqueue() {
    wp_enqueue_style( 'grspstyles',  plugins_url() . '/getresponse-sending-platform/grsp.css' );
}
add_action( 'admin_enqueue_scripts', 'grsp_css_enqueue' );

//Build Sending Page
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
    <hr></hr>
    <h2>Send an Email</h2>
    <span class="grsp-send-label">Message Name</span>
    <input class="grsp-send-input grsp-name">
    <span class="grsp-send-label">Message Subject</span>
    <input class="grsp-send-input grsp-subject">
    <span class="grsp-send-label">Message From</span>
    <select class="grsp-send-select grsp-from">
      <option value="sdf">Option 1</option>
      <option value="ssdfdf">Option 2</option>
    </select>
    <span class="grsp-send-label">Select Campaign</span>
    <select class="grsp-send-select grsp-campaign">
      <option value="sdf">Option 1</option>
      <option value="ssdfdf">Option 2</option>
    </select>
    <span class="grsp-send-label">Select Email Template</span>
    <select class="grsp-send-select grsp-page">
      <option value="sdf">Option 1</option>
      <option value="ssdfdf">Option 2</option>
    </select>
    <a class="grsp-button button-primary" href="#">Send Message</a>
    </div>
<?php
}

//load api key setting
function grsp_settings_apikey_callback() {
 echo '<input name="grsp_settings_apikey" class="grsp_input" value="'.get_option( 'grsp_settings_apikey', '' ).'" placeholder="Enter API Key"> ';
}

//api key setting callback
function grsp_settings_api_init() {
 add_settings_section('grsp_settings_section', 'Set API Key', NULL, 'grsp-settings-options');
 add_settings_field('grsp_settings_apikey', 'GetResponse API Key', 'grsp_settings_apikey_callback', 'grsp-settings-options', 'grsp_settings_section');
 register_setting( 'grsp_settings_section', 'grsp_settings_apikey' );
}
add_action("admin_init", "grsp_settings_api_init");

?>
