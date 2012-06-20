<?php

add_filter('manage_edit-mb_companies_columns' , 'mb_companies_columns');
add_action('manage_mb_companies_posts_custom_column' , 'mb_companies_rows', 10, 2 );

function mb_companies_columns($columns){
	return array(
        'cb' => '<input type="checkbox" />',
		'moneybird' => __('Moneybird klantnr.'),
		'voornaam' => __('Voornaam'),
        'achternaam' => __('Achternaam'),
		'bedrijf' => __('Bedrijfsnaam'),
        'email' => __('Email'),
		'telefoon' => __('Telefoon'),
		'website' => __('Website') 
    );
}
function mb_companies_rows($column,$post_id) {
    switch ( $column ) {
	  case 'moneybird':
		$moneybird 	 = get_post_meta( $post_id , 'moneybird' , true );
		if(!$moneybird) : $moneybird = 'Geen klantid'; endif;
		echo '<a href="post.php?post='.$post_id.'&action=edit">'.$moneybird.'</a>'; 
        break;
	  case 'voornaam':
		$voornaam = get_post_meta( $post_id , 'voornaam' , true );
		if(!$voornaam) : $voornaam = '-'; endif;
		echo $voornaam;
        break;
      case 'achternaam':
		$achternaam = get_post_meta( $post_id , 'achternaam' , true );
		if(!$achternaam) : $achternaam = '-'; endif;
		echo $achternaam;
        break;
	  case 'bedrijf':
		$bedrijfsnaam = get_post_meta( $post_id , 'bedrijf' , true );
		if(!$bedrijfsnaam) : $bedrijfsnaam = '-'; endif;
		echo $bedrijfsnaam;
        break;
      case 'email':
		$email = get_post_meta( $post_id , 'email' , true );
		if(!$email) : $email = '-'; endif;
		echo '<a href="mailto:'.$email.' target="_blank">'.$email.'</a>'; 
        break;
	  case 'telefoon':
		$telefoon = get_post_meta( $post_id , 'telefoon' , true );
		if(!$telefoon) : $telefoon = '-'; endif;
		echo $telefoon;
        break;
      case 'website':
		$website = get_post_meta( $post_id , 'website' , true );
		if(!$website) : $website = '-'; endif;
		echo '<a href="'.$website.' target="_blank">'.$website.'</a>'; 
        break;
    }
}

?>