<?php
/**
 * @version 0.1
 * @copyright 2012
 * Csorba Media
 * Send Reminder
 */

if($_POST['postid'] != null || $_POST['postid'] != '') :
	require_once('../../../../../wp-config.php');

	$postid = $_POST['postid'];
	$postid = wp_get_single_post($postid);
	$invoice_id = get_post_meta( $postid->ID , 'moneybird_invoice_id' , true );
	if(is_numeric($invoice_id)) :
	
		$domein = get_option('moneybird_domain');
		$email = get_option('moneybird_email');
		$pass = get_option('moneybird_pass');
		$key = get_option('moneybird_key');
		
		if($domein != '' && $email != '' && $pass != '' && $key != '') :
			$check = create_moneybird_settings($domain,$email,$pass,$key);
			if($check != 'error1' || $check != 'error2' || $check != 'error3') :
				try{
					require_once("api/Api.php");
					$mbapi = new MoneybirdApi($domein, $email, $pass);
					$invoice = $mbapi->getInvoice($invoice_id);
					$sendInfo = new MoneybirdInvoiceSendInformation();
					$mbapi->sendInvoiceReminder($invoice, $sendInfo);
					echo '<span style="color:green;">Er is een reminder gestuurd.</span>';	
				}catch(MoneybirdUnprocessableEntityException $e){
					$error = 'Er kon geen reminder worden verstuurd, niet alle velden zijn ingevoerd';
					return $error;
				}
			endif;
		endif;
	else:
		echo '<span style="color:red;">Er is nog geen factuur, deze kan nog niet worden verzonden.</span>';	
	endif;
else :
	echo '<span style="color:red;">Er is iets fout gegaan</span>';
endif;

?>