function init_multiple() {
	$(function() {
		var options = {
				colModel: [
						{ name: 'tools', label: ' ', width: 56, fixed: true, align: 'center', sortable: false, classes: 'tools', formatter: render_tool },
	
						{ name: 'title', index: 'title', label: lng_text('section:title'), width: 200, formatter: render_link },
						{ name: 'lang_iso', index: 'lang_iso', label: lng_text('section:lang_iso'), width:80, fixed: true },
						{ name: 'document_key', index: 'document_key', label: lng_text('section:document_key'), width: 160 },
			   		],
				sortname: 'title',
			   	sortorder: 'asc'

			};

		var grid = init_grid(options);
		init_grid_search(grid);
	});
}

function init_single() {

	function tinymce_init(id, height) {
        tinymce.init({
            selector: id,
            height: height,

            plugins: "paste link image imagetools lists advlist code",
            image_advtab: true,
            toolbar:
                "undo redo | formatselect | bold italic forecolor backcolor | " +
                "outdent indent | numlist bullist | link image | removeformat code",
            block_formats:
                "Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;",

            images_upload_url: url_upload,
        });
    }

	$(function() {
		$('.select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: true,
			language: 'es',
		});
	});

	tinymce_init(".tallmce", 500);
}
