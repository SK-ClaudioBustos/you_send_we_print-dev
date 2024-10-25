var validate_email = function (email) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
};

var subscribe = function () {
	var email = $('#subscribe').val();
	if (!email) {
		$('.subscribe-box').addClass('has-error');

	} else if (!validate_email(email)) {
		$('.subscribe-box').addClass('has-error');
		bootbox.alert(lng_text('form:email_invalid'));

	} else {
		$('.subscribe-box').removeClass('has-error');
		var target = $('#target').val();
		let block = $('.subscribe-box .input-group');
		App.blockUI({ target: block, iconOnly: true });
		
		$.ajax({
			type: 'POST',
			url: $('.subscribe-box').attr('action'),
			data: {
					email: email,
					target: target,
					action: 'suscribe'
				},
			error: function(jqXHR, textStatus, errorThrown) {
					App.unblockUI(block);
				},
			success: function(data) {
					App.unblockUI(block);
					$('#subscribe').val('');
					bootbox.alert(lng_text('form:subscribed'));
				}
		});

	}
};

function smooth_reload(url) {
	//window.history.pushState({},null,url);
	//window.location.reload();
	window.location.href = url;
}

function change_chat_text(){
	let width = $(document).width();

	if ($('#body_home').length != 1 && width <= 991) {		
		$("iframe[title~=widget]")
            .parent()
            .attr("style", "display: none !important");
	} 
	
	if ($("iframe[title~=widget]").width() < 100) {
		$("iframe[title~=widget]").css("right", "-3px");
    }
}

function get_product_list() {
	$.ajax({
        type: "POST",
        url: product_list,
        data: {},
		dataType: 'json',       
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        },
        success: function (data) {			
			for (let title of data) {
                $("#product_list").append(`<option value='${title}'`);
            }
		},
    });
}

function search_done() {
	let title = $("#search").val() || $("#search_top").val();	
    $.ajax({
        type: "POST",
        url: product_search,
        data: {
            title
        },
        dataType: "json",
        error: function (jqXHR, textStatus, errorThrown) {
            //console.log(textStatus);
        },
        success: function (data) {
            if (data) {
				window.location.href = data;
			}
        },
    });
}

$(function () {
	$('.how_to_title').on('click', function () {
		$('.how_to_title').html(($('.how_to_text').is(':hidden')) ? lng_text('form:less') : lng_text('form:more'));
		$('.how_to_text').slideToggle('slow');
		//$('.how_to_close').toggle();
		return false;
	});

	$('.how_to_close').on('click', function () {
		$(this).hide();
		$('.how_to_text').slideUp('slow');
		return false;
	});

	$('.search-header button').on('click', function() {
		search_done();
	});

	$("#search, #search_top").on("keyup", (e) => {
		if (e.key == 'Enter') {
			search_done();
		}
	});
	$("#search, #search_top").on("input", (e) => {		
			search_done();
	});

	$('.btn-subscribe').on('click', function() {
		subscribe();
	});

	$('.subscribe-box').on('submit', function (e) {
		subscribe();
		return false;
	});

	setTimeout(() => {
		change_chat_text();
	},4000);

	$("#toggle_search").on('click', (e) => {
		e.preventDefault();
		$(".search-container").toggle(300);
		$('#search').focus();
	});
	$("#toggle_search-mobile").on('click', (e) => {
		e.preventDefault();
		$(".search-container-mobile").toggle();
		$("#search_top").focus();
	});

	get_product_list();
});


var Login = function () {

	var timezone_convert = function (value, separator) {
		if (!separator) { var separator = ":"; }
		
		var hours = parseInt(value);
	
		value -= parseInt(value);
		value *= 60;
		
		var mins = parseInt(value);
		value -= parseInt(value);
		value *= 60;
	
		var secs = parseInt(value);
		var display_hours = hours;
	
		mins = (mins < 10) ? "0" + mins : mins;
	
		return display_hours + separator + mins; 
	}

	var timezone_calculate = function(separator) {
		if (!separator) { var separator = ":"; }
	
		var rightNow = new Date();
		
		var jan1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);  // jan 1st
		var june1 = new Date(rightNow.getFullYear(), 6, 1, 0, 0, 0, 0); // june 1st
		
		var temp = jan1.toGMTString();
		
		var jan2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
		temp = june1.toGMTString();
		var june2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
		
		var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
		var daylight_time_offset = (june1 - june2) / (1000 * 60 * 60);
		var dst;
		
		if (std_time_offset == daylight_time_offset) {
			dst = "0"; // daylight savings time is NOT observed
		} else {
			// positive is southern, negative is northern hemisphere
			var hemisphere = std_time_offset - daylight_time_offset;
			if (hemisphere >= 0) {
				std_time_offset = daylight_time_offset;
			}
			dst = "1"; // daylight savings time is observed
		}
	
		return dst + "|" + timezone_convert(std_time_offset, separator);
	}

	var handleLogin = function() {
		
		$('.login-form').validate({
	            errorElement: 'span',		//default input error message container
	            errorClass: 'help-block',	// default input error message class
	            focusInvalid: false,		// do not focus the last invalid input
	            rules: {
	                username: { required: true },
	                password: { required: true },
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            errorPlacement: function (error, element) { // can't be removed
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            $('.login-form input').closest('.form-group').removeClass('has-error'); 
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    $('.login-form').submit();
	                }
	                return false;
	            }
	        });
	}

	var handleForgetPassword = function () {
		$('.forget-form').validate({
	            errorElement: 'span',		//default input error message container
	            errorClass: 'help-block',	// default input error message class
	            focusInvalid: false,		// do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: { required: true, email: true }
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            errorPlacement: function (error, element) {
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            $('.forget-form input').closest('.form-group').removeClass('has-error'); // set error class to the control group
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

	}

   
    return {

        //main function to initiate the module
        init: function () {
            handleLogin();
            handleForgetPassword();
        }

    };

}();
