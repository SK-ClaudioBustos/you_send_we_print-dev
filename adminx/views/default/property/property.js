function init_multiple(superadmin) {
	var _grid;

	var render_value = function (cellvalue, options, rowObject) {
		return '<div style="max-height: 100px;">' + cellvalue + '</div>';
	};

	var options = {
		colModel: [
				{ name: 'tools', label: ' ', width: 54, fixed: true, align: 'center', classes: 'tools',
						formatter: (superadmin) ? render_tool : render_tool_edt },

				{ name: 'property', index: 'property', label: lng_text('property:property'), width: 240, fixed: true, formatter: render_link },
				{ name: 'property_key', index: 'property_key', label: lng_text('property:property_key'), width: 120, fixed: true,
						hidden: !superadmin, formatter: render_main },
				{ name: 'type', index: 'type', label: lng_text('property:type'), width: 120, fixed: true },
				{ name: 'hidden', index: 'hidden', label: lng_text('property:hidden'), width: 60, fixed: true, align: 'center' },
				{ name: 'value', index: 'value', label: lng_text('property:value'), width: 540, formatter: render_value },
		   	],
			sortname: 'property',
			sortorder: 'ASC'
		};


	$(function() {
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
		$('#type').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: false,
		})
			.on('change', function(e) {
					$('#value_str').parents('.form-group').toggleClass('hidden', $.inArray($('#type').val(), ['str']) == -1);
					$('#value').parents('.form-group').toggleClass('hidden', $.inArray($('#type').val(), ['int', 'dec']) == -1);
					$('#value_jsn').parents('.form-group').toggleClass('hidden', $.inArray($('#type').val(), ['jsn']) == -1);
					$('#value_trf').parents('.form-group').toggleClass('hidden', $.inArray($('#type').val(), ['trf']) == -1);
				});
		$(".blue").on('click', (elemet) =>{
			elemet.preventDefault();
			$('.form').submit();
		});
	});
}
