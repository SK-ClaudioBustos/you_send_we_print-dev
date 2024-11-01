function init_multiple() {
	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 54, fixed: true, align: 'center', classes: 'tools', formatter: render_tool },

						{ name: 'controller', label: lang['scaffold:controller'], index: 'controller', width: 160, formatter: render_link },
						{ name: 'class_name', label: lang['scaffold:class_name'], index: 'class_name', width: 160 },
						{ name: 'table_name', label: lang['scaffold:table_name'], index: 'table_name', width: 160 },
						{ name: 'primary', label: lang['scaffold:primary'], index: 'primary', width: 120 },
						{ name: 'to_string', label: lang['scaffold:to_string'], index: 'to_string', width: 120 }
				   	],
				sortname: 'controller',
			   	sortorder: 'asc'
			};
			
		var grid = init_grid(options);
		init_grid_search(grid);
	});
}
	

function init_single() {
	var select = function(elem, status) {
		var select = elem.parents('.form-group').find('select'); 
		select.find('option').prop('selected', status);
		select.trigger('change');
	}; 


	var table_change = function(table){
		if (table) {
            App.blockUI({target: $('.scaffold-form'), iconOnly: true});

			var name = table.replace($('#table_prefix').val(), '').capitalize();
			
			$('#class_name').val(name);
			$('#controller').val(name);
			$('#plural').val(name + 's');
			
			$.ajax({
				type: 'POST',
				url: url_table,
				data: {
					table: table
				},
				dataType: 'json',
				error: function(jqXHR, textStatus, errorThrown){
					App.unblockUI($('.scaffold-form'));
				},
				success: function(data){
					if (!data.error) {
						$('#primary').val(data.primary);

						$('#to_string').select2('val', null);
						$('#fields_grid').select2('val', null);
						$('#fields_form').select2('val', null);
						
						$('#to_string, #fields_grid, #fields_form').html('');

						var len = data.fields.length;
						for (var i=0, len = len; i < len; i++) {
							var option = $('<option></option>')
								.val(data.fields[i])
								.text(data.fields[i]);
								
								option.clone().appendTo('#to_string');
								
								if (data.fields[i] != data.primary && data.fields[i] != 'deleted') {
									option.clone().prop('selected', true).appendTo('#fields_grid');
									option.clone().prop('selected', true).appendTo('#fields_form');
								}
						}
						if (len) {
							$('#to_string').select2('val', data.primary);
					        $('#fields_grid').trigger('change');
					        $('#fields_form').trigger('change');
						}
					}
					App.unblockUI($('.scaffold-form'));
				}
			});
		}
	}
	
	
	$(function() {
		$('.select2').select2({
			placeholder: lang['form:select'] + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
			language: 'es',
		});
		
		$('.sel_all').click(function() {
			select($(this), true);
			return false;
		});
		
		$('.sel_none').click(function() {
			select($(this), false);
			return false;
		});
		
		$('#table_name').on('change', function(e) {
			table_change($(this).val());
		});
		
		
		// horrible fix for avoiding sorting - TODO: replace with select2 3.5.3 http://select2.github.io/select2/
		$('.select2[multiple]').on('select2:select', function (evt) {
			var element = evt.params.data.element;
			var $element = $(element);
			
			$element.detach();
			$(this).append($element);
			$(this).trigger("change");
		});	
			
	});
}