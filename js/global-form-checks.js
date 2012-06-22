/*
 * jQuery functions
 * Copyright (c) 2012 Csorba Media
 * www.csorbamedia.com
 */
jQuery(document).ready(function(){
	// this is not used by now
});

/**
 * Enable debugging in Firebug for example.
 * @author Stephan Csorba <info@csorba.nl>
 *
*/
function log() {
	if (window.console && window.console.log)
		window.console.log('debug: ' + Array.prototype.join.call(arguments,' '));
}