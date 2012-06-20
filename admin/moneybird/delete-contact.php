<?php

function delete_moneybird_contact($post_id){
		
	$domein = get_option('moneybird_domain');
	$email = get_option('moneybird_email');
	$pass = get_option('moneybird_pass');
	$key = get_option('moneybird_key');
	
	if($domein != '' && $email != '' && $pass != '' && $key != '') :
	
	$check = create_moneybird_settings($domain,$email,$pass,$key);
		
		if($check != 'error1' || $check != 'error2' || $check != 'error3') :
		
			$the_post = wp_get_single_post($post_id);			
			$meta = get_post_custom($post_id->ID);
			$contact_id = $meta['moneybird'][0];
			
			if($contact_id) :
				require_once("api/Api.php");
				try{
					$mbapi = new MoneybirdApi($domein, $email, $pass);
					$contact = $mbapi->getContact($contact_id);
					$mbapi->deleteContact($contact);
					return $mbapi;
				}catch(MoneybirdUnprocessableEntityException $e){
					$error = 'Er kon geen contact worden gevonden, de contact '.$invoice_id.' bestaat niet.';
					return $error;
				}catch(MoneybirdItemNotFoundException $e){
					$error = 'Er kon geen contact worden gevonden de contact is waarschijnlijk verwijderd.';
					return $error;
				}
			else :
				$error = 'Er kon geen contact worden gevonden de contact is waarschijnlijk verwijderd.';
				return $error;
			endif;
		endif;
	endif;
}

?>