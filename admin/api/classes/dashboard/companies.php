<?php

// dashboard widget latest 10 companies
function latest_companies_function($type=false) {
	global $post;
	$query_string = array(
						  'post_type'=>'mb_companies',
						  'post_parent'=>$post->ID,
						  'post_status'=> 'publish',
						  'order' => 'DESC'
						);
	add_filter( 'post_limits', 'mb_widgets_limit' );
	$subitems = new WP_Query( $query_string );
	remove_filter( 'post_limits', 'mb_widgets_limit' );
	include(CUSTOM_MADE_MB_PLUGIN.'/admin/companies.php');
}

?>