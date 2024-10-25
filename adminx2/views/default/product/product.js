function init_single(children, sizes) {

	$(function() {
		$("ul.spp_tabs").tabs('div.spp_panes > div');
		tiny_mce_init(tinymce_folder, lang_iso, false, 618, 280);

		$('#use_stock').on('change', function() {
			$('#stock_min').attr('disabled', function() {
				$(this).val(0);
				return !$('#use_stock').is(':checked');
			});
		}); 
	});
	

	if (children) {
		$(function(){
			$('.sortable').sortable({
				axis: 'y',
				containment: '#sort_container',
				placeholder: 'sort_placeholder',
				update: function() {
						$('#order_changed').val('1');
						var order = $('.sortable').sortable('toArray');
						$('#order').val(order.join('|').replace(/item_/gi, ''));
					}
			});
		});
	}
	
	if (sizes) {
		function set_values($format, $width, $height, $price_a, $price_b, $price_c, $price_d, $provider_price, $provider_weight) {
			$('#format').val($format);
			$('#size_width').val($width);
			$('#size_height').val($height);
			
			$('#price_a').val($price_a);
			$('#price_b').val($price_b);
			$('#price_c').val($price_c);
			$('#price_d').val($price_d);

			$('#provider_price').val($provider_price);
			$('#provider_weight').val($provider_weight);
		}
		
		function get_values(size_sel, $format, $width, $height, $price_a, $price_b, $price_c, $price_d, $provider_price, $provider_weight) {
			$sizes[size_sel].format = $format;
			$sizes[size_sel].width = parseInt($width);
			$sizes[size_sel].height = parseInt($height);
			
			$sizes[size_sel].price_a = parseFloat($price_a).toFixed(2);
			$sizes[size_sel].price_b = parseFloat($price_b).toFixed(2);
			$sizes[size_sel].price_c = parseFloat($price_c).toFixed(2);
			$sizes[size_sel].price_d = parseFloat($price_d).toFixed(2);

			$sizes[size_sel].provider_price = parseFloat($provider_price).toFixed(2);
			$sizes[size_sel].provider_weight = parseFloat($provider_weight).toFixed(2);
		}

		function provider_sizes() {
			let measure_type = $('#measure_type').val();
			let provider_id = $('#provider_id').val();
			let hidden = !provider_id || measure_type != 'standard';

			$('#price_a').parent().toggleClass('hidden', hidden);
			$('#provider_price').parent().toggleClass('hidden', hidden);
			$('#provider_weight').parent().toggleClass('hidden', hidden);
		}
		 
		function size_update() {
			let size_new = false;
			let size_sel = $('#sizes').val();

			if (!size_sel) {
				size_new = true;
				size_sel = -Math.floor(Math.random() * 100000);
				$sizes[size_sel] = {};
			}
				
			get_values(
					size_sel,

					$('#format').val(), 
					$('#size_width').val(), 
					$('#size_height').val(), 

					$('#price_a').val(),
					$('#price_b').val(),
					$('#provider_price').val(),
					$('#price_d').val(),

					$('#provider_price').val(),
					$('#provider_weight').val()
				);
				
			$sizes_mod[size_sel] = $sizes[size_sel];
			$('#sizes_str').val(JSON.stringify($sizes_mod));
			let provider_id = $('#provider_id').val();
				
			$text = $sizes[size_sel].format.toUpperCase() 
					+ '&nbsp;&nbsp;|&nbsp;&nbsp;' 
					+ (($sizes[size_sel].width < 10) ? '&nbsp;&nbsp;' : '') + $sizes[size_sel].width 
					+ ' x ' 
					+ (($sizes[size_sel].height < 10) ? '&nbsp;&nbsp;' : '') + $sizes[size_sel].height + '"' 
					+ ((fineart || provider_id) ? '&nbsp;&nbsp;|&nbsp;&nbsp;' + (($sizes[size_sel].price_a < 100) ? '&nbsp;&nbsp;' : '') + $sizes[size_sel].price_a : '')
				;
					
			if (size_new) {
				$('#sizes').append($('<option />').attr('value', size_sel).html($text));
				$('#sizes').trigger('change');

			} else {
				$('#sizes option:selected').html($text);
			}
		}

		function size_delete() {
			if (confirm($delete_msg)) {
				let size_sel = $('#sizes').val();
					
				if (size_sel > 0) {
					$sizes_mod[size_sel] = {};
					$sizes_mod[size_sel].deleted = true;

				} else {
					delete $sizes[size_sel];
					delete $sizes_mod[size_sel];
				}

				$('#sizes_str').val(JSON.stringify($sizes_mod));
					
				$('#sizes option:selected').remove();
				$('#sizes').val('').trigger('change');
			}
		}
	
		function size_change() {
			if (size_sel = $('#sizes').val()) {
				// edit
				set_values(
						$sizes[size_sel].format, 
						$sizes[size_sel].width, 
						$sizes[size_sel].height, 

						$sizes[size_sel].price_a,
						$sizes[size_sel].price_b,
						$sizes[size_sel].price_c,
						$sizes[size_sel].price_d,

						$sizes[size_sel].provider_price,
						$sizes[size_sel].provider_weight
					);
				$('#delete').attr("disabled", false);
					
			} else {
				// new
				set_values('s', '', '', '', '', '', '', '');
				$('#delete').attr("disabled", true);
			}
		}
		

		$(function(){

			$('#provider_id, #measure_type').on('change', function() {
				provider_sizes();
			});


			$('#sizes').on('change', function() {
				size_change();
			});
			
			$('#delete').on('click', function(){
				size_delete();
			});
			
			$('#update').on('click', function() {
				size_update();
			});
			
		});
	}
}
