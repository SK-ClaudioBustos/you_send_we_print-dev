function set_totals(
    $status,
    $id,
    $sale_id,
    $total_sqft,
    $product_subtotal,
    $quantity_discount,
    $subtotal_discount,
    $subtotal_discount_real,
    $price_sqft,
    $price_piece,
    $turnaround_cost,
    $packaging_cost,
    $shipping_cost,
    $shipping_weight,
    $proof_cost,
    $product_total,
    $date_due
) {
    if ($sale_id) {
        $("#sale_id").val($sale_id);
        $("#id").val($id);
    }
    $("#total_sqft")
        .val($total_sqft.toFixed(2))
        .format({ format: "#,###.00", locale: "us" });
    $("#product_subtotal")
        .val($product_subtotal.toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });
    $("#quantity_discount")
        .val($quantity_discount.toFixed(2))
        .format({ format: "- $ #,###.00", locale: "us" });

    if ($subtotal_discount < minimum) {
        $subtotal_discount = minimum;
    }
    show_minimum($subtotal_discount <= minimum);

    $("#subtotal_discount")
        .val($subtotal_discount.toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });

    $("#price_sqft")
        .val($price_sqft.toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });
    $("#price_piece")
        .val($price_piece.toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });

    $("#turnaround_cost")
        .val($turnaround_cost.toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });

    $("#date_due").text(
        $date_due ? moment($date_due).format("dddd, MMMM Do") : "-"
    );

    $("#packaging_cost")
        .val(parseFloat($packaging_cost).toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });
    $("#proof_cost")
        .val(parseFloat($proof_cost).toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });
    $("#shipping_cost")
        .val($shipping_cost.toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });
    $("#shipping_weight").val($shipping_weight.toFixed(2) + " lb");

    if ($status != "data" && $product_total < minimum) {
        $product_total = minimum;
    }

    $("#product_total")
        .val($product_total.toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });
    $("#total_top")
        .text($product_total.toFixed(2))
        .format({ format: "$ #,###.00", locale: "us" });
}

function set_shipping($data) {
    if ($data) {
        if ($data.shipping_change) {
            $("#shipping_type").html("");
            for (var key in $data.shipping_types) {
                $("#shipping_type").append(
                    $("<option></option>").val(key).text(key)
                );
            }
            $("#shipping_type")
                .select2("destroy")
                .val($data.shipping_type)
                .select2(); // for avoiding to fire change
        }
    } else {
        $("#shipping_type").html("");
    }
}

var $ajaxManager;
function calculate(logged) {
    ajax = true;

    var $api = hide_validator();

    if (!logged) {
        // hide prices
        if (!userid) {
            $(
                "#quantity_discount,#price_sqft, #price_piece, #turnaround_cost, #proof_cost"
            ).val("⚈.⚈⚈"); // ●.●●
            $("#product_subtotal, #subtotal_discount,#product_total").val(
                lng_text("product:login_warning_short")
            );
            $("#product_subtotal, #subtotal_discount,#product_total").addClass(
                "link-class"
            );
            $("#product_subtotal, #subtotal_discount,#product_total").on(
                "click",
                () => {
                    window.scrollTo(0, 0);
                    $(".dropdown-login").addClass("open");
                    if (!userid) return false;
                    else return true;
                }
            );
            $("#total_top").text("");
        } else if (!confirmed) {
            $(
                "#quantity_discount,#price_sqft, #price_piece, #turnaround_cost, #proof_cost"
            ).val("⚈.⚈⚈"); // ●.●●
            $("#product_subtotal, #subtotal_discount,#product_total").val(
                lng_text("product:confirm_warning_short")
            );
            $("#total_top").text("");
        } else {
             $(
                "#quantity_discount,#price_sqft, #price_piece, #turnaround_cost, #proof_cost"
            ).val("⚈.⚈⚈"); // ●.●●
            $("#product_subtotal, #subtotal_discount,#product_total").val(
                lng_text("product:activate_warning_short")
            );
            $("#product_subtotal, #subtotal_discount,#product_total").addClass(
                "link-class"
            );
            $("#product_subtotal, #subtotal_discount,#product_total").on(
                "click",
                () => {
                    window.location = '/wholesaler';
                }
            );
            $("#total_top").text("");
        }
    } else {
        if ($api.checkValidity()) {
            $form_data = JSON.stringify($("#product_form").serializeArray());
         //   console.log($form_data);
            $ajaxManager.add({
                type: "POST",
                url: url_info,
                data: { form_data: $form_data },
                dataType: "json",
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('error >>> ' + errorThrown);
                    set_shipping(false);
                    set_totals(
                        "no_data",
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        false
                    );
                },
                success: function ($data) {
                    if ($data !== null && !$data.error) {
                        set_shipping($data);
                        stock = $data.stock;
                      //  console.log($data.product_subtotal+" "+url_info);
                        set_totals(
                            "data",
                            $data.id,
                            $data.sale_id,
                            $data.total_sqft,
                            $data.product_subtotal,
                            -$data.quantity_discount,
                            $data.subtotal_discount,
                            $data.subtotal_discount_real,
                            $data.price_sqft,
                            $data.price_piece,
                            $data.turnaround_cost,
                            $data.packaging_cost,
                            $data.shipping_cost,
                            $data.shipping_weight,
                            $data.proof_cost,
                            $data.product_total,
                            $data.date_due
                        );
                    } else {
                        //console.log('data error >>> ');
                        set_shipping(false);
                        set_totals(
                            "no_data",
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            0,
                            $data.date_due
                        );
                    }
                },
            });
        } else {
            set_shipping(false);
            set_totals("no_data", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        }
        ajax = false;
    }
}

function show_minimum(show) {
    if (show && $("#minimum").is(":hidden")) {
        $("#minimum").slideDown();
    } else if (!show && !$("#minimum").is(":hidden")) {
        $("#minimum").slideUp();
    }
}

function hide_validator() {
    var $form = $("#product_form");
    var $api = $form.data("validator");

    $($api.getConf().container).slideUp(500);
    return $api;
}

// var turnarounds = [{"min":"1","max":"300","days":["2","1"]},{"min":"301","max":"600","days":["3","2","1"]},{"min":"601","max":"1000","days":["3","2"]},{"min":"1001","max":"5000","days":["5","4","3"]},{"min":"5001","max":"n","days":["7"]}];
function turnaround_list(measure_type) {
    let quantity = parseInt($("#quantity").val());
    let range = $("#turnaround").attr("data-range");
    let measure_unit = $(".measure_unit:checked").val();
    let total = 0;
    let width = 0;
    let height = 0;

    if (measure_type == "fixed") {
        // per unit
        total = quantity;
    } else {
        // per sqft
        if (measure_type == "std-ctm" && measure_unit == "std") {
            // hidden fields
            width = parseFloat($("#hwidth").val());
            height = parseFloat($("#hheight").val());
        } else {
            width = parseFloat($("#width").val());
            height = parseFloat($("#height").val());

            width = isNaN(width) ? parseFloat($("#hwidth").val()) : width;
            height = isNaN(height) ? parseFloat($("#hheight").val()) : height;
        }

        if (quantity && width && height) {
            total = ((quantity * width * height) / 144).toFixed(2);
        }
    }

    if (turnarounds) {
        //} && total) {
        for (var turn in turnarounds) {
            if (
                total >= parseFloat(turnarounds[turn]["min"]) &&
                (total <= parseFloat(turnarounds[turn]["max"]) ||
                    parseFloat(turnarounds[turn]["max"] == "n"))
            ) {
                break;
            }
        }

        if (turnarounds[turn]) {
            var new_range =
                turnarounds[turn]["min"] + "-" + turnarounds[turn]["max"];
            if (range == new_range) {
                // do nothing
            } else {
                // load list
                $("#turnaround")
                    .attr("data-range", new_range)
                    .children()
                    .remove();

                var days = turnarounds[turn]["days"];
                for (var day in days) {
                    $option = $("<option></option>")
                        .val(day)
                        .text(days[day] + turn_text);
                    $("#turnaround").append($option);
                }

                $("#turnaround").select2("val", 0);
                var turn_calc = parseInt(
                    $("#turnaround option:selected").text()
                );
                $("#turnaround_calc").val(turn_calc);
                $("#turnaround_days").val(turn_calc);
            }
        } else {
            // do nothing
        }
    } else {
        // disable turnaround select
        $("#turnaround").attr("data-range", "-").children().remove();
    }
}

function set_maximum(item_list_key, item_list) {
    let item_id = parseInt($("#" + item_list_key).val());
    if (item_id && parseInt(item_list[item_id]["max_absolute"])) {
        maximum[item_list_key] = [
            parseInt(item_list[item_id]["max_width"]),
            item_list[item_id]["max_length"] * 12,
        ];
    } else {
        maximum[item_list_key] = [0, 0];
    }

    let max_width = 0;
    let max_length = 0;
    for (let list in maximum) {
        if (
            maximum[list][0] &&
            (maximum[list][0] < max_width || max_width == 0)
        ) {
            max_width = maximum[list][0];
        }
        if (
            maximum[list][1] &&
            (maximum[list][1] < max_length || max_length == 0)
        ) {
            max_length = maximum[list][1];
        }
    }

    $("#width").attr("data-max", max_width + "-" + max_length);
}

function load_cut(item_id) {
    let cuts = item_cuts[String(item_id)] || {};
    let tooltip = "";
    let len = cuts.length;
    for (var cut in cuts) {
        $("<option />").val(cut).text(cuts[cut]["item"]).appendTo("#cutting");

        tooltip += "<h5>" + cuts[cut]["item"] + "</h5>";
        tooltip += "<div>" + cuts[cut]["info"] + "</div>";
    }

    $(".info-trimming .info-text").html(tooltip);
}

function init_product_form(logged, measure_type) {
    var show_popup = function (target, cur_target) {
        if (cur_target != target) {
            var popup_top = $(".product_info").offset().top - 80;
            var info_title = $("div.info-" + target + " .info-title").html();
            var info_text = $("div.info-" + target + " .info-text").html();

            $(".popup_info").height($("#product_form").height() - 50);
            $(".popup_info > h4").html(info_title);
            $(".popup_info > div").html(info_text);

            $("<input />")
                .attr({
                    type: "hidden",
                    id: "popup_target",
                    value: target,
                })
                .appendTo($(".popup_info > div"));

            if ($(document).scrollTop() > popup_top) {
                // scroll to top and show
                $("html, body").animate(
                    {
                        scrollTop: popup_top,
                    },
                    500,
                    "",
                    function () {
                        $(".popup_info")
                            .height($("#product_form").height() - 50)
                            .slideDown(500);
                    }
                );
            } else if (popup_top > 300) {
                // scroll down and show
                var height = $(".accordion").height() - 30;
                $("html, body").animate(
                    {
                        scrollTop: popup_top,
                    },
                    500,
                    "",
                    function () {
                        $(".popup_info").height(height).slideDown(500);
                    }
                );
            } else {
                // show popup
                $(".popup_info")
                    .height($("#product_form").height() - 50)
                    .slideDown(500);
            }
        }
    };

    var hide_popup = function () {
        if ($(".popup_info").is(":visible")) {
            // hide popup
            $(".popup_info").slideUp(500);
        }
    };

    var process_popup = function (target) {
        var cur_target = "";

        if ($(".popup_info").is(":visible")) {
            // check current popup
            cur_target = $("#popup_target").val();

            // hide popup
            $(".popup_info").slideUp(500, "", function () {
                show_popup(target, cur_target);
            });
        } else {
            show_popup(target, cur_target);
        }
    };

    var process_measure_unit = function (status) {
        if (status) {
            // standard
            $("#shape").removeAttr("disabled");
            $("#size").removeAttr("disabled");

            $("#width").attr("disabled", true);
            $("#height").attr("disabled", true);
        } else {
            // custom
            $("#shape").attr("disabled", true);
            $("#size").attr("disabled", true);

            $("#width").removeAttr("disabled");
            $("#height").removeAttr("disabled");
        }
        calculate(logged);
    };

    var process_quantity = function (quantity) {
        //if (quantity && (!$('#cut_quantity').val() || $('#cut_quantity').val() < quantity)) {
        //	$('#cut_quantity').val(quantity);
        //}

        if (use_stock && quantity > stock) {
            if (stock > 0) {
                $("#mult_quantity").hide();
                $("#not_available").slideDown();
            }
            $("#add_to_cart").attr("disabled", true);
        } else {
            $("#not_available").hide();
            if (logged) {
                $("#add_to_cart").removeAttr("disabled");
            }

            if (quantity > 1) {
                $("#mult_quantity").slideDown();
            } else {
                $("#mult_quantity").slideUp();
            }
        }
    };

    var process_shipping = function () {
        var ship_types = { local: 0, default: 1, list: 2, other: 3 };
        var ship_type = $("input:radio[name=shipping_address]:checked").val();

        $(".ship_hidden").each(function (index) {
            if (index == ship_type - 1) {
                if (ship_type != 1) {
                    $(this).slideDown();
                }
            } else {
                $(this).slideUp();
            }
        });

        if (ship_type == ship_types["local"]) {
            $(".shipping_type").slideUp();
        } else {
            $(".shipping_type").slideDown();
        }

        switch (parseInt(ship_type)) {
            case ship_types["local"]:
                $("#zip_code").val("");
                break;

            case ship_types["default"]:
                $("#zip_code").val($("#default_zip").val());
                break;

            case ship_types["list"]:
                $("#zip_code").val(
                    $("#ship_other").val()
                        ? addresses[$("#ship_other").val()]["zip"]
                        : ""
                );
                break;

            case ship_types["other"]:
                $("#zip_code").val($("#ship_zip").val());
                break;
        }

        calculate(true);
    };

    var keep_alive = function () {
        $.ajax({
            type: "POST",
            url: url_update,
            data: {},
            beforeSend: function (xhr) {
                xhr.setRequestHeader("SMVC_AJAX_REQUEST", "1");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                process_expired(jqXHR);
            },
            success: function (data) {},
        });
    };

    const check_shipping = () => {
        if ($('#isBillable').val() == '0') {
                if ($("#bill_country").val() == "44") {
                    $("#same_billing_address").removeClass("hidden");
                } else {
                    $("#same_billing_address").addClass("hidden");
                    $("#local_pickup").click();
                }
            }
    };

    const decodeHTMLEntities = (str) => {
        if (str && typeof str === "string") {
            var element = document.createElement("div");

            // strip script/html tags
            str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gim, "");
            str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gim, "");

            element.innerHTML = str;
            str = element.textContent;
            element.textContent = "";
        }

        return str;
    }


    const variable_cutting = () => {
        if (cuttings != undefined){
            $('#cut-type').empty();
            let selectedType = $("#stickers-cutting-types").select2('data')[0].text;
            selectedType = selectedType.slice(0, selectedType.indexOf(" "));
            $("#cut-type").select2({
                placeholder: lng_text("form:select") + "...",
                allowClear: true,
            });
            for (const [clave,valor] of cuttings){
                if (valor.startsWith(selectedType)) {
                    let option = new Option(decodeHTMLEntities(valor), clave);
                    $("#cut-type").append(option);
                }
            }
            $("#cut-type").val(null).trigger("change");
        }
    };

    $(function () {
        check_shipping();

        $("#cut-type").empty();
        $("#stickers-cutting-types").on("change", () => {
            variable_cutting();
        })

        $(".login-warning a").on("click", function () {
            $(".dropdown-login").addClass("open");
            if (!userid) return false;
            else return true;
        });

        $(".close_info").on("click", function () {
            hide_popup();
            return false;
        });

        $(".info").on("click", function () {
            process_popup($(this).data("target"));
            return false;
        });

        $(document).on("click", function (e) {
            var element = $(e.target);
            if (
                $(".popup_info").is(":visible") &&
                !element.parents(".popup_info").length
            ) {
                // hide popup
                $(".popup_info").slideUp(500);
            }
        });

        $(".select2").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 30,
            //allowClear: true,
        });

        $("#accesory1, #accesory2, #accesory3").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 30,
            allowClear: false,
            closeOnSelect: true,
        });
        $("#accesory1_qty, #accesory2_qty, #accesory3_qty").TouchSpin({
            verticalbuttons: true,
            mousewheel: false,
            min: 1,
            max: 50000,
        });

        $("#accesory1_qty, #accesory2_qty, #accesory3_qty").on("touchspin.on.stopspin", function () {
             calculate(logged);
        });


        $("#accesory1_qty, #accesory2_qty, #accesory3_qty").on("change", function () {
             calculate(logged);
        });
        
     $("#accesory1").on("change", function () {
          if($("#accesory1_qty").val()=="")
             $("#accesory1_qty").val($("#quantity").val());
            console.log($('#select2-accesory1-container').attr('title')); 
         
          if($("#accesory1").val() === null || $('#select2-accesory1-container').attr('title')=="No Accessories Needed")
          { $("#accesory1_qty").val("");
            $("#accesory1_qty").attr("reference","");
            $("#accesory1_qty").attr("readonly","");
          }
          else
          {
            $("#accesory1_qty").attr("reference","accesory1");
            $("#accesory1_qty").removeAttr("readonly","");
          }
     
         
          if ($("#accesory1_qty").val() > 0) {
                $("#acc_quantity1").slideDown();
            } else {
                $("#acc_quantity1").slideUp();
            }
    
        calculate(logged);
   
    });
       
       $("#accesory2").on("change", function () {
         if($("#accesory2_qty").val()=="")
             $("#accesory2_qty").val($("#quantity").val());
        if($("#accesory2").val() === null || $('#select2-accesory2-container').attr('title')=="No Accessories Needed")
          {$("#accesory2_qty").val("");
            $("#accesory2_qty").attr("reference","");
            $("#accesory2_qty").attr("readonly","");
          }
          else
          {
            $("#accesory2_qty").attr("reference","accesory2");
            $("#accesory2_qty").removeAttr("readonly","");
          }
        
        
        if ($("#accesory2_qty").val() > 0) {
                $("#acc_quantity2").slideDown();
            } else {
                $("#acc_quantity2").slideUp();
            }
        calculate(logged);
     
        });
       $("#accesory3").on("change", function () {
         if($("#accesory3_qty").val()=="")
             $("#accesory3_qty").val($("#quantity").val());
        if($("#accesory3").val() === null || $('#select2-accesory3-container').attr('title')=="No Accessories Needed")
          {$("#accesory3_qty").val("");
            $("#accesory3_qty").attr("reference","");
            $("#accesory3_qty").attr("readonly","");

          }
          else
          {
            $("#accesory3_qty").attr("reference","accesory3");
            $("#accesory3_qty").removeAttr("readonly","");
          }   
          
        if ($("#accesory3_qty").val() > 0) {
                $("#acc_quantity3").slideDown();
            } else {
                $("#acc_quantity3").slideUp();
            }    
        calculate(logged);
  
        }); 

        // maximums
        for (let item_list in maximums) {
            set_maximum(item_list, maximums[item_list]);

            $("#" + item_list).on("change", function () {
                set_maximum(item_list, maximums[item_list]);
            });
        }

        turnaround_list(measure_type);
        $("#width, #height, #quantity").on("keyup", function (event) {
            turnaround_list(measure_type);
        });

        $("#turnaround").on("change", function () {
            $("#turnaround_days").val(
                parseInt($("#turnaround option:selected").text())
            );
        });

        $("input#quantity").TouchSpin({
            verticalbuttons: true,
            mousewheel: false,
            min: 1,
            max: 50000,
        });

        $("input#quantity").on("touchspin.on.stopspin", function () {
            turnaround_list(measure_type);
            process_quantity(parseInt($(this).val()));
            calculate(logged);
        });

        $("select#quantity").on("change", function () {
            turnaround_list(measure_type);
            process_quantity(parseInt($(this).val()));
            calculate(logged);
        });
        if ($("select#quantity").length) {
            process_quantity(parseInt($("select#quantity").val()));
        }

        // create an ajaxmanager named cacheQueue
        $ajaxManager = $.manageAjax.create("cacheQueue", {
            queue: true,
        });

        $("#product_form select")
            .not("#shape, #size, #shipping_type, #ship_state, #ship_other")
            .on("change", function (event) {
                calculate(logged);
            });
        $("#product_form input:radio")
            .not(".orientation input, .shipping_address, .measure_unit")
            .on("change", function () {
                calculate(logged);
            });
        $("#product_form input:checkbox").on("change", function () {
            calculate(logged);
        });
        $("#product_form input:text")
            .not(".ship_hidden input, #job_name")
            .on("keyup", function (event) {
                if (event.which == 8 || event.which > 45) {
                    calculate(logged);
                }
            });

        $('[name="sides"]').on("change", function () {
            $("#double_side").slideToggle($(this).val() == 2);
        });

        $(".orientation input, .shipping_address").on("change", function () {
            hide_validator();
        });
        $(".ship_hidden input").on("keyup", function (event) {
            if (event.which == 8 || event.which > 45) {
                hide_validator();
            }
        });

        $(".measure_unit").on("change", function () {
            process_measure_unit($("#measure_unit").is(":checked"));
        });

        $("#quantity").on("keyup", function (event) {
            process_quantity(parseInt($(this).val()));
        });

        if (!$.isEmptyObject(item_cuts)) {
            // load cut for first item
            var item_id = $(".product_list:first").val();
            load_cut(item_id);

            $(".product_list:first").on("change", function () {
                $("#cutting").children().not('[value=""]').remove();
              //  $("#cutting").select2('val', 'All');
                $("#cutting").val(null).change();
             
                load_cut($(this).val());
            });
        }

        // Shipping ----------------------------------------------------------------------

        $(".shipping_address").on("change", function () {
            check_shipping();
            process_shipping();
        });

        $("#bill_zip").on("change", function () {
            $("#default_zip").val($("#bill_zip").val());
        });

        $("#ship_show").on("click", function () {
            $("#ship_default").slideToggle();
            return false;
        });

        $("#ship_other").on("change", function () {
            $("#other_address").html(
                $("#ship_other").val()
                    ? addresses[$("#ship_other").val()]["address"]
                    : ""
            );
            $("#zip_code").val(
                $("#ship_other").val()
                    ? addresses[$("#ship_other").val()]["zip"]
                    : ""
            );

            calculate(true);
        });

        $("#ship_zip").on("keyup", function (event) {
            if (event.which == 8 || event.which > 45) {
                var curr_zip = $("#zip_code").val();
                $("#zip_code").val(
                    $(this).val().length == 5 ? $(this).val() : ""
                );
                if (curr_zip != $("#zip_code").val()) {
                    calculate(true);
                }
            }
        });

        $("#shipping_type").on("change", function (event) {
            calculate(true);
        });

        // Zip initial value --------------------------------------------------------

        if ($("#shipping_address").is(":checked")) {
            // default
            $("#zip_code").val($("#default_zip").val());
        } else if (
            $("#shipping_other").is(":checked") &&
            $("#ship_other").val()
        ) {
            $("#other_address").html(
                addresses[$("#ship_other").val()]["address"]
            );
            $("#zip_code").val(addresses[$("#ship_other").val()]["zip"]);
        }

        // Validator ----------------------------------------------------------------

        var max_err = false;

        $.tools.validator.fn("[not-less]", function (input, value) {
            if (ajax) {
                return true;
            } else {
                var field = input.attr("not-less");

                return input.is(":hidden") ||
                    parseInt(value) >= $("#" + field).val()
                    ? true
                    : {
                          en:
                              "Enter a value equal or larger than " +
                              $("#" + field).attr("title"),
                      };
            }
        });

        $.tools.validator.fn("[reference]", function (input, value) {
            if (ajax) {
                return true;
            } else {
                var reference = input.attr("reference");
                var selected = $("#" + reference).val();
                console.log(reference+selected);
                return input.is(":hidden") || !selected || parseInt(value)
                    ? true
                    : {
                          en:
                              "Enter a quantity for " +
                              $("#" + reference).attr("title"),
                      };
            }
        });

        $.tools.validator.fn("[min]", function (input, value) {
            if (ajax) {
                return true;
            } else {
                var min = input.attr("min");

                return input.is(":hidden") || parseFloat(value) >= min
                    ? true
                    : {
                          en: "Enter a value equal or larger than " + min,
                      };
            }
        });

        $.tools.validator.fn("[data-required]", function (input, value) {
            if (ajax) {
                return true;
            } else {
                var req = input.attr("data-required");

                return input.is(":hidden") || value
                    ? true
                    : {
                          en: req == "required" ? "Field is required" : req,
                      };
            }
        });

        $.tools.validator.fn("[data-max]", function (input, value) {
            max_err = false;

            if (ajax) {
                return true;
            } else {
                var max = input.attr("data-max").split("-");
                var max_width = parseFloat(max[0]);
                var max_height = parseFloat(max[1]); // * 12;

                if (max_width || max_height) {
                    if ($("#measure_unit").is(":checked") || $("#closed")) {
                        width = input.val();
                        height = $("#height").val();
                    }

                    if (
                        (max_width >= width && max_height >= height) ||
                        (max_width >= height && max_height >= width)
                    ) {
                        return true;
                    } else {
                        max_err = input.attr("id");
                        return {
                            en:
                                "Max dimensions for this selection is " +
                                max_width +
                                " x " +
                                max_height +
                                " inches",
                        };
                    }
                } else {
                    return true;
                }
            }
        });

        $.tools.validator.addEffect(
            "wall",
            function (errors, event) {
                //console.log(errors);
                if (!ajax) {
                    var wall = $(this.getConf().container).slideDown(500);
                    wall.find("p").remove();
                    $(".form-control").css('borderColor',"#c2cad8"); //inicializo border input con errores.
                    $(".select2-selection").css('borderColor',"#c2cad8"); //inicializo border input con errores.
                    $.each(errors, function (index, error) {
                        wall.append(
                            '<p><a href="#' +
                                error.input.attr("id") +
                                '">' +
                                (max_err == error.input.attr("id")
                                    ? "Size"
                                    : error.input.attr("title")) +
                                "</a> - " +
                                error.messages[0] +
                                "</p>"
                        );
                   
                     });
                    $.each(errors, function (index, error) {
                     document.getElementById(error.input.attr("id")).style.borderColor = '#B94A48'; //cambio borde de inputs con error
                     $('#'+error.input.attr("id")).next().find('.select2-selection').css('borderColor',"#B94A48"); //cambio borde de inputs con error
                    });
                }
            },
            function (inputs) {
                // nothing when all inputs are valid
            }
        );

        $("#product_form")
            .validator({
                effect: "wall",
                container: ".validation_error",
                errorInputEvent: null,

                // custom form submission logic
            })
            .submit(function (e) {
                // when data is valid
                if (!e.isDefaultPrevented()) {
                    hide_validator();

                    if (
                        !confirm(
                            "Estimated Pickup or Dispatch Time will be " +
                                $("#date_due").text() +
                                $(".date_due").text()
                        )
                    ) {
                        e.preventDefault();
                    }
                }
            });
        /*
    if ($("#size").length > 0) {
      $("#shape").change(function () {
        if ($(this).val() == "s") {
          $(".orientation").slideUp("slow");
        } else {
          $(".orientation").slideDown("slow");
        }
        $size_list = $("#size").empty();
        $.each($sizes[$(this).val()], function ($i, $item) {
          $size_list.append(
            $("<option />")
              .attr("value", $item.id)
              .html($item.width + '" x ' + $item.height + '"')
          );
        });

        $("#size").trigger("change");
      });

      $("#size").on("change", function () {
        $item = $sizes[$("#shape").val()][$(this).prop("selectedIndex")];
        $("#hwidth").val($item["width"]);
        $("#hheight").val($item["height"]);
        calculate(logged);
        turnaround_list(measure_type);
      });
    }*/

        if ($("#size").length > 0) {
            $size_list = $("#size").empty();
            $("#shape").change(function () {
                if ($(this).val() == "s") {
                    $(".orientation").slideUp("slow");
                } else {
                    $(".orientation").slideDown("slow");
                }
                $size_list = $("#size").empty();

                if (
                    $("#shape").val() != "" &&
                    $("#shape").val() != "-1" &&
                    $("#shape").val() != "n"
                ) {
                    $.each($sizes[$(this).val()], function ($i, $item) {
                        $size_list.append(
                            $("<option />")
                                .attr("value", $item.id)
                                .html($item.width + '" x ' + $item.height + '"')
                        );
                    });
                } else {
                    $size_list = $("#size").empty();
                }

                $("#size").trigger("change");
            });

            $("#size").on("change", function () {
                if (
                    $("#shape").val() != "" &&
                    $("#shape").val() != "-1" &&
                    $("#shape").val() != "n"
                ) {
                    $item =
                        $sizes[$("#shape").val()][
                            $(this).prop("selectedIndex")
                        ];
                    if ($item != undefined) {
                        $("#hwidth").val($item["width"]);
                        $("#hheight").val($item["height"]);
                    } else {
                        $("#hwidth").val(0);
                        $("#hheight").val(0);
                    }
                    calculate(logged);
                    turnaround_list(measure_type);
                }
            });
            $("#shape").trigger("change");
        }

        if ($("#size_front").length > 0) {
            $size_list = $("#size_front").empty();
            $("#shape_front").change(function () {
                if ($(this).val() == "s") {
                    $(".orientation").slideUp("slow");
                } else {
                    $(".orientation").slideDown("slow");
                }

                if ($(this).val() == "n") {
                    $("#size_front").prop("disabled", true);
                } else {
                    $("#size_front").prop("disabled", false);
                }

                $size_list = $("#size_front").empty();

                if (
                    $("#shape_front").val() != "" &&
                    $("#shape_front").val() != "-1" &&
                    $("#shape_front").val() != "n"
                ) {
                    $.each($sizes[$(this).val()], function ($i, $item) {
                        $size_list.append(
                            $("<option />")
                                .attr("value", $item.id)
                                .html($item.width + '" x ' + $item.height + '"')
                        );
                    });
                } else {
                    $size_list = $("#size_front").empty();
                }

                $("#size_front").trigger("change");
            });

            $("#size_front").on("change", function () {
                if (
                    $("#shape_front").val() != "" &&
                    $("#shape_front").val() != "-1" &&
                    $("#shape_front").val() != "n"
                ) {
                    $item =
                        $sizes[$("#shape_front").val()][
                            $(this).prop("selectedIndex")
                        ];
                    if ($item != undefined) {
                        $("#hwidth").val($item["width"]);
                        $("#hheight").val($item["height"]);
                    } else {
                        $("#hwidth").val(0);
                        $("#hheight").val(0);
                    }
                    calculate(logged);
                    turnaround_list(measure_type);
                }
            });
            //$("#shape_front").trigger("change");
        }

        if ($("#size_back").length > 0) {
            $size_list = $("#size_back").empty();
            $("#shape_back").change(function () {
                if ($(this).val() == "s") {
                    $(".orientation").slideUp("slow");
                } else {
                    $(".orientation").slideDown("slow");
                }

                if ($(this).val() == "n") {
                    $("#size_back").prop("disabled", true);
                } else {
                    $("#size_back").prop("disabled", false);
                }

                $size_list = $("#size_back").empty();
                if (
                    $("#shape_back").val() != "" &&
                    $("#shape_back").val() != "-1" &&
                    $("#shape_back").val() != "n"
                ) {
                    $.each($sizes[$(this).val()], function ($i, $item) {
                        $size_list.append(
                            $("<option />")
                                .attr("value", $item.id)
                                .html($item.width + '" x ' + $item.height + '"')
                        );
                    });
                } else {
                    $size_list = $("#size_back").empty();
                }

                $("#size_back").trigger("change");
            });

            $("#size_back").on("change", function () {
                if (
                    $("#shape_back").val() != "" &&
                    $("#shape_back").val() != "-1" &&
                    $("#shape_back").val() != "n"
                ) {
                    $item =
                        $sizes[$("#shape_back").val()][
                            $(this).prop("selectedIndex")
                        ];
                    if ($item != undefined) {
                        $("#hwidth").val($item["width"]);
                        $("#hheight").val($item["height"]);
                    } else {
                        $("#hwidth").val(0);
                        $("#hheight").val(0);
                    }
                    calculate(logged);
                    turnaround_list(measure_type);
                }
            });
            //$("#shape_front").trigger("change");
        }

        calculate(logged);
        turnaround_list(measure_type);

        // call server every 5 min for keeping session alive
        setInterval(keep_alive, 1000 * 60 * 5);
    });
}

function init_home(slide_speed) {
    $(function () {
        // initialize the slider based on the Slider's ID attribute
        jQuery("#rev_slider_1").revolution({
            // options are 'auto', 'fullwidth' or 'fullscreen'
            sliderLayout: "auto",

            // [DESKTOP, LAPTOP, TABLET, SMARTPHONE]
            responsiveLevels: [
                7047, 5738, 5114, 4162, 3200, 2200, 1804, 1380, 1024, 778, 480,
            ],
            gridwidth: [
                7047, 5738, 5114, 4162, 3200, 2200, 1804, 1380, 1024, 778, 480,
            ],
            gridheight: [
                2050, 1669, 1488, 1211, 931, 640, 525, 402, 298, 227, 140,
            ],

            delay: slide_speed,

            // basic navigation arrows and bullets
            navigation: {
                arrows: {
                    enable: false,
                    style: "uranus",
                    hide_onleave: false,
                },

                bullets: {
                    enable: true,
                    style: "persephone",
                    hide_onleave: false,
                    h_align: "right",
                    v_align: "bottom",
                    h_offset: 24,
                    v_offset: 10,
                    space: 5,
                },
            },
        });

        $(".slide-dummy").hide();

        $(".mix-grid").mixitup();

        $(".login_home").on("click", function () {
            $(".dropdown-login").addClass("open");
            if (!userid) return false;
            else return true;
        });

        $(".signup-form").on("submit", function (e) {
            return signup();
        });

        $(".signup-form input").keyup(function (event) {
            $(".signup-form input")
                .parents(".form-group")
                .removeClass("has-error");
        });
    });
}

function init_products() {
    $(function () {
        if ($(window).width() < 500 && $(".span_title").length < 3) {
            $(".span_title").css("min-height", "30px");
        }

        $(window).on('resize', () => {
        	if ($(window).width() < 500 && $(".span_title").length < 3) {
                $(".span_title").css("min-height", "30px");
            }
        });
    })
}