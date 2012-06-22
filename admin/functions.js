/*
 * jQuery functions
 * Copyright (c) 2012 Csorba Media
 * www.csorbamedia.com
 */
jQuery(document).ready(function(){
	createmoneybirdinvoice();
	sendmoneybirdreminder();
	sendmoneybirdinvoice();
});
function createmoneybirdinvoice(){
	jQuery('#maakfactuur').html('');
	jQuery('#maakfactuur').bind('click', function(e){
		e.preventDefault();
		jQuery('.ajax-loading').css('visibility','visible');
		postid = jQuery(this).attr('rel');
		try {
			jQuery.post('/wp-content/plugins/moneybird/admin/moneybird/create-wp-invoice.php', { postid: +postid }, function(data){
				jQuery('#maakfactuur-response').html(data);				
			});
		}catch(err)
		{
			alert('Er is iets fout gegaan met het vinden van de api.');
		}
	});
}
function sendmoneybirdreminder(){
	jQuery('#sendreminder').html('');
	jQuery('#sendreminder').bind('click', function(e){
		e.preventDefault();
		postid = jQuery(this).attr('rel');
		try {
			jQuery.post('/wp-content/plugins/moneybird/admin/moneybird/send-reminder.php', { postid: +postid }, function(data){
				jQuery('#sendreminder-response').html(data);
			});
		}catch(err)
		{
			alert('Er is iets fout gegaan met het vinden van de api.');
		}
	});
}
function sendmoneybirdinvoice(){
	jQuery('#verstuurfactuur').html('');
	jQuery('#verstuurfactuur').bind('click', function(e){
		e.preventDefault();
		postid = jQuery(this).attr('rel');
		try {
			jQuery.post('/wp-content/plugins/moneybird/admin/moneybird/send-invoice.php', { postid: +postid }, function(data){
				jQuery('#verstuurfactuur-response').html(data);
			}).complete(function() { jQuery('#publish').click(); });
		}catch(err)
		{
			alert('Er is iets fout gegaan met het vinden van de api.');
		}
	});
}