function init_multiple() {
	var _grid;

	var options = {
        colModel: [
            {
                name: "tools",
                label: " ",
                width: 30,
                fixed: true,
                align: "center",
                sortable: false,
                classes: "tools",
                formatter: render_tool_act,
            },
            {
                name: "active",
                index: "active",
                label: lang["form:active"],
                width: 30,
                hidden: true,
            },

            {
                name: "title",
                index: "title",
                label: lng_text("itemlist:title"),
                width: 320,
                formatter: render_link,
            },
            {
                name: "item_list_key",
                index: "item_list_key",
                label: lng_text("itemlist:item_list_key"),
                width: 240,
                hidden: true,
            },
            {
                name: "calc_by",
                index: "calc_by",
                label: lng_text("itemlist:calc_by"),
                width: 160,
            },
            {
                name: "description",
                index: "title",
                label: lng_text("itemlist:description"),
                width: 160,
            },
            {
                name: "has_cut",
                index: "has_cut",
                label: lng_text("itemlist:has_cut"),
                width: 120,
                align: "center",
                sortable: false,
                formatter: render_check,
            },
            {
                name: "has_max",
                index: "has_max",
                label: lng_text("itemlist:has_max"),
                width: 120,
                align: "center",
                sortable: false,
                formatter: render_check,
            },
        ],
        sortname: "title",
        sortorder: "ASC",
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
        tinymce_init(".tinymce2", 260);
		$('.select2').select2({
			placeholder: lng_text('form:select') + '...',
			minimumResultsForSearch: 20,
			allowClear: false,
		});
	});
}
