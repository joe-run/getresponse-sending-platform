<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

try{
   //Establish post variables
   if(isset($_POST['grsp_name'])){
      $grsp_name = sanitize_text_field( $_POST['grsp_name'] );
   }
   else{
      $grsp_name = '';
   }
   if(isset($_POST['grsp_subject'])){
      $grsp_subject = sanitize_text_field( $_POST['grsp_subject'] );
   }
   else{
      $grsp_subject = '';
   }
   if(isset($_POST['grsp_campaign'])){
      $grsp_campaign = sanitize_text_field( $_POST['grsp_campaign'] );
   }
   else{
      $grsp_campaign = '';
   }
   if(isset($_POST['grsp_page'])){
      $grsp_page = sanitize_text_field( $_POST['grsp_page'] );
   }
   else{
      $grsp_page = '';
   }
   if(isset($_POST['grsp_test'])){
      $grsp_test = sanitize_text_field( $_POST['grsp_test'] );
   }
   else{
      $grsp_test = '';
   }
   if(isset($_POST['grsp_test_email'])){
      $grsp_test_email = sanitize_email($_POST['grsp_test_email']);
   }
   else{
      $grsp_test_email = '';
   }

   if(!empty($grsp_page)){
      $grsp_page = get_site_url().'/?p='.$grsp_page;
      $grsp_html = file_get_contents($grsp_page);
   }

   if(!empty($grsp_name) && !empty($grsp_subject) && !empty($grsp_campaign) && !empty($grsp_page)){

      //Get contacts from selected campaign or test email
      if($grsp_test === 'yes'){
         $grsp_contacts_result = $grsp_client->get_contacts(
      		$grsp_api_key,
      		array (
               'email' => array ( 'CONTAINS' => $grsp_test_email )
      		)
      	);
         $grsp_sendtocontacts = array_keys($grsp_contacts_result);
         $grsp_name = "Test: ".$grsp_name;
         $grsp_subject = "Test: ".$grsp_subject;
      }
      else{
         $grsp_contacts_result = $grsp_client->get_contacts(
      		$grsp_api_key,
      		array (
      			'campaigns'	=> array($grsp_campaign)
      		)
      	);
         $grsp_sendtocontacts = array_keys($grsp_contacts_result);
      }

      //Send a message
      $grsp_result = $grsp_client->send_newsletter(
   		$grsp_api_key,
   		array (
   			'campaign'  => $grsp_campaign,
            'subject'	=> $grsp_subject,
   			'name'      => $grsp_name,
   			'contents'	=> array(
   				'html' 		=> $grsp_html
   			),
            'contacts' => $grsp_sendtocontacts
   		)
   	);


      //redirect to same page to prevent form resubmission
      echo '<script>window.location.replace("/wp-admin/admin.php?page=grsp-settings-menu&grsptry=pass");</script>';
   }
}
catch (Exception $e){
   echo '<script>window.location.replace("/wp-admin/admin.php?page=grsp-settings-menu&grsptry=fail");</script>';
}
?>
