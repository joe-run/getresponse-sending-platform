<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//Establish post variables
$grsp_name = $_POST["grsp_name"];
$grsp_subject = $_POST["grsp_subject"];
//$grsp_campaign = $_POST["grsp_campaign"]; fix before launch
$grsp_campaign = 'VBxsm';
$grsp_page = $_POST["grsp_page"];
if(!empty($grsp_page)){
   $grsp_page = get_site_url().'/?p='.$grsp_page;
   $grsp_html = file_get_contents($grsp_page);
}

if(!empty($grsp_name) && !empty($grsp_subject) && !empty($grsp_campaign) && !empty($grsp_page)){
   //Create a draft
   /*$grsp_result = $grsp_client->add_draft(
		$grsp_api_key,
		array (
			'campaign'  => $grsp_campaign,
			'name'      => $grsp_name,
			'subject'	=> $grsp_subject,
			'contents'	=> array(
				'html' 		=> $grsp_html
			)
		)
	);*/

   //Get contacts from selected campaign
   $grsp_contacts_result = $grsp_client->get_contacts(
		$grsp_api_key,
		array (
			'campaigns'	=> array($grsp_campaign)
		)
	);
   $grsp_sendtocontacts = array_keys($grsp_contacts_result);

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
   echo '<script>window.location.replace("/wp-admin/admin.php?page=grsp-settings-menu");</script>';
}
?>
