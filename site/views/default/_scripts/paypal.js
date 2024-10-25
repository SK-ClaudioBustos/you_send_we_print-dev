var item_number, quantity, custom, pp_url;


function get_paypal_info() {
	$.ajax({
		type: 'POST',
		url: pp_url,
		data: { 
				item_number: item_number 
			},
		dataType: 'json',
		error: function(jqXHR, textStatus, errorThrown) {
				//App.unblockUI($('#paypal_form'));
			},
		success: function(data) {
				if (data) { 
					if (!data.error) {
						$('#item_number').val(item_number);
						$('#quantity').val(quantity);
						$('#custom').val(custom);
						
						$('#business').val(data.info['business']);
						$('#notify_url').val(data.info['notify_url']);
						
						//$('#return').val(data.product['return']);
						$('#return').val(data.info['return_url']);
						$('#cancel_return').val(data.product['cancel_return']);
						
						//$('#item_name').val($('#item_name')); // data.product['item_name']);
						
						var total = $('#sale_total').val();
						total = total.replace('$ ', '');
						$('#amount').val(total); // data.product['amount']);
						$('#currency_code').val(data.product['currency_code']);
						
						$('#paypal_form').attr('action', data.info['url'])
//console.log('Paypal submit');							
						$('#paypal_form').submit();
						
						//App.unblockUI($('#paypal_form'));
					} else {
						// data error
					}
				} else {
					// no data
				}
			}
	});
}



function init_paypal(a_item_number, a_quantity, a_custom) {
	pp_url = $('#paypal_form').attr('action') + '/ajax_form';
	
	item_number = a_item_number; 
	quantity = a_quantity; 
	custom = a_custom;
		
	$(function() {
//		$('#paypal_buy').click(function() {
//			$(this).hide();
//			$('#paypal_loader').show();
//			get_paypal_info();
//			return false;
//		});		
	});
	
}
