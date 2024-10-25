function init_multiple() {
	var _grid;

	var options = {
			colModel: [
					{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },

					{ name: 'product', index: 'product', label: lng_text('productlist:product_id'), width: 420, formatter: render_link },
					{ name: 'item_list_key', index: 'item_list_key', label: lng_text('productlist:item_list_key'), width: 320, formatter: render_main },
			   	],
			sortname: 'product',
			sortorder: 'ASC',
			shrinkToFit: false,
		};

	var load_grid = function() {
		let product_id = $('#product_id').val();

		let postData = { product_id: product_id };
console.log(postData);

		_grid.jqGrid('setGridParam', { postData: postData }); 
		_grid.trigger('reloadGrid', [{ page: 1 }]);

		var href = '/?' + 'product_id=' + product_id;
		$('#export_xls').attr('href', $('#export_xls').attr('data-href') + href);
		$('#export_xlsx').attr('href', $('#export_xlsx').attr('data-href') + href);
	};


	$(function() {
		$('#product_id').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
		});
		$('#product_id').on('change', function() {
			load_grid();
		});

		_grid = init_grid(options);
		init_grid_search(_grid);
		set_grid_height(_grid);

		$(window).on('resize', function() {
			set_grid_height(_grid);
		});
	});
}

function init_single() {
	$(function() {
		$('.select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
		});

		$('.check_list input').click(function() {
			if ($(this).attr('checked')) {
		        var id = $(this).attr('id').replace(/itm_/gi, '');
console.log(id);
		        var label = $(this).parents('.checker').next().html();
				// add to sort list
		        $('#order_list').append('<li id="item_' + id + '">' + label + '</li>');
				
		    } else {
		        //var id = $(this).attr('id');
		        var id = $(this).attr('id').replace(/itm_/gi, '');
console.log(id);
		        $('#item_' + id).remove();
		    }
			// update order list
			var order = $('.sortable').sortable('toArray');
			$('#order').val(order.join('|').replace(/item_/gi, ''));
			$('#order_changed').val('1');
		});

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
