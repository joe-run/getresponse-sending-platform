<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


//Add Admin Menu Item
function grsp_settings_menu() {
   add_menu_page( 'GetResponse Sending', 'Sending Platform for Get Response', 'manage_options', 'grsp-settings-menu', 'grsp_settings_page','dashicons-email-alt','15.3');
}
add_action( 'admin_menu', 'grsp_settings_menu' );


//Enqueue Admin JS and CSS
function grsp_css_enqueue() {
   wp_enqueue_style( 'grspstyles',  plugins_url() . '/sending-platform-for-getresponse/grsp.css' );
   wp_enqueue_script( 'grspscripts',  plugins_url() . '/sending-platform-for-getresponse/grsp.js', 'jquery', '', true );
}
add_action( 'admin_enqueue_scripts', 'grsp_css_enqueue' );


//Establish Global Values
require_once('jsonRPCClient.php');
$grsp_api_url = 'http://api2.getresponse.com';
$grsp_client = new jsonRPCClient($grsp_api_url);
$grsp_api_key = get_option( 'grsp_settings_apikey', '' );
if(isset($_GET["grsptry"])){
   $grsp_try = $_GET["grsptry"];
   if ($grsp_try == 'pass'){
      $grsp_message = '<p style="color:green">Your message was successfully sent.<p>';
   }
   elseif ($grsp_try == 'fail'){
      $grsp_message = '<p style="color:red">An error has occured. Your message was not sent.<p>';
   }
   else{
      $grsp_message = '';
   }
};


//Build Sending Page
function grsp_settings_page(){
   global $grsp_client;
   global $grsp_api_key;
   global $grsp_message;
   ?>
   <div class="wrap">
   <h2>Sending Platform for Get Response</h2>
   <form method="post" action="options.php">
      <?php
      settings_fields("grsp_settings_section");
      do_settings_sections("grsp-settings-options");
      submit_button();
      ?>
   </form>
   <?php
   //Check For Key
   if (!empty($grsp_api_key)) {
      //Validate Key
      try{
         $grsp_validate_key = $grsp_client->ping($grsp_api_key);
      }
      catch(Exception $e){
         $grsp_validate_key = 'False';
      };
      if($grsp_validate_key['ping']=='pong'){
         //Get variables from WordPress and GetResponse. Filter out unpublished pages.
         $grsp_campaigns = $grsp_client->get_campaigns(
            $grsp_api_key,
               array (
               'name' => array ( 'CONTAINS' => '%' )
      		   )
      	);
         $grsp_campaign_ids = array_keys($grsp_campaigns);
         $grsp_all_page_ids = get_all_page_ids();
         $grsp_pub_page_ids = array();
         foreach($grsp_all_page_ids as $grsp_all_page_id){
            if (get_post_status($grsp_all_page_id) === 'publish'){
               $grsp_pub_page_ids[] = $grsp_all_page_id;
            }
         }
         $grsp_counter = 0;
         ?>
         <hr></hr>
         <h2>Send an Email</h2>
         <?php echo $grsp_message; ?>
         <form class="grsp-main-form" method="post" action="/wp-admin/admin.php?page=grsp-settings-menu">
         <input class="grsp-test" name="grsp_test" type="hidden" value="no" required="required">
         <span class="grsp-send-label">Message Name</span>
         <input name="grsp_name" class="grsp-send-input grsp-name" required="required">
         <span class="grsp-send-label">Message Subject</span>
         <input name="grsp_subject" class="grsp-send-input grsp-subject" required="required">
         <span class="grsp-send-label">Select Campaign</span>
         <select name="grsp_campaign" class="grsp-send-select grsp-campaign" required="required">
            <option value="" disabled selected>Select a campaign</option>
            <?php foreach($grsp_campaigns as $grsp_campaign){
               echo '<option value="'.$grsp_campaign_ids[$grsp_counter].'">'.$grsp_campaign[name].'</option>';
               $grsp_counter++;
            } ?>
         </select>
         <span class="grsp-send-label">Select Email Template</span>
         <select name="grsp_page" class="grsp-send-select grsp-page" required="required">
            <option value="" disabled selected>Select a page</option>
            <?php foreach($grsp_pub_page_ids as $grsp_pub_page_id){
               echo '<option value="'.$grsp_pub_page_id.'">'.get_the_title($grsp_pub_page_id).'</option>';
            } ?>
         </select>
         <span class="grsp-send-label">Test Email Address</span>
         <span class="grsp-send-label-disclaimer">Email address must be subscribed to campaign.</span>
         <input name="grsp_test_email" class="grsp-send-input grsp-name" required="required">
         <input type="submit" value="Send Message" class="grsp-button grsp-main-submit-button button-primary">
         <a href="#" class="button-primary grsp-button grsp-test-button">Send Test</a>
         </form>
         <?php
      }
      else{
         echo '<p style="color:red">The API key appears to be incorrect. Please try entering it again.</p>';
      }
   }
   echo '</div>';
}


//load api key setting
function grsp_settings_apikey_callback() {
   echo '<input name="grsp_settings_apikey" class="grsp_input" value="'.get_option( 'grsp_settings_apikey', '' ).'" placeholder="Enter API Key"> ';
}


//api key setting callback
function grsp_settings_api_init() {
   add_settings_section('grsp_settings_section', 'API Key Settings', NULL, 'grsp-settings-options');
   add_settings_field('grsp_settings_apikey', 'GetResponse API Key', 'grsp_settings_apikey_callback', 'grsp-settings-options', 'grsp_settings_section');
   register_setting( 'grsp_settings_section', 'grsp_settings_apikey' );
}
add_action("admin_init", "grsp_settings_api_init");


//send message
include_once('grsp.sendmessage.php');

?>
