/*
 * jQuery functions
 * Copyright (c) 2012 Csorba Media
 * www.csorbamedia.com
 */
var txtRegex = /^([a-zA-Z0-9]+\s?)*$/;
var intRegex = /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/;
var phoRegex = /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/;	
var pscRegex = /^([0-9]{4}[A-Za-z]{2})$/;
var emailRegex = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
var dateDDMMYYYRegex = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
var urlRegex = /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
var kenRegex = /^[A-Za-z0-9]{2,3}(-|)[A-Za-z0-9]{2,3}(-|)[A-Za-z0-9]{2,3}$/;

var selector  = false; 
var selector1 = false;
var selector2 = false;
var counter = null;

jQuery(document).ready(function(){
	kfBelMij();
	kfContactForm();
});

function kfBelMij(){
	jQuery('#kfBelMij').submit(function(e){
		e.preventDefault();
		log('ik wil de bel mij formulier verzenden');
		var formid = jQuery(this).attr('id');
		var naam = jQuery(this).find('#naam');		
		var telefoonnummer = jQuery(this).find('#telefoonnummer');
		
		if(naam.val() == null || naam.val() == undefined || naam.val() == 'naam'){
			error('geen naam ingevuld',naam);
			write('U heeft geen naam ingevoerd!',formid);
		}else if(!naam.val().match(txtRegex)){
			selector1 = false;
			error('alleen text invoeren',naam);
			write('U kunt alleen text [A-Z] invoeren bij telefoonnummer!',formid);
		}else{
			selector1 = true;
			success('hij is gewoon goed');
		}
		if(telefoonnummer.val() == null || telefoonnummer.val() == undefined || telefoonnummer.val() == 'telefoonnummer'){
			selector2 = false;
			error('geen telefoonnummer ingevuld',telefoonnummer);
			write('U heeft geen telefoonnummer ingevoerd!',formid);
		}else if(!telefoonnummer.val().match(phoRegex)){
			selector2 = false;
			error('alleen cijfers invoeren',telefoonnummer);
			write('Schrijf uw telefoonnummer voluit 0612345678 of 0701234567!',formid);
		}else{
			selector2 = true;
			success('hij is gewoon goed');
		}
		log(selector1 + selector2);
		if(selector1 == true && selector2 == true){
			try {
				jQuery.get('http://www.kinderfeestje.com/wp-content/themes/kinderfeest/mail/kfBelmij.php?naam='+naam.val()+'&telefoonnummer='+telefoonnummer.val(), function(data){
					write(data,formid);				
				});
			}catch(err)
			{
				write('Er is iets fout gegaan. + #'+formid,formid);
			}
		}
		log('naam = ' + naam + ' tel = ' + telefoonnummer);
	});
}

function kfContactForm(){
	jQuery('#kfContactForm').submit(function(e){
		e.preventDefault();
		log('ik wil het contact formulier verzenden');
		var formid = jQuery(this).attr('id');
		var naam = jQuery(this).find('#naam');		
		var emailadres = jQuery(this).find('#emailadres');
		var bericht = jQuery(this).find('#bericht').val();
		
		if(naam.val() == null || naam.val() == undefined || naam.val() == 'Uw naam'){
			error('geen naam ingevuld',naam);
			write('U heeft geen naam ingevoerd!',formid);
		}else if(!naam.val().match(txtRegex)){
			selector1 = false;
			error('alleen text invoeren',naam);
			write('U kunt alleen text [A-Z] invoeren bij telefoonnummer!',formid);
		}else{
			selector1 = true;
			success('hij is gewoon goed');
		}
		if(emailadres.val() == null || emailadres.val() == undefined || emailadres.val() == 'Uw emailadres'){
			selector2 = false;
			error('geen emailadres ingevuld',emailadres);
			write('U heeft geen emailadres ingevoerd!',formid);
		}else if(!emailadres.val().match(emailRegex)){
			selector2 = false;
			error('niet geldig',telefoonnummer);
			write('Schrijf uw emailadres als volgt info@example.com!',formid);
		}else{
			selector2 = true;
			success('hij is gewoon goed');
		}
		log(selector1 + selector2);
		if(selector1 == true && selector2 == true){
			try {
				jQuery.get('http://www.kinderfeestje.com/wp-content/themes/kinderfeest/mail/kfContactForm.php?naam='+naam.val()+'&emailadres='+emailadres.val()+'&bericht='+bericht, function(data){
					write(data,formid);				
				});
			}catch(err)
			{
				write('Er is iets fout gegaan. + #'+formid,formid);
			}
		}
		log('naam = ' + naam + ' email = ' + emailadres + ' bericht = ' + bericht);
	});
}

function checkSelector(myval,myvalname,myval_default,regex){
		if(myval.val() == null || myval.val() == undefined || myval.val() == myval_default){
			error('geen '+ myvalname +' ingevuld',myval);
			write('U heeft geen '+myvalname+' ingevoerd!');
			log('myname: '+ myvalname + '=' + selector[myvalname]);
		}else if(!myval.val().match(regex)){
			if(regex == txtRegex){
				error('alleen text invoeren',myval);
				write('U kunt alleen text [A-Z][0-9] invoeren bij '+myvalname+' !');
				log('myname: '+ myvalname + '=' + selector[myvalname]);
			}else if(regex == intRegex){
				error('alleen cijfers invoeren',myval);
				write('U kunt alleen cijfers [0-9][?.-] invoeren bij '+myvalname+' !');
				log('myname: '+ myvalname + '=' + selector[myvalname]);
			}else if(regex == pscRegex){
				error('alleen cijfers + twee letters invoeren',myval);
				write('Voer uw postcode als volgt in 1234AA!');
				log('myname: '+ myvalname + '=' + selector[myvalname]);
			}else if(regex == emailRegex){
				error('geen geldige email adres ingevoerd',myval);
				write('U heeft geen geldig email adres ingevoerd!');
				log('myname: '+ myvalname + '=' + selector[myvalname]);
			}else if(regex == phoRegex){
				error('geen geldige telefoonnummer ingevoerd',myval);
				write('U heeft geen geldige telefoonnummer ingevoerd!');
				log('myname: '+ myvalname + '=' + selector[myvalname]);
			}else if(regex == dateDDMMYYYRegex){
				error('geen geldige datum ingevoerd',myval);
				write('U heeft geen geldige datum ingevoerd!');
				log('myname: '+ myvalname + '=' + selector[myvalname]);
			}else if(regex == kenRegex){
				error('geen geldige kenteken ingevoerd',myval);
				write('U heeft geen geldige kenteken ingevoerd!');
				log('myname: '+ myvalname + '=' + selector[myvalname]);
			}
			else{
				success(myval+' is gewoon goed');
			}
		}else{
			success(myval+' is gewoon goed');
		}
}
function onBlur(myval,mytext){
	value = mytext;
	jQuery(myval).val(value);
	jQuery(myval).focus(function(){
		if(jQuery(this).val() == mytext){
			jQuery(this).val('');
		}
	});
	jQuery(myval).blur(function(){
		if(jQuery(this).val() == ''){
			jQuery(this).val(mytext);
		}	
	});	
}

function error(message,val){
	log(message);
	log('kom ik hier opnieuw');
	log(val);
	jQuery(val).addClass('error');
	jQuery(val).change(function(){
		jQuery(this).removeClass('error');
	});
}

function write(message,formid){
	log(message);
	message = '<li>'+message+'</li>';
	jQuery('#'+formid+' #request').show(500,function() {
		jQuery('#'+formid+' #request #request-list').append(message);
	});
}


function success(message){
	log(message);
}

/**
 * Enable debugging in Firebug for example.
 * @author Stephan Csorba <info@csorba.nl>
 *
*/
function log() {
	if (window.console && window.console.log)
		window.console.log('debug: ' + Array.prototype.join.call(arguments,' '));
}