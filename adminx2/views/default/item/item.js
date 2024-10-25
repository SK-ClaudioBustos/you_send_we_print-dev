function init_multiple() {
	
	$(function() {
		$('#item_list').change(function() {
			$filter = "";
			if ($val = $('#item_list').val()) {
				$filter = "`item_list_key` = '" + $val + "'";
			}
			$page_args = JSON.stringify({ item_list_key: $val });
			get_rows(1);
		});
	});

}

function init_single(tinymce_folder, lang_iso) {

	$(function() {
		tiny_mce_init(tinymce_folder, lang_iso, false, 618, 280);
		
		$('#item_list_key').on('change', function() {
			if (lists[$(this).val()] == 'variable') {
				$('label[for="calc_by"]').addClass('required');
				$('#calc_by')
						.prop('disabled', false)
						.val('');
			} else {
				$('label[for="calc_by"]').removeClass('required');
				$('#calc_by')
						.prop('disabled', true)
						.val(lists[$(this).val()]);
			}
		});
	
		$('ul.spp_tabs').tabs('div.spp_panes > div');

	});
	
}
