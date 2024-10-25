var signup = function () {
	let name = $('#signup_name').val();
	let email = $('#signup_email').val();
	let error = false; 

	if (!name) {
		$('#signup_name').parents('.form-group').addClass('has-error');
		error = true;
	}
	
	if (!email) {
		$('#signup_email').parents('.form-group').addClass('has-error');
		error = true;

	} else if (!validate_email(email)) {
		$('#signup_email').parents('.form-group').addClass('has-error');
		error = true;
		bootbox.alert(lng_text('form:email_invalid'));
	} 

	return !error;
};

function init_slider(slide_speed) {
    let type;
    let width = $(document).width();

	$(".slide-dummy").show();

    if (width > 500) {
        type = "f";
    } else if (width <= 500) {
        type = "m";
    }

    let selector = type == "f" ? "#rev_slider_1" : "#rev_slider_m";
    let responsiveLevels_a =
        type == "f"
            ? [7047, 5738, 5114, 4162, 3200, 2200, 1804, 1380, 1024, 778]
            : [500];

    let gridwidth_a =
        type == "f"
            ? [7047, 5738, 5114, 4162, 3200, 2200, 1804, 1380, 1024, 778]
            : [500];

    let gridheight_a =
        type == "f"
            ? [2050, 1669, 1488, 1211, 931, 640, 525, 402, 298, 227]
            : [719.5];

    jQuery(selector).revolution({
        // options are 'auto', 'fullwidth' or 'fullscreen'
        sliderLayout: "auto",

        // [DESKTOP, LAPTOP, TABLET, SMARTPHONE]
        responsiveLevels: responsiveLevels_a,
        gridwidth: gridwidth_a,
        gridheight: gridheight_a,

        delay: slide_speed,

        // basic navigation arrows and bullets
        navigation: {
            arrows: {
                enable: true,
                hide_onleave: true
            },

            bullets: {
                enable: false,
                style: "persephone",
                hide_onleave: false,
                h_align: "right",
                v_align: "bottom",
                h_offset: 24,
                v_offset: 10,
                space: 5,
            },

            touch: {
                touchenabled: "on",
                swipe_threshold: 50,
                swipe_min_touches: 1,
                swipe_direction: "horizontal",
                drag_block_vertical: true,
            },
        },
    });

	$(".slide-dummy").hide();
}


function init_home(slide_speed) {

	$(function() {

		// initialize the slider based on the Slider's ID attribute
		init_slider(slide_speed);			

		$('.mix-grid').mixitup();

		$('.login_home').on('click', function() {
			$('.dropdown-login').addClass('open');
			return false;
		});

		$('.signup-form').on('submit', function (e) {
			return signup();
		});

		$('.signup-form input').keyup(function (event) {
			$('.signup-form input').parents('.form-group').removeClass('has-error');
		});

		function cambio() {          
			width = $(window).width();
			
            if (
                width <= 976 ||
                (width >= 992 && width <= 1211)
            ) {        
                $(".last_name_2").remove();           
                /* 
                $("#r_i_g_b #lbl_last_name")
                    .parent()
                    .insertBefore($("#r_i_g_b #lbl_company").parent());                
                $("#r_i_g_t #lbl_last_name")
                    .parent()
                    .insertBefore($("#r_i_g_t #lbl_company").parent());          
                */          
            } else if (
                (width <= 991 && width >= 977) ||                
                width >= 1212
            ) {
                $('.last_name_1').remove();            
                /*  
                $("#r_i_g_t #lbl_company")
                    .parent()
                    .insertBefore($("#r_i_g_t #lbl_last_name").parent());               
                $("#r_i_g_b #lbl_company")
                    .parent()
                    .insertBefore($("#r_i_g_b #lbl_last_name").parent());         
                */          
            }
            
            
			if (width <= 500) {		
                $("#r_i_g_b").remove();		
				/*$(".row.info").first().insertBefore(".row.slideshow");		
				$(".row.slideshow").css('margin-bottom', '18px');
				$(".warning").css('margin-bottom', '14px');$(".warning").insertBefore(".row.slideshow");
				$(".banner_header_div").show();
				$("#info_full_1_h2").hide();*/
			}else if (width > 500) {	
                $("#r_i_g_t").remove();							               
				/*$(".row.slideshow").insertBefore($(".row.info").first());
				$(".warning").insertBefore($(".content"));
				$(".row.slideshow").css("margin-bottom", "");
                $(".warning").css("margin-bottom", "");
				$(".banner_header_div").hide();
				$("#info_full_1_h2").show();*/
            }
			
		}

		$('.banner_link').on('click', (e) => {
			e.cancelBubble = true;
            if (e.stopPropagation) e.stopPropagation();
			window.location.href = e.currentTarget.dataset.link;
		})
		$(".banner_link input,.banner_link button").on("click", (e) => {
            e.cancelBubble = true;
            if (e.stopPropagation) e.stopPropagation();
        });
        cambio();
		//let x = window.matchMedia("(min-width: 992px) and (max-width: 1211px)");	
		//let y = window.matchMedia("(min-width: 977px) and (max-width: 991px)");
		//let z = window.matchMedia("(max-width: 976px)");
		//cambio(x);
		//cambio(z);
		//cambio(y);	
		//cambio();
		/*$(window).on('resize', () => {
			cambio(true)
			//init_slider(slide_speed);
		});*/
		//z.addEventListener("change", cambio);
		//y.addEventListener("change", cambio);		
		});

}

function cb_submit() {
    grecaptcha.execute();
    $(".register-form").submit();
}