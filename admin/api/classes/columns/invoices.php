<?php

add_filter('manage_edit-mb_invoices_columns' , 'mb_invoices_columns');
add_action('manage_mb_invoices_posts_custom_column' , 'mb_invoices_rows', 10, 2 );

function mb_invoices_columns($columns){
	return array(
        'cb' => '<input type="checkbox" />',
		'moneybird_factuur_nummer' => __('Factuurnummer'),
		'moneybird_factuur_online' => __('Bekijk factuur online'),
        'company' => __('Bedrijf'),
        'amount' => __('Bedrag (ex. btw)'),
		'description' => __('Omschrijving'),
		'moneybird_paid' => __('Betaald') 
    );
}
function mb_invoices_rows($column,$post_id) {
    switch ( $column ) {
	  case 'moneybird_factuur_nummer':
		$facnr 	 = get_post_meta( $post_id , 'moneybird_factuur_nummer' , true );
		if(!$facnr) : $facnr = 'Draft'; endif;
		echo '<a href="post.php?post='.$post_id.'&action=edit">'.$facnr.'</a>'; 
        break;
	  case 'moneybird_factuur_online':
		$moneybird_factuur_online 	 = get_post_meta( $post_id , 'moneybird_factuur_online' , true );
		if($moneybird_factuur_online) :
			echo '<a href="'.$moneybird_factuur_online.'" target="_blank">Bekijk factuur</a>';
		else :
			echo 'Nog geen factuur beschikbaar';
		endif;
        break;
      case 'company':
		$company_id = get_post_meta( $post_id , 'company' , true );
		$company   = wp_get_single_post($company_id);
		echo '<a href="post.php?post='.$company_id.'&action=edit" target="_blank">'.$company->post_title.'</a>'; 
        break;
      case 'amount':
		$amount 	 = get_post_meta( $post_id , 'price' , true );
        echo '&euro; '.$amount; 
        break;
	  case 'description':
		$description 	 = get_post_meta( $post_id , 'description' , true );
        echo $description; 
        break;
      case 'moneybird_paid':
		$paid = get_post_meta( $post_id , 'moneybird_paid' , true );
		if($paid == 'Nee' || $paid == '') : echo '<span style="color:red;">Niet betaald</span>'; else : echo '<span style="color:green;">Betaald</span>'; endif;
        break;
    }
}

?>