<?php

// dashboard widget latest 10 invoices :: admin
function latest_invoices_function($type=false) {
	global $post;
	$query_string = array(
						  'post_type'=>'mb_invoices',
						  'post_parent'=>$post->ID,
						  'post_status'=> 'publish',
						  'order' => 'DESC'
						);
	add_filter( 'post_limits', 'mb_widgets_limit' );
	$subitems = new WP_Query( $query_string );
	remove_filter( 'post_limits', 'mb_widgets_limit' );
	include(CUSTOM_MADE_MB_PLUGIN.'/admin/invoices.php');
}

function user_latest_invoices_function($type=false) {
		
	$current_user = wp_get_current_user();
	$userid = $current_user->ID;
	
	echo $userid;
	
	global $post;
	$query_string = array(
						  'post_type'=>'mb_invoices',
						  'post_parent'=>$post->ID,
						  'post_status'=> 'publish',
						  'order' => 'DESC'
						);
	add_filter( 'post_limits', 'mb_widgets_limit' );
	$subitems = new WP_Query( $query_string );
	remove_filter( 'post_limits', 'mb_widgets_limit' );
	include(CUSTOM_MADE_MB_PLUGIN.'/admin/invoices.php');
}


?>