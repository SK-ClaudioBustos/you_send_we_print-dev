function init_multiple() {
	var _grid;

	var options = {
			colModel: [
					{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
					{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },

					{ name: 'provider', index: 'provider', label: lng_text('provider:provider'), width: 200, formatter: render_link_act },
					{ name: 'provider_email', index: 'provider_email', label: lng_text('provider:provider_email'), width: 240, fixed: true },
					{ name: 'provider_phone', index: 'provider_phone', label: lng_text('provider:provider_phone'), width: 150, fixed: true },
					{ name: 'provider_url', index: 'provider_url', label: lng_text('provider:provider_url'), width: 240 },
					{ name: 'provider_city', index: 'provider_city', label: lng_text('provider:provider_city'), width: 240 },
					{ name: 'provider_state', index: 'provider_state', label: lng_text('provider:provider_state'), width: 120 },
			   	],
			sortname: 'provider',
			sortorder: 'ASC',
			shrinkToFit: false,
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
		$('.select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: false,
		});
	});
}
