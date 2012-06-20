<?php

function delete_moneybird_invoice($post_id){
		
	$domein = get_option('moneybird_domain');
	$email = get_option('moneybird_email');
	$pass = get_option('moneybird_pass');
	$key = get_option('moneybird_key');
	
	if($domein != '' && $email != '' && $pass != '' && $key != '') :
	
	$check = create_moneybird_settings($domain,$email,$pass,$key);
		
		if($check != 'error1' || $check != 'error2' || $check != 'error3') :
		
			$the_post = wp_get_single_post($post_id);			
			$meta = get_post_custom($post_id->ID);
			$invoice_id = $meta['moneybird_invoice_id'][0];
			
			if($invoice_id) :
				require_once("api/Api.php");
				try{
					$mbapi = new MoneybirdApi($domein, $email, $pass);
					$invoice = $mbapi->getInvoice($invoice_id);
					$mbapi->deleteInvoice($invoice);
					return $mbapi;
				}catch(MoneybirdUnprocessableEntityException $e){
					$error = 'Er kon geen factuur worden gevonden, de factuurnummer '.$invoice_id.' bestaat niet.';
					return $error;
				}catch(MoneybirdItemNotFoundException $e){
					$error = 'Er kon geen factuur worden gevonden de factuur is waarschijnlijk verwijderd.';
					return $error;
				}
			else :
				$error = 'Er kon geen factuur worden gevonden de factuur is waarschijnlijk verwijderd.';
				return $error;
			endif;
		endif;
	endif;
}

?>