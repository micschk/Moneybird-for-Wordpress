<?php

add_action('wp_dashboard_setup', 'mb_dashboard_widgets' );

function mb_dashboard_widgets(){
	if(current_user_can('administrator')) :
		wp_add_dashboard_widget('latest_companies_function', 'Laatste 10 Moneybird Bedrijven', 'latest_companies_function');
		wp_add_dashboard_widget('latest_invoices_function', 'Laatste 10 Moneybird facturen', 'latest_invoices_function');
	else :
		wp_add_dashboard_widget('user_latest_invoices_function', 'Mijn laatste facturen', 'user_latest_invoices_function');
	endif;
}

require_once (dirname(__FILE__) . '/companies.php');
require_once (dirname(__FILE__) . '/invoices.php');

?>