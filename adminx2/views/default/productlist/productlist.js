function init_single() {
	$(function() {
		$('.check_list input').click(function() {
			if ($(this).attr('checked')) {
		        //alert('checked ' + $(this).next().html());
		        var id = $(this).attr('id').replace(/itm_/gi, '');
		        var label = $(this).next().html();
				// add to sort list
		        $('#order_list').append('<li id="item_' + id + '">' + label + '</li>');
				
		    } else {
		        //alert('unchecked ' + $(this).next().html());
		        var id = $(this).attr('id');
		        $('#item_' + id).remove();
		    }
			// update order list
			var order = $('.sortable').sortable('toArray');
			$('#order').val(order.join('|').replace(/item_/gi, ''));
			$('#order_changed').val('1');
		});

		$('ul.spp_tabs').tabs('div.spp_panes > div');

		$('.sortable').sortable({
			axis: 'y',
			containment: '#sort_container',
			placeholder: 'sort_placeholder',
			update : function () {
				$('#order_changed').val('1');
				var order = $('.sortable').sortable('toArray');
				$('#order').val(order.join('|').replace(/item_/gi, ''));
			}
		});
	});
}
