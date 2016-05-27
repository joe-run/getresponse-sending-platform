<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//Establish post variables
$grsp_name = $_POST["grsp_name"];
$grsp_subject = $_POST["grsp_subject"];
$grsp_campaign = $_POST["grsp_campaign"];
$grsp_page = $_POST["grsp_page"];
if(!empty($grsp_page)){
   $grsp_page = get_site_url().'/?p='.$grsp_page;
   $grsp_html = file_get_contents($grsp_page);
}

if(!empty($grsp_name) && !empty($grsp_subject) && !empty($grsp_campaign) && !empty($grsp_page)){
   $result = $grsp_client->add_draft(
		$grsp_api_key,
		array (
			'campaign'  => $grsp_campaign,
			'name'      => $grsp_name,
			'subject'	=> $grsp_subject,
			'contents'	=> array(
				'html' 		=> $grsp_html
			)
		)
	);
}
//print_r($result);
?>
