<?php
/**
 * @version 0.1
 * @copyright 2012
 * Csorba Media
 * Create invoice
 */

if($_POST['postid'] != null || $_POST['postid'] != false || $_POST['postid'] != '') :

	require_once('../../../../../wp-config.php');

	$postid = $_POST['postid'];
	$request_post = wp_get_single_post($postid);	
	$bedrijfsnaam = get_post_meta( $postid , 'bedrijf' , true );
	$postname = 'Draft factuur '.$bedrijfsnaam .' '.date("d-m-Y H:i:s");
	$price = get_post_meta( $postid , 'fee' , true );
	
		//custom for MB evenementen
		if($price): $price = $price; else : $price = '00.00'; endif;
		
	if($request_post):
		$post = array(
				'post_author' => 1,
				'post_content' => "Deze factuur is aangemaakt om ".date("d-m-Y H:i:s")." voor <a target='_blank' href='post.php?post=".$postid."&action=edit&message=1'>".$bedrijfsnaam."</a>",
				'post_parent' => 0,
				'post_status' => 'draft',
				'post_title' => (string) $postname,
				'post_type' => 'mb_invoices' 
			);
		$insert = wp_insert_post( $post, true );
		update_post_meta($insert,'company',$postid);
		update_post_meta($insert,'price',$price);
		update_post_meta($insert,'moneybird_paid','Nee');
		update_post_meta($insert,'tax','0.19');
		echo '<span style="color:green;">Er is een nieuwe factuur aangemaakt. <a href="post.php?post='.$insert.'&action=edit">Klik hier</a></span>';
	else :
		echo '<span style="color:red;">Er is geen klant gevonden met id '.$postid.'</span>';	
	endif;
else :
	echo '<span style="color:red;">Er is iets fout gegaan</span>';
endif;

?>