<?php

/**
 * @package Moneybird
 */
/*
Plugin Name: Moneybird voor Wordpress
Plugin URI: http://moneybird.csorbamedia.com/?return=wp_moneybird_standard
Description: <strong>Moneybird</strong> wordt door meer dan 25.000 bedrijven gebruikt voor het factureren, offereren van producten en diensten. <br/> Deze Moneybird plugin maakt het mogelijk om binnen uw Wordpress omgeving Moneybird facturen en klanten te beheren gekoppeld aan het Wordpress user login systeem. <br/> U kunt eenvoudig en simpel uw klanten een overzicht geven van de openstaande en betaalde facturen binnen uw eigen website. Uw klanten kunnen vervolgens de factuur betalen, downloaden of printen.  
Version: 0.1
Author: Csorba Media
Author URI: http://www.csorbamedia.com/wordpress-plugins/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define('MONEYBIRD_VERSION', '0.1');
define('CUSTOM_MADE_MB_PLUGIN', ABSPATH.'/wp-content/plugins/moneybird');
define('CUSTOM_MADE_MB_THEME', '/wp-content/plugins/moneybird');

add_action('init', 'mb_init' );
add_action('admin_init', 'mb_admin_init' );
add_action('save_post', 'mb_meta_save' );
add_action('before_delete_post', 'mb_delete');
add_filter('nav_menu_css_class' , 'mb_encode_custom_fields' , 10 , 2);
add_action('widgets_init', 'mb_widgets_init');

include(CUSTOM_MADE_MB_PLUGIN.'/admin/moneybird/api.php');
include(CUSTOM_MADE_MB_PLUGIN.'/admin/api/api.php');

$backendjsmb = array(
				"jquery" => 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', // just to be safe, probably loaded from WP
				"mb_functions" => CUSTOM_MADE_MB_THEME.'/admin/functions.js',
				"jqueryui" => CUSTOM_MADE_MB_THEME.'/js/jqueryui/jquery-ui-1.8.18.custom.min.js',
				"jqueryui_timepicker" => CUSTOM_MADE_MB_THEME.'/js/jqueryui/jquery-ui-timepicker-addon.js',
			);
$backendcssmb = array(
				"custom_fields" => CUSTOM_MADE_MB_THEME.'/admin/custom_fields.css',
				"jqueryui_excitebike" => CUSTOM_MADE_MB_THEME.'/js/jqueryui/excite-bike/jquery-ui-1.8.18.custom.css',
				"jqueryui_timepicker" => CUSTOM_MADE_MB_THEME.'/js/jqueryui/timepicker.css',
			);
function mb_no_limit() {
	return 'LIMIT 0, 10000';
}

// dashboard widgets
function mb_widgets_limit(){
	return 'LIMIT 0, 10';
}

// widgets not in for now
function mb_widgets_init() {
}

// encode custom fields
function mb_encode_custom_fields($classes, $item) {
	return $classes;
}

// global installation, register post types
function mb_init() {
	register_post_type( 'mb_companies',
			array(
				'labels' => array(
					'name' => __( 'Bedrijven', 'post type general name' ),
					'singular_name' => __( 'Bedrijf', 'post type singular name' )
				),
				'show_ui'=>true,
				'show_in_menu'=>true,
				'public' => true,
				'taxonomies' => array('post_tag','thumbnail','category'),
				'supports' => array('title','editor','author','thumbnail','excerpt','comments','custom-fields', 'page-attributes'),
				'rewrite' => array('slug' => 'bedrijf')
			)
		);
	register_post_type( 'mb_invoices',
			array(
				'labels' => array(
					'name' => __( 'Facturen', 'post type general name' ),
					'singular_name' => __( 'Factuur', 'post type singular name' )
				),
				'show_ui'=>true,
				'show_in_menu'=>true,
				'public' => true,
				'supports' => array('title','editor','author','custom-fields', 'page-attributes'),
				'rewrite' => array('slug' => 'factuur'),
				'capability' => __('mb_invoices')
			)
		);
	flush_rewrite_rules(false);
}

// custom fields entertainers
function mb_custom_fields($type) {
	if($type == 'mb_companies') {
		$array[0] = array(
			'voornaam'=>array("type"=>"string","name"=>"Voornaam"),
			'achternaam'=>array("type"=>"string","name"=>"Achternaam"),
			'bedrijf'=>array("type"=>"string","name"=>"Bedrijfsnaam"),
			'email'=>array("type"=>"email","name"=>"Uw emailadres"),
			'telefoon'=>array("type"=>"string","name"=>"Telefoonnummer"),
			'postcode'=>array("type"=>"string","name"=>"Postcode"),
			'straat_nr'=>array("type"=>"string","name"=>"Straat en huisnummer"),
			'plaats'=>array("type"=>"string","name"=>"Plaats"),
			'website'=>array("type"=>"string","name"=>"Website"),
			'moneybird'=>array("type"=>"int","name"=>"Moneybird userid")
		  );
		if(get_option('moneybird_addon_register') == true) :
			$array[1] = array('gebruikersnaam'=>array("type"=>"string","name"=>"WP Gebruikersnaam"),'userid'=>array("type"=>"hidden","name"=>"WP Userid")); 
		endif;
		$this_array = array_merge($array[0],$array[1]);
		return $this_array;
	} elseif($type == 'mb_invoices') {
		return array(
			'company'=>array("type"=>"hidden","name"=>"Bedrijf ID"),
			'price'=>array("type"=>"string","name"=>"Bedrag"),
			'tax'=>array("type"=>"string","name"=>"Belasting"),
			'description'=>array("type"=>"text","name"=>"Omschrijving"),
			'moneybird_factuur_nummer'=>array("type"=>"string","name"=>"Moneybird factuur nummer"),
			'moneybird_factuur_online'=>array("type"=>"string","name"=>"Moneybird online link"),
			'moneybird_factuur_pdf'=>array("type"=>"string","name"=>"Moneybird pdf link"),
			'moneybird_paid'=>array("type"=>"string","name"=>"Betaald"),
			'moneybird_invoice_id'=>array("type"=>"hidden","name"=>"Moneybird factuur id (reference)"),
		  );
	}
	return array();
}

// general admin install
function mb_admin_init() {
	
	global $backendjsmb;
	global $backendcssmb;
	foreach($backendjsmb as $jsname => $jsurl) {
		wp_enqueue_script($jsname,$jsurl);
	}
	foreach($backendcssmb as $cssname => $cssurl) {
		wp_enqueue_style($cssname,$cssurl);
	}
	add_meta_box(
		'mb_meta',
		'Bedrijfsinformatie',
		'mb_meta',
		'mb_companies',
		'advanced',
		'high'
	  );
	
	add_meta_box(
		'mb_meta',
		'Factuur informatie',
		'mb_meta',
		'mb_invoices',
		'advanced',
		'high'
	  );
}

// custom admin fields
function mb_meta() {
	global $post;
	
	foreach(mb_custom_fields($post->post_type) as $key => $details) {
		$$key = get_post_meta($post->ID,$key,TRUE);
	}
	include(CUSTOM_MADE_MB_PLUGIN.'/admin/custom_fields.php');
	echo '<input type="hidden" name="my_meta_noncename" value="'.wp_create_nonce(__FILE__).'" />';
}

// custom admin meta save
function mb_meta_save($post_id) {
	global $post;
	if(!wp_verify_nonce($_POST['my_meta_noncename'],__FILE__)) {
		return $post_id;
	}
	if (!current_user_can('edit_post', $post_id)) return $post_id;
	$accepted_fields[$post->post_type] = array_keys(mb_custom_fields($post->post_type));
	$post_type_id = $_POST['post_type'];
	
	foreach($accepted_fields[$post_type_id] as $key) {
	$custom_field = $_POST[$key];
	if(is_null($custom_field)) {
		delete_post_meta($post_id, $key);
	} elseif(isset($custom_field) && !is_null($custom_field)) {
		update_post_meta($post_id,$key,$custom_field);
		if($key == 'email') :			
			$user_email = $custom_field;
			update_post_meta($post_id,'email',$user_email);
		elseif($key == 'gebruikersnaam') :
			$user_name = $custom_field;
			update_post_meta($post_id,'gebruikersnaam',$user_name);
			if(get_option('moneybird_addon_register') == true):
				$user_id = register_wp_user($post_id,$user_name,$user_email);
				if($user_id == '' || $user_id == false || $user_id == null):
					$user_id = $custom_field;
				endif;
			endif;
		elseif($key == 'userid') :
			update_post_meta($post_id,'userid',$user_id);
		elseif($key == 'website') :
			update_post_meta($post_id,'website',$custom_field);
		elseif($key == 'voornaam') :
			update_post_meta($post_id,'voornaam',$custom_field);
		elseif($key == 'achternaam') :
			update_post_meta($post_id,'achternaam',$custom_field);
		elseif($key == 'moneybird'):
			$moneybird_id = $custom_field;
			if($moneybird_id) :
				update_moneybird_contact($post_id, $moneybird_id);
			else :
				$moneybird = create_moneybird_contact($post_id);
				update_post_meta($post_id,'moneybird',$moneybird);
			endif;
		elseif($key == 'moneybird_invoice_id'):
			$moneybird_invoice_id = $custom_field;
			if($moneybird_invoice_id == false || $moneybird_invoice_id == '' || $moneybird_invoice_id == null) :
				$moneybird = create_moneybird_invoice($post_id);
				if($moneybird):
					update_post_meta($post_id,'moneybird_invoice_id',$moneybird->id);
				else:
					return $moneybird;
				endif;
			else :
				update_post_meta($post_id,'moneybird_invoice_id',$moneybird_invoice_id);
			endif;
		elseif($key == 'moneybird_factuur_nummer'):
			$mbinvoice = get_moneybird_invoice($post_id);
			if($mbinvoice->invoice_id) :
				update_post_meta($post_id,'moneybird_factuur_nummer',$mbinvoice->invoice_id);
			endif;
		elseif($key == 'moneybird_factuur_online'):
			$mbonline = get_moneybird_invoice($post_id);
			if($mbonline->invoice_id) :
				update_post_meta($post_id,'moneybird_factuur_online',$mbonline->url);
			endif;
		elseif($key == 'moneybird_factuur_pdf'):
			$mbpdf = get_moneybird_invoice($post_id);
			if($mbpdf->invoice_id) :
				update_post_meta($post_id,'moneybird_factuur_pdf',$mbpdf->pdf);
			endif;
		elseif($key == 'moneybird_paid'):
			$mbpaid = get_moneybird_invoice($post_id);
			if($mbpaid->invoice_id) :
				if($mbpaid->paid == null || $mbpaid->paid == false || $mbpaid->paid == '') :
					update_post_meta($post_id,'moneybird_paid','Nee');
				else :
					update_post_meta($post_id,'moneybird_paid','Ja');
				endif;
			endif;
		endif;
	}
	else {
		add_post_meta($post_id, $key, $custom_field, TRUE);
	}
	}
	return $post_id;
}

function mb_delete($post_id){
	global $post;
	$post = get_post($post_id);
	if ($post->post_type == 'mb_invoices') :
		if($_GET['action'] == 'delete' || $_GET['action'] == '-1'):
			delete_moneybird_invoice( $post->ID );
		endif;
	 elseif($post->post_type == 'mb_companies') :
		if($_GET['action'] == 'delete' || $_GET['action'] == '-1'):
			delete_moneybird_contact( $post->ID );
		endif;
    endif;
}

function moneybird_warning() {
	echo "<div id='moneybird-warning' class='updated fade'><p><strong>".__('Moneybird is bijna klaar voor gebruik.')."</strong> ".sprintf(__('Je moet je <a href="%1$s">gegevens</a> van je Moneybird nog invoeren.'), "admin.php?page=moneybird-config")."</p></div>";
}
if ( !get_option('moneybird_domain') && !get_option('moneybird_email') && !get_option('moneybird_pass') && !get_option('moneybird_key')) {
		add_action('admin_notices', 'moneybird_warning');
		return;
}

?>