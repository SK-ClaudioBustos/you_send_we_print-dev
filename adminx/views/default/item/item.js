function init_multiple(item_list_key) {
	var _grid;

	var options = {
			colModel: [
					{ name: 'tools', label: ' ', width: 84, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool_act },
					{ name: 'active', index: 'active', label: lang['form:active'], width: 30, hidden: true },

					{ name: 'item_code', index: 'item_code', label: lng_text('item:item_code'), width: 90, fixed: true, formatter: render_main },
					{ name: 'title', index: 'title', label: lng_text('item:title'), width: 360, formatter: render_link_act },
					{ name: 'item_list_key', index: 'item_list_key', label: lng_text('item:item_list_key'), width: 160, formatter: render_main },
					{ name: 'price', index: 'price', label: lng_text('item:price'), width: 90, fixed: true, align: 'right', sorttype: 'float' },
					{ name: 'date', index: 'date', label: lng_text('item:date'), width: 90, fixed: true, align: 'right'},
					{ name: 'weight', index: 'weight', label: lng_text('item:weight'), width: 90, fixed: true, align: 'right', sorttype: 'float' },
					{ name: 'calc_by', index: 'calc_by', label: lng_text('item:calc_by'), width: 160 },
			   	],
			sortname: 'title',
			sortorder: 'ASC',
			postData: { item_list_key: item_list_key }
		};

	var load_grid = function() {
		let item_list_key = $('#item_list').val();
		let postData = {
				item_list_key: item_list_key,
			};

		_grid.jqGrid('setGridParam', { postData: postData }); 
		_grid.trigger('reloadGrid', [{ page: 1 }]);

		var href = '/?' + 'item_list_key=' + item_list_key;
		$('#export_xls').attr('href', $('#export_xls').attr('data-href') + href);
		$('#export_xlsx').attr('href', $('#export_xlsx').attr('data-href') + href);
	};


	$(function() {
		$('.select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
		});
		$('#item_list').on('change', function() {
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
			allowClear: false,
		});

		$('#item_list_key').on('change', function() {
			let list = lists[$(this).val()];

			if (list['calc_by'] == 'variable') {
				//$('#calc_by option').prop('disabled', false);
				$('#calc_by')
						.prop('disabled', false)
						.val('')
						.trigger('change')
						.parents('.form-group').removeClass('disabled');
			
			} else {
				//$('#calc_by option').not('[value="' + calc_by + '"]').prop('disabled', true);
				$('#calc_by')
						.prop('disabled', true)
						.val(lists[$(this).val()]['calc_by'])
						.trigger('change')
						.parents('.form-group').addClass('disabled');
			}

			let tab_cut = $('.nav-tabs a[data-href="#tab_cut"]');
			if (parseInt(list['has_cut'])) {
				tab_cut
						.attr('href', tab_cut.data('href'))	
						.attr('data-toggle', 'tab')
						.parent().removeClass('disabled');

			} else {
				tab_cut
						.removeAttr('href')
						.removeAttr('data-toggle')
						.parent().addClass('disabled');
			}

			if (parseInt(list['has_max'])) {
				$('#max_width')
						.prop('disabled', false)
						.parents('.form-group').removeClass('disabled');
				$('#max_length')
						.prop('disabled', false)
						.parents('.form-group').removeClass('disabled');
				$('#max_absolute')
						.prop('disabled', false)
						.parents('.checker').removeClass('disabled')
						.parents('.form-group').removeClass('disabled');

			} else {
				$('#max_width')
						.prop('disabled', true)
						.val(0)
						.parents('.form-group').addClass('disabled');
				$('#max_length')
						.prop('disabled', true)
						.val(0)
						.parents('.form-group').addClass('disabled');
				$('#max_absolute')
						.prop('disabled', true)
						.prop('checked', false)
						.parents('.checker').removeClass('checked').addClass('disabled')
						.parents('.form-group').addClass('disabled');
			}
		});

		$('#calc_by').change(() => {
			let calc = $("#calc_by").val();

			switch (calc) {
				case 'area':
					$(".help-block").html(
                        `<em>${lng_text("item:price:sqft")}</em>`
                    );
					break;
				case 'unit':
					$(".help-block").html(
                        `<em>${lng_text("item:price:unit")}</em>`
                    );
					break;
				case 'top':
				case 'bottom':
				case 'top_bottom':
				case 'perimeter':
					$(".help-block").html(
                        `<em>${lng_text("item:price:inch")}</em>`
                    );
					break;
			
				default:
					$(".help-block").html(
                        `<em></em>`
                    );
					break;
			}
		});
		$('#calc_by').change();

		tinymce.init({
			selector: '#description',
			height : 360,

			plugins: 'paste link image imagetools lists advlist textcolor code',
			image_advtab: true,
			toolbar: 'undo redo | formatselect | bold italic forecolor backcolor | ' 
					+ 'outdent indent | numlist bullist | link image | removeformat code',
			block_formats: 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;',

			images_upload_url: url_upload,
		});

	});
}



/*
	// select2 readonly

	var $S1 = $("select[name=select1]");
    var $S2 = $("select[name=select2]");
  
  $('select').select2({
	  width: '100%'
	});

	function readonly_select(objs, action) {
	  if (action === true)
	    objs.prepend('<div class="disabled-select"></div>');
	  else
	    $(".disabled-select", objs).remove();
	}
	$('#setreadonly').on('click', function() {
	  //readonly_select($(".select2"), true);

	  $S1.attr("readonly", "readonly");
   
		$S2.attr("readonly", "readonly");

	});
	$('#removereadonly').on('click', function() {
	  //readonly_select($(".select2"), false);
    
		$S1.removeAttr('readonly');
    $S2.removeAttr('readonly');

	});
	$("#abc").on('submit', function() {
	  alert($("#abc").serialize());
	});
*/