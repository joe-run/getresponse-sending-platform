<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//Handles admin settings and api key
class grspSettings{

  //Execute WordPress hooks upon instantiation
  public function __construct(){
    add_action( 'admin_menu', array($this,'grsp_settings_menu') );
    add_action('admin_init', array($this,'grsp_settings_fields') );
  }

  public function grsp_settings_menu() {
  	add_options_page( 'GetResponse Sending Platform Settings', 'GetResponse Sending Platform Settings', 'manage_options', 'grsp-settings-menu', array($this, 'grsp_settings_options') );
  }

  public function grsp_settings_options() {
  	if ( !current_user_can( 'manage_options' ) )  {
  		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  	}
  }

  public function grsp_settings_fields(){
    echo '<div class="wrap">';
    echo '<h1>Get Response Admin Settings</h1>';
    add_settings_field( 'grsp_settings_apikey', 'GetResponse API Key', array($this,'grsp_settings_apikey_callback'), 'grsp-settings-menu' );
    echo '</div>';
  }

  public function grsp_settings_apikey_callback(){
    echo 'Enter the API Key for your GetResponse Account Here:';
    echo '<input name="grsp_settings_apikey" class="grsp_input" value="'.get_option( 'grsp_settings_apikey', '' ).'" placeholder="Enter API Key"> ';
  }

}

//Handles sending message to Get Response
class grspSending{

}
?>
