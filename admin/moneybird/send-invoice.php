<?php

// check if there is an post
if($_POST['postid'] != null || $_POST['postid'] != '') :

	require_once('../../../../../wp-config.php');
	
	$domein = get_option('moneybird_domain');
	$email = get_option('moneybird_email');
	$pass = get_option('moneybird_pass');
	$key = get_option('moneybird_key');
	
	// check if every connector is there to connect to Moneybird
	if($domein != '' && $email != '' && $pass != '' && $key != '') :
	
		// check if there is an connection with Moneybird
		$check = create_moneybird_settings($domain,$email,$pass,$key);
		
			// if there is an Moneybird connection
			if($check != 'error1' || $check != 'error2' || $check != 'error3') :
				
				// get the invoice id			
				$invoice_id = get_post_meta( $_POST['postid'] , 'moneybird_invoice_id' , true );
			
				// check the invoice id
				if($invoice_id != false || $invoice_id != null || $invoice_id != '') :
			
					// require moneybird api for get connection to work again
					require_once("api/Api.php");
					try{
						$mbapi = new MoneybirdApi($domein, $email, $pass);
						$invoice = $mbapi->getInvoice($invoice_id);
						$sendInfo = new MoneybirdInvoiceSendInformation();
						$mbapi->sendInvoice($invoice, $sendInfo);
						echo 'Er is een factuur aangemaakt.';
					}catch(MoneybirdItemNotFoundException $e){
						$error = 'Er kon geen factuur worden verzonden, er is geen factuurnummer.';
						echo $error;
					}catch(MoneybirdInvalidIdException $e){
						$error = 'De factuurnummer is niet gevonden, bestaat het factuur nog wel?';
						echo $error;
					}
					
				else :
					echo 'Er is geen factuur nummer gevonden.';
					
				endif;
				
				else :
					echo 'Er is kon geen connectie worden gemaakt met Moneybird.';
					
			endif;
			
		else :
			echo 'Niet alle verplichte settings zijn ingevoerd, ga naar de configuratie pagina.';
			
	endif;
		
endif;

?>