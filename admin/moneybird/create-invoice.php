<?php

function create_moneybird_invoice($post_id){
	
	$domein = get_option('moneybird_domain');
	$email = get_option('moneybird_email');
	$pass = get_option('moneybird_pass');
	$key = get_option('moneybird_key');
	
	if($domein != '' && $email != '' && $pass != '' && $key != '') :
	
		$check = create_moneybird_settings($domain,$email,$pass,$key);
		
		if($check != 'error1' || $check != 'error2' || $check != 'error3') : 
		
			// get post meta
			$meta = get_post_custom($post_id->ID);
			
			// invoice details
			
			$price = ''.$meta['price'][0].'';
			
			if($meta['tax'][0] != ''):
				$tax   = ''.$meta['tax'][0].'';
			else :
				$tax   = '0.19'; 
			endif;
			
			$reference    = 'Factuur '.$post_id->ID;
			
			if($meta['description'][0] != '') :
				$description  = ''.$meta['description'][0].'';
			else:
				$description = 'Factuur voor afnamen dienst en/of producten.';
			endif;
			
			// find the attached company grep the moneybird id
			$get_company  = wp_get_single_post($meta['company'][0]);
			$company_meta = get_post_custom($get_company->ID);
			$this_client = $company_meta['moneybird'][0];
			
			if($company_meta['email'][0] != '') :
				$this_email = $company_meta['email'][0];
			else :
				$this_email = $email;
			endif;
			
			// check if there is an client if not do nothing
			if($this_client != false || $this_client != '' || $this_client != null) :
				require_once("api/Api.php");
				try{	
					$mbapi = new MoneybirdApi($domein, $email, $pass);
					$contact = $mbapi->getContact($this_client);
					$invoice = new MoneybirdInvoice;
					$invoice->setContact($contact);
					$lines = array();
					$invoiceLine = new MoneybirdInvoiceLine($invoice);
					$invoiceLine->description = $description;
					$invoiceLine->amount = 1;
					$invoiceLine->price = $price;
					$invoiceLine->tax = $tax;
					$lines[] = $invoiceLine;
					$invoice->details = $lines;
					$invoice->po_number = $reference;
				
					$invoice = $mbapi->saveInvoice($invoice);
					return $invoice;
				}
				catch(MoneybirdAuthorizationRequiredException $e){
					$error = 'Er kon niet worden ingelogd';
					return $error;
				}
				catch(MoneybirdUnprocessableEntityException $e){
					$error = 'Er kon geen factuur worden aangemaakt, niet alle velden zijn ingevoerd';
					return $error;
				}
			else :
				return null;
			endif;
		endif;
	endif;
}
?>