/*
 * jQuery functions
 * Copyright (c) 2012 Csorba Media
 * www.csorbamedia.com
 */
jQuery(document).ready(function(){	
	var sudoSlider = jQuery("#slider").sudoSlider({ 
		fade: true,
		crossFade:false,
		numeric:true,
		speed:'5000'
	});

	jQuery(".ckinfoform").bind('click',function() {
		jQuery(".popular").hide();
		jQuery("#infoform").show(500);
	})
	
	jQuery("#input_dag").datepicker({ dateFormat: 'dd-mm-yy', firstDay:1, minDate:0 });
	jQuery("#input_tijd").timepicker({
		stepMinute: 5,
		currentText: 'Nu',
		closeText: 'Klaar',
		timeOnlyTitle: 'Kies tijdstip',
		timeText: 'Tijd',
		hourText: 'Uur',
		minuteText: 'Minuut'
	});
	jQuery("form#findentertainer").bind('submit',codeAddress);

	if(
	   jQuery("#infoform input#input_postcode").length == 1 &&
	   jQuery("#infoform input#form_latitude").length == 1 &&
	   jQuery("#infoform input#form_longitude").length == 1
	) {
		jQuery("#infoform input#input_postcode").bind('blur',hiddenAddress);
	}
	
	jQuery("#infoform input#input_postcode").bind('blur',hiddenAddress);

	topslider();
	initialize();
	gotoform();
});
var geocoder;
function initialize() {
	geocoder = new google.maps.Geocoder();
}
function codeAddress(e) {
	e.preventDefault();
	jQuery("#zipcode").removeClass('error');
	if(jQuery("#zipcode").attr('value') == '' || jQuery("#zipcode").attr('value') == '1245AB' || jQuery("#zipcode").attr('value').length != 6) {
		jQuery("#zipcode").addClass('error');
		return false;
	}
	
	geocoder.geocode( { 'address': jQuery("#zipcode").attr('value')}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			jQuery("#geocode input[name='zip']").attr('value',jQuery("#zipcode").attr('value'));
			jQuery("#geocode input[name='lat']").attr('value',results[0].geometry.location.lat());
			jQuery("#geocode input[name='lon']").attr('value',results[0].geometry.location.lng());
			jQuery("#geocode").submit();
		} else {
			jQuery("#zipcode").addClass('error');
		}
	});
}
function hiddenAddress(e) {
	e.preventDefault();
	
	geocoder.geocode( { 'address': jQuery("#infoform input#input_postcode").attr("value")}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			jQuery("#infoform input#form_latitude").attr('value',results[0].geometry.location.lat());
			jQuery("#infoform input#form_longitude").attr('value',results[0].geometry.location.lng());
		}
	});
}
function topslider(){
	jQuery('#comments').after('<div id="nav" class="nav">').cycle({
		fx:     'scrollDown'
	});
}
function gotoform(){
	jQuery('#gotoform').bind('click',function(){
		jQuery('body,html').animate({
			scrollTop: jQuery("#infoform").offset().top -20
		}, 800);
		return false;
	});
} 

