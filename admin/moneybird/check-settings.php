<?php

function create_moneybird_settings($domein,$email,$pass,$key){
	
	if($domein != '' && $email != '' && $pass != '') :
	
		require_once("api/Api.php");
		
		if($key):
			try
			{
				$mbapi = new MoneybirdApi($domein, $email, $pass);
				$contact = $mbapi->getContact(get_option('moneybird_key'));
				return $contact->id;
			}
			catch (MoneybirdAuthorizationRequiredException $e)
			{
				return 'error1';
			}
			catch (MoneybirdItemNotFoundException $e)
			{
				return 'error2';
			}
		else:
			try{
				$mbapi = new MoneybirdApi($domein, $email, $pass);
				$contact = new MoneybirdContact;
				$contact->company_name = 'Bedrijfsnaam';
				$contact->firstname = 'Voornaam';
				$contact->lastname = 'Achternaam';
				$contact->address1 = 'Met dank aan Csorba Media';
				$contact->zipcode = '1100aa';
				$contact->city = 'Amsterdam';
				$contact->country = 'Nederland';
				$contact->email = 'moneybird@csorbamedia.com';
				$contact->phone = '0612121212';
				$contact->website = 'www.csorbamedia.com';
				$contact = $mbapi->saveContact($contact);
				return $contact->id;
			}
			catch (MoneybirdAuthorizationRequiredException $e)
			{
				return 'error1';
			}
			catch (MoneybirdItemNotFoundException $e)
			{
				return 'error3';
			}
		endif;
	
	else :
	
		return 'error3';
		
	endif;
}
?>