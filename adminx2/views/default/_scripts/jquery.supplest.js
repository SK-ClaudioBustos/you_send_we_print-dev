// JavaScript Document

// convenience method for quick growl-like notifications  (http://www.google.com/search?q=growl)
$.sppNotify = function(title, message, ntf_class, timeout, onClose) {
	if (ntf_class == undefined) {
		ntf_class = 'ntf_info';
	}
	
	var $m = $('<div class="growlUI ' + ntf_class + '"></div>');
	
	if (title) {
		$m.append('<h3>'+title+'</h3>');
	}
	
	if (message) {
		$m.append('<p>'+message+'</p>');
	}
	
	if (timeout == undefined) {
		timeout = 3000;
	}
	
	$.blockUI({
		message: $m, 
		fadeIn: 500, 
		fadeOut: 1000, 
		centerY: false,
		timeout: timeout, 
		showOverlay: false,
		onUnblock: onClose, 
		css: { 
			width:    '600px', 
			top:      '110px', 
			left:     '', 
			right:    '24px', 
			border:   'none', 
			opacity:   0.9, 
			cursor:    null, 
			'-webkit-border-radius': '0', 
			'-moz-border-radius':    '0' 
    }
	});
};

