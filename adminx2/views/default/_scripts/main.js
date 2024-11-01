$(function() {
	// Success/Error ------------------------------------------
	if (success_msg) {
		$.sppNotify('', success_msg, 'ntf_success'); 
	} else if (error_msg) {
		$.sppNotify('', error_msg, 'ntf_error'); 
	}

	$('#cancel').click(function() {
		history.back();														
	});
});

function scrollbarWidth() {
	var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div>');
	// Append our div, do our calculation and then remove it
	$('body').append(div);
	
	var w1 = $('div', div).innerWidth();
	div.css('overflow-y', 'scroll');
	var w2 = $('div', div).innerWidth();
	$(div).remove();
	
	return (w1 - w2);
}