function init_multiple(product_id) {
    var _grid;

    var options = {
        colModel: [
            {
                name: "tools",
                label: " ",
                width: 84,
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
                name: "product_code",
                index: "product_code",
                label: lng_text("product:product_code"),
                width: 120,
                formatter: render_main,
            },
            {
                name: "title",
                index: "title",
                label: lng_text("product:product"),
                width: 440,
                formatter: render_link_act,
            },
            {
                name: "product_type",
                index: "product_type",
                label: lng_text("product:product_type"),
                width: 150,
                formatter: render_main,
            },
            {
                name: "measure_type",
                index: "measure_type",
                label: lng_text("product:measure_type"),
                width: 150,
                formatter: render_main,
            },
            {
                name: "standard_type",
                index: "standard_type",
                label: lng_text("product:standard_type"),
                width: 150,
                formatter: render_main,
            },
            {
                name: "price_date",
                index: "price_date",
                label: lng_text("product:date"),
                width: 90,
            },
            {
                name: "parent_id",
                index: "parent_id",
                label: lng_text("product:parent_group"),
                width: 360,
                formatter: render_main,
            },
        ],
        sortname: "title",
        sortorder: "ASC",
        postData: { product_id: product_id },
    };

    var load_grid = function () {
        let product_id = $("#product_list").val();
        product_id = product_id.split("-")[0];

        let postData = { product_id: product_id };
        console.log(postData);

		if (product_id) {
			_grid.jqGrid("setGridParam", {
                postData: postData,
                sortname: "product_type",
                sortorder: "ASC",
            });
		} else {
			_grid.jqGrid("setGridParam", {
                postData: postData,
                sortname: "title",
                sortorder: "ASC",
            });
		}
        _grid.trigger("reloadGrid", [{ page: 1 }]);

        var href = "/?" + "product_id=" + product_id;
        $("#export_xls").attr(
            "href",
            $("#export_xls").attr("data-href") + href
        );
        $("#export_xlsx").attr(
            "href",
            $("#export_xlsx").attr("data-href") + href
        );
    };

    $(function () {
        $("#product_list").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 200,
            allowClear: true,
        });
        $("#product_list").on("change", function () {
            load_grid();
        });

        _grid = init_grid(options);
        init_grid_search(_grid);
        set_grid_height(_grid);

        $(window).on("resize", function () {
            set_grid_height(_grid);
        });
    });
}

function init_single(children, sizes) {
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

    if (sizes) {
        function set_values(
            $format,
            $width,
            $height,
            $price_a,
            $price_b,
            $price_c,
            $price_d,
            $provider_price,
            $provider_weight
        ) {
            $("#format").val($format);
            $("#size_width").val($width);
            $("#size_height").val($height);

            $("#price_a").val($price_a);
            $("#price_b").val($price_b);
            $("#price_c").val($price_c);
            $("#price_d").val($price_d);

            $("#provider_price").val($provider_price);
            $("#provider_weight").val($provider_weight);

            $(".select2:visible").val($format);
            $(".select2:visible").trigger("change");
        }

        function get_values(
            size_sel,
            $format,
            $width,
            $height,
            $price_a,
            $price_b,
            $price_c,
            $price_d,
            $provider_price,
            $provider_weight
        ) {
            $sizes[size_sel].format = $format;
            $sizes[size_sel].width = parseFloat($width).toFixed(2);
            $sizes[size_sel].height = parseFloat($height).toFixed(2);
console.log(parseFloat($width).toFixed(2));
            $sizes[size_sel].price_a = parseFloat($price_a).toFixed(2);
            $sizes[size_sel].price_b = parseFloat($price_b).toFixed(2);
            $sizes[size_sel].price_c = parseFloat($price_c).toFixed(2);
            $sizes[size_sel].price_d = parseFloat($price_d).toFixed(2);

            $sizes[size_sel].provider_price =
                parseFloat($provider_price).toFixed(2);
            $sizes[size_sel].provider_weight =
                parseFloat($provider_weight).toFixed(2);
        }

        function provider_sizes() {
            let measure_type = $("#measure_type").val();
            let provider_id = $("#provider_id").val();
            let hidden = !provider_id || measure_type != "standard";

            $("#price_a").parent().toggleClass("hidden", hidden);
            $("#provider_price").parent().toggleClass("hidden", hidden);
            $("#provider_weight").parent().toggleClass("hidden", hidden);
        }

        function size_update() {
            // TODO: validate fields

            let size_new = false;
            let size_sel = $("#sizes").val();

            if (!size_sel) {
                size_new = true;
                size_sel = -Math.floor(Math.random() * 100000);
                $sizes[size_sel] = {};
            }

            get_values(
                size_sel,

                $("#format").val(),
                $("#size_width").val(),
                $("#size_height").val(),

                $("#price_a").val(),
                $("#price_b").val(),
                //$('#provider_price').val(),
                $("#price_c").val(),
                $("#price_d").val(),

                $("#provider_price").val(),
                $("#provider_weight").val()
            );

            $sizes_mod[size_sel] = $sizes[size_sel];
            $("#sizes_str").val(JSON.stringify($sizes_mod));
            let fixed = $("#standard_type").val() == "fixed";

            $text =
                $sizes[size_sel].format.toUpperCase() +
                "&nbsp;&nbsp;|&nbsp;&nbsp;" +
                ($sizes[size_sel].width < 10 ? "&nbsp;&nbsp;" : "") +
                $sizes[size_sel].width +
                " x " +
                ($sizes[size_sel].height < 10 ? "&nbsp;&nbsp;" : "") +
                $sizes[size_sel].height +
                '"' +
                (fixed
                    ? "&nbsp;&nbsp;|&nbsp;&nbsp;" +
                      ($sizes[size_sel].price_a < 100 ? "&nbsp;&nbsp;" : "") +
                      $sizes[size_sel].price_a
                    : "");

            if (size_new) {
                $("#sizes").append(
                    $("<option />").attr("value", size_sel).html($text)
                );
                $("#sizes").trigger("change");
            } else {
                $("#sizes option:selected").html($text);
            }
        }

        function size_delete() {
            if (confirm($delete_msg)) {
                let size_sel = $("#sizes").val();

                if (size_sel > 0) {
                    $sizes_mod[size_sel] = {};
                    $sizes_mod[size_sel].deleted = true;
                } else {
                    delete $sizes[size_sel];
                    delete $sizes_mod[size_sel];
                }

                $("#sizes_str").val(JSON.stringify($sizes_mod));

                $("#sizes option:selected").remove();
                $("#sizes").val("").trigger("change");
            }
        }

        function size_change() {
            if ((size_sel = $("#sizes").val())) {
                // edit
                set_values(
                    $sizes[size_sel].format,
                    $sizes[size_sel].width,
                    $sizes[size_sel].height,

                    $sizes[size_sel].price_a,
                    $sizes[size_sel].price_b,
                    $sizes[size_sel].price_c,
                    $sizes[size_sel].price_d,

                    $sizes[size_sel].provider_price,
                    $sizes[size_sel].provider_weight
                );
                $("#delete").attr("disabled", false);
            } else {
                // new
                set_values("s", "", "", "", "", "", "", "");
                $("#delete").attr("disabled", true);
            }
        }
    }

    $(function () {
        $(".select2").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 20,
            allowClear: true,
        });

        $("#group_id").on("change", function () {
            $("#group_changed").val(1);
        });

        $("#standard_type").on("change", function () {
            $('#discount_by').text('Discounts calc by: ' + $("#standard_type").val());
        });
        $("#standard_type").change();

        $(".tabs-project").on(
            "shown.bs.tab",
            'a[data-toggle="tab"]',
            function (e) {
                // hide gantt tooltip
                $(".gantt_tooltip").css("left", -1000);

                _cur_tab = $(e.target).attr("href");
                let item = _cur_tab.replace("#prj_", "");
                if (!_done[_cur_tab]) {
                    _done[_cur_tab] = true;
                    if ((_grid[_cur_tab] = project_grid(item))) {
                        //project_data(item);
                    }
                }

                if (_grid[_cur_tab]) {
                    project_data(item);
                    let width = $(_cur_tab).width();

                    _grid[_cur_tab].jqGrid("setGridWidth", width);
                    _grid[_cur_tab].jqGrid("setGridHeight", _main_height - 30);
                }
            }
        );

        tinymce_init(".tinymce", 458);
        tinymce_init(".tinymce2", 360);

        $("#use_stock").on("change", function () {
            $("#stock_min").attr("disabled", function () {
                $(this).val(0);
                return !$("#use_stock").is(":checked");
            });
        });

        if (children) {
            $(".sortable").sortable({
                axis: "y",
                containment: "#sort_container",
                placeholder: "sort_placeholder",
                update: function () {
                    $("#order_changed").val("1");
                    var order = $(".sortable").sortable("toArray");
                    $("#order").val(order.join("|").replace(/item_/gi, ""));
                },
            });
        }

        if (sizes) {
            $("#provider_id, #measure_type").on("change", function () {
                provider_sizes();
            });

            $("#sizes").on("change", function () {
                size_change();
            });

            $("#delete").on("click", function () {
                size_delete();
            });

            $("#update").on("click", function () {
                size_update();
            });
        }

        // form

        var list_status = function (list, disabled) {
            $(list).prop("disabled", disabled);
            //$(list).parents('.form-group').toggleClass('disabled', disabled);
            if (disabled) {
                if ($(list).attr("multiple")) {
                    $(list).select2("val", []);
                } else {
                    $(list).select2("val", null);
                }
            }
        };

        if (
            $.inArray($("#product_type").val(), [
                "product-single",
                "product-multiple",
            ]) != -1
        ) {
            let form = JSON.parse($("#product_form").val()) || [];
            console.log(form);

            let len = form.length;
            for (let i = 0; i < len; i++) {
                let name = "#form_" + form[i]["field"];

                $(name).attr("checked", true).parent().addClass("checked");

                if ((option = form[i]["option"])) {
                    // list
                    $(name + "_list").select2("val", option);
                    list_status(name + "_list", false);
                } else if ((options = form[i]["options"])) {
                    // multiple
                    $(name + "_list").select2("val", options);
                    list_status(name + "_list", false);
                }
            }

            $(".check_list").on("click", function () {
                if ((id = $(this).attr("id"))) {
                    list_status("#" + id + "_list", !$(this).is(":checked"));
                    console.log($(this).attr("id"));
                    console.log($(this).is(":checked"));
                }
            });
        }
    });
}
