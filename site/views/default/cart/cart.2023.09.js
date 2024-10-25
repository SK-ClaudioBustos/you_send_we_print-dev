function init_remove($ajaxManager) {
    $(".remove").on("click", function () {
        $parent = $(this).parents("tr");
        if (confirm(lng_text("cart:remove_msg"))) {
            // TODO: change to cool dialogs
            $ajaxManager.add({
                type: "POST",
                url: $(this).attr("href") + "1",
                data: { id: $(this).data("id") },
                dataType: "json",
                success: function (data) {
                    if (data.result) {
                        $parent.slideUp("slow", function () {
                            $parent.prev().remove();
                            $parent.remove();
                        });
                        $(".menu_cart span, .foot_cart span").html(
                            data["items"]
                        );

                        if (data["items"] == "0") {
                            var empty = $("<td />")
                                .addClass("empty")
                                .text(lng_text("cart:empty_cart"));
                            $("<tr />")
                                .append(empty)
                                .appendTo(".table-cart tbody");

                            $(".cart_subtot").slideUp();
                            $("#checkout")
                                .addClass("disabled")
                                .attr("href", "javascript:;");

                            // if already at checkout
                            $(
                                "#subtotal, #taxes, #ship_total, #sale_total"
                            ).val("");
                            $("#place_order").prop("disabled", true);
                            // TODO: should it navigate back to cart?
                        } else {
                            // update totals
                            $("#subtotal")
                                .val(data["subtotal"])
                                .format({ format: "$ #,###.00", locale: "us" });
                            $("#taxes")
                                .val(data["taxes"])
                                .format({ format: "$ #,###.00", locale: "us" });
                            $("#ship_total")
                                .val(data["shipping"])
                                .format({ format: "$ #,###.00", locale: "us" });
                            $("#sale_total")
                                .val(data["total"])
                                .format({ format: "$ #,###.00", locale: "us" });
                        }
                    } else {
                    }
                },
            });
        }
        return false;
    });
}

function init_work_order() {
    $(".qr_code").each(function (index) {
        var href = $(this).data("href");

        $(this).qrcode({
            text: href,
            size: 120,
        });
    });

    $(function () {
        $(".print_page").on("click", function () {
            window.print();
        });
    });
}

function init_upload(sale_id, sale_product_id, quantity, upload_session) {
    let _onSelectOnce = true;
    let _partial = quantity;
    let _uploading = false;

    function submit_form($target) {
        let submit = true;
        if (_uploading) {
            submit = confirm(lng_text("product:upload_stop"));
        }

        if (submit) {
            // verify quantities
            $sum_quantity = 0;
            $zero_value = false;
            $(".quantity").each(function () {
                $sum_quantity += parseInt($(this).val());
                $zero_value = $zero_value || parseInt($(this).val()) == 0;
            });
            if (
                ($(".quantity").length && $sum_quantity != quantity) ||
                $zero_value
            ) {
                $(".validation_error").slideDown(500).delay(10000).slideUp();
            } else {
                $("#target").val($target);
                $("#upload_form").submit();
            }
        }
    }

    function get_file_size(file) {
        // Get the size of the file
        var fileSize = Math.round(file.size / 1024);
        var suffix = "KB";
        if (fileSize > 1000) {
            fileSize = Math.round(fileSize / 1000);
            suffix = "MB";
        }
        var fileSizeParts = fileSize.toString().split(".");
        fileSize = fileSizeParts[0];
        if (fileSizeParts.length > 1) {
            fileSize += "." + fileSizeParts[1].substr(0, 2);
        }
        fileSize += " " + suffix;

        return fileSize;
    }

    function get_file_name(file) {
        // Truncate the filename if it's too long
        var fileName = file.name;
        if (fileName.length > 40) {
            fileName = fileName.substr(0, 38) + "&hellip;";
        }

        return fileName;
    }

    $(function () {
        // Get the template HTML and remove it from the document
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(document.body, {
            // Make the whole body a dropzone
            url: baseUrl + "/ajax_upload",
            autoQueue: false,
            enqueueForUpload: false,
            parallelUploads: 20,
            maxFilesize: 1000,
            createImageThumbnails: false,
            previewTemplate: previewTemplate,
            previewsContainer: "#upload_inner",
            clickable: ".fileinput-button",
            acceptedFiles: ".jpg,.jpeg,.pdf,.png,.ai",
            paramName: "file_data",
            params: {
                action: "upload",
                upload_session: upload_session,
                sale_id: sale_id,
                sale_product_id: sale_product_id,
            },

            init: function () {
                var _this = this;
                _this
                    .on("addedfile", function (file) {
                        $("#agree").prop("disabled", true);
                        //$('.fileinput-button').toggleClass('disabled', true);
                        if (file["name"].indexOf("'") != -1) {
                            alert(lng_text("product:upload_error"));
                            _this.removeFile(file);
                        } else {
                            _this.processFile(file);
                            _uploading = true;
                            //window.onbeforeunload = callback / null;
                        }
                    })
                    .on("uploadprogress", function (file, progress, bytesSent) {
                        if (progress >= 99) {
                            file.previewElement.querySelector(
                                ".processing"
                            ).style.display = "block";
                        }
                    })
                    .on("success", function (file, response) {
                        _this.removeFile(file);
                        var item = $("<div />")
                            .addClass("uploadify-queue-item ")
                            .append(response);
                        item.find(".quantity").val(_partial);
                        _partial = 0;
                        item.appendTo("#existing");
                    })
                    .on("error", function (file) {
                        file.previewElement.querySelector(
                            ".fileSize"
                        ).style.display = "none";
                        file.previewElement.querySelector(
                            ".uploadify-progress"
                        ).style.display = "none";
                    })
                    .on("queuecomplete", function () {
                        //$('.fileinput-button').toggleClass('disabled', false);
                        _uploading = false;
                    });
            },
        });

        $("#agree").change(function () {
            var status = $("#agree").is(":checked");
            $(".fileinput-button").toggleClass("disabled", !status);
            if (status) {
                myDropzone.enable();
            } else {
                myDropzone.disable();
            }
        });

        $(".upload_type a.more").click(function () {
            $(this).parents(".upload_type").find("p").slideToggle("slow");
            return false;
        });

        $(".remove").live("click", function () {
            $parent = $(this).parents(".uploadify-queue-item");
            if (confirm(lng_text("product:upload_conf_remove"))) {
                $.ajax({
                    type: "POST",
                    url: $(this).attr("href"),
                    data: { image_id: $(this).data("id") },
                    success: function ($data) {
                        if ($data != "error") {
                            $parent.slideUp(500, function () {
                                $(this).remove();
                            });
                        } else {
                        }
                    },
                });
            }

            // TODO: si se remueven todos, deshabilitar el Continue
            return false;
        });

        $("#done").click(function () {
            submit_form("continue");
        });

        $(".upload_cancel").click(function () {
            $(".uploadify-button").addClass("other");
            $("#uploadify").uploadify("cancel", "*");
            $(".upload_cancel, .upload_msg").fadeOut("slow");
            $(".upload_msg").hide();
            _onSelectOnce = true;
            return false;
        });

        // existing images
        if ($(".uploadify-queue-item").length) {
            $(".fileinput-button").html(
                lng_text("product:upload_more") +
                    ' <i class="fa fa-arrow-circle-up"></i>'
            );
        }

        /*

		$('#uploadify').uploadify({
			'formData'		: { 'action' : 'upload', 'upload_session': $upload_session, 'sale_product_id': $sale_product_id, 'sale_id': $sale_id },
			'swf'		    : $scrp_root + '/uploadify_3.1/uploadify.swf',
			'uploader'		: $ctrl_root + '/ajax_upload',
			'width'			: 184,
			'height'		: 38,
			'fileObjName'	: 'file_data',
			'fileSizeLimit'	: '500MB',
			'queueID'       : 'upload_inner',
			'auto'          : true,
			'multi'       	: true,
			'fileTypeDesc'	: $filter_text,
			'fileTypeExts'	: $filter,
			'buttonText'	: '',
			'removeCompleted'	: false,
			'overrideEvents' : ['onSelect'],

			'onSWFReady'	: function() {
				if (!$('#agree').is(':checked')) {
					$('#uploadify').uploadify('disable', true);
				}
			},

			'onSelect'		: function(file) {
				if (_onSelectOnce) {
					_onSelectOnce = false;
					$('#agree').attr('disabled', 'disabled');
					$('#uploadify').uploadify('disable', true);
					$('.upload_cancel, .upload_msg').fadeIn();
				}
				// Add the file item to the queue
				$('#upload_inner').append('<div id="' + file.id + '" class="uploadify-queue-item"><div class="file-item"><div class="cancel"><a href="javascript:jQuery(\'#uploadify\').uploadify(\'cancel\', \'' + file.id + '\')">X</a></div><span class="fileName">' + get_file_name(file) + '</span><span class="fileSize">(' + get_file_size(file) + ')</span> <span class="data"></span><div class="uploadify-progress"><div class="uploadify-progress-bar"><!--Progress Bar--></div></div></div></div>');

			},

			'onUploadProgress'	: function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
				if (bytesUploaded == bytesTotal) {
					$container = '#' + file.id + ' .file-item';
					$($container + '.processing').remove();
					$($container).append('<span class="processing">' + $processing + '</span>');
				}
			},

			'onUploadSuccess'	: function(file, data, response) {
				$container = '#' + file.id;
				$($container + ' .file-item').slideUp('fast', function() { $(this).remove(); });
				$($container).append(data);
				$($container + ' .uploadedItem').slideDown('slow');
				$($container + ' .quantity').val(_partial);
				_partial = 0;

				$img = $container + ' .uploadedImage img';
				// TODO: ver en BlixPhoto
				$($img).load(function() {
					$($img).css('marginTop', (130 - $($img).height()) / 2);
				});
				return false;
			},

			'onQueueComplete'	: function(queueData) {
				$('.upload_cancel, .upload_msg').hide();
				$('#done').removeAttr('disabled');
				$('#done').addClass('active');
				_onSelectOnce = true;
				$more = true;
				$('#uploadify').uploadify('disable', false);
//				$('.uploadify-button').addClass('other');
			}
		});
*/
    });
}

function init_cart() {
    var $ajaxManager;

    // create an ajaxmanager named cacheQueue
    $ajaxManager = $.manageAjax.create("cacheQueue", {
        queue: true,
    });

    $(function () {
        $(".select2").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 20,
            allowClear: false,
        });

        init_remove($ajaxManager);
    });
}

function init_checkout(rates_url, taxes_url) {
    render_paypal();

    var _last_zip = 0;
    var _last_zip_tax = false;
    var _submitted = 0;
    var $ajaxManager;

    var hide_validator = function () {
        var $form = $("#checkout_form");
        var $api = $form.data("validator");

        _submitted = 0;

        $($api.getConf().container).slideUp(500);
        return $api;
    };

    var get_taxes = function (key, zip_val, taxes_url) {
        // PHP if(!preg_match('/^\d{5}$/', $zip)) {}
        // JS  if(!/^\d{5}$/.test(sZip) {}

        if (key == 8 || key > 45 || key === false) {
            var zip_code = String(parseInt(zip_val));
            if (!/^\d{5}$/.test(zip_code)) {
                //zip_code.length == 5) {
                zip_code = false;
            }

            if (!zip_code && !_last_zip_tax) {
                // no previous zip and no new one, do nothing
            } else {
                // send a valid zip or an empty one

                $("#loader").addClass("loader");

                _last_zip_tax = zip_code;
                var form_data = JSON.stringify(
                    $("#checkout_form").serializeArray()
                );

                // get taxes
                $ajaxManager.add({
                    type: "POST",
                    url: taxes_url,
                    dataType: "json",
                    data: {
                        form_data: form_data,
                        zip_code: zip_code ? zip_code : "empty",
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#loader").removeClass("loader");
                    },
                    success: function (data) {
                        if (data["error"]) {
                            alert(data["error"]); // TODO: show error nicely
                        } else {
                            $("#taxes")
                                .val(data["taxes"])
                                .format({ format: "$ #,###.00", locale: "us" });
                            $("#sale_total")
                                .val(data["total"])
                                .format({ format: "$ #,###.00", locale: "us" });
                        }
                        $("#loader").removeClass("loader");
                    },
                });
            }
        } else {
            // do nothing
        }
    };

    var get_rates = function (key, zip_val, rates_url) {
        if (key == 8 || key > 45 || key === false) {
            var zip_code = String(parseInt(zip_val));
            if (!/^\d{5}$/.test(zip_code)) {
                // invalid zip
                zip_code = false;
            }

            if (!zip_code && !_last_zip) {
                // no previous zip and no new one, do nothing
            } else {
                $("#ship_loader").addClass("loader");

                if (!_last_zip || zip_code != _last_zip) {
                    // new zip
                    _last_zip = zip_code;

                    if (zip_code) {
                        // valid zip

                        var form_data = JSON.stringify(
                            $("#checkout_form").serializeArray()
                        );

                        // get ship rates
                        $ajaxManager.add({
                            type: "POST",
                            url: rates_url,
                            dataType: "json",
                            data: {
                                zip_code: zip_code,
                                form_data: form_data,
                                //rates: _rates
                            },

                            success: function (data) {
                                if (data.error) {
                                    alert(data.error); // TODO: display error nicely
                                } else {
                                    _rates = data.rates;
                                    sel_rate = load_rates();
                                }
                            },
                        });
                    } else {
                        // invalid or blank, clear ship rates
                        $("#shipping_type").empty().val(null);
                        $("#shipping_type")
                            .parents(".form-group")
                            .addClass("disabled");
                        $("#shipping_type").prop("disabled", true);

                        set_rate(rates_url);
                    }
                }
            }
        }
    };

    var load_rates = function () {
        // get the current rate
        var sel_rate = $("#shipping_type").val();
        $("#shipping_type").empty().val(null);

        if ($.isEmptyObject(_rates)) {
            $("#shipping_type").parents(".form-group").addClass("disabled");
            $("#shipping_type").prop("disabled", true);
        } else {
            // load rates to select
            for (var key in _rates) {
                $("#shipping_type").append($("<option />").val(key).text(key));
            }

            // set the selected rate
            if (sel_rate) {
                if (_rates[sel_rate]) {
                    $("#shipping_type").val(sel_rate);
                } else {
                    //$('#shipping_type option:first').prop('selected', true).trigger('change');
                    sel_rate = $("#shipping_type").val();
                    $("#shipping_type").val(sel_rate).trigger("change");
                }
            } else {
                //$('#shipping_type option:first').prop('selected', true).trigger('change');
                sel_rate = $("#shipping_type").val();
                $("#shipping_type").val(sel_rate).trigger("change");
            }

            $("#shipping_type").parents(".form-group").removeClass("disabled");
            $("#shipping_type").prop("disabled", false);
        }

        return sel_rate;
    };

    var set_rate = function (rates_url) {
        $("#ship_loader").addClass("loader");

        if ((sel_rate = $("#shipping_type").val())) {
            $("#ship_cost").val("$ " + _rates[sel_rate]);
            $("#ship_total").val("$ " + _rates[sel_rate]);
            $("#shipping_cost").val(_rates[sel_rate]);
        } else {
            $("#ship_cost").val("$ 0.00");
            $("#ship_total").val("$ 0.00");
            $("#shipping_cost").val("0.00");
        }

        // update sale total on server
        var form_data = JSON.stringify($("#checkout_form").serializeArray());
        //console.log(form_data);

        $ajaxManager.add({
            type: "POST",
            url: rates_url,
            dataType: "json",
            data: {
                sel_rate: sel_rate,
                sel_cost: _rates ? _rates[sel_rate] : 0,
                form_data: form_data,
            },

            success: function (data) {
                if (data.error) {
                    alert(data["error"]);
                } else {
                    $("#sale_total")
                        .val(data["total"])
                        .format({ format: "$ #,###.00", locale: "us" });
                }

                $("#ship_loader").removeClass("loader");
            },
        });
    };

    var submit_forms = function () {
        $("#place_order").prop("disabled", true);
        $("img.loader").removeClass("hidden");

        // serialize main form
        // var form_data = JSON.stringify($('#checkout_form').serializeArray());
        var form_url = $("#checkout_form").attr("action");
        var form_data = $("#checkout_form").serialize();

        // submit main form
        $ajaxManager.add({
            type: "POST",
            url: form_url,
            data: form_data,
            dataType: "json",
            error: function (jqXHR, textStatus, errorThrown) {
                $("#proc_loader").removeClass("loader");
            },
            success: function (data) {
                if ($("#payment_type").is(":checked")) {
                    // authorize populate fields and submit
                    console.log("authorize");
                    submit_authorize_form();
                } else {
                    // paypal populate fields and submit
                    console.log("paypal");
                    //get_paypal_info();
                    $("#paypal_form").submit();
                }
            },
        });
    };

    $(function () {
        $(".select2").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 20,
            allowClear: false,
        });

        // create an ajaxmanager named cacheQueue
        $ajaxManager = $.manageAjax.create("cacheQueue", {
            queue: true,
        });

        // validator ---------------------------------------------------------
        $.tools.validator.fn("[data-required]", function (input, value) {
            var req = input.attr("data-required");
            return input.is(":hidden") || value
                ? true
                : {
                      en: req == "required" ? "Field is required" : req,
                  };
        });

        $.tools.validator.addEffect(
            "wall",
            function (errors, event) {
                var wall = $(this.getConf().container).slideDown(
                    500,
                    function () {
                        $("html, body").animate(
                            {
                                scrollTop: $("#sale_total").offset().top - 100,
                            },
                            2000
                        );
                    }
                );
                wall.find("p").remove();
                $.each(errors, function (index, error) {
                    wall.append(
                        '<p><a href="#' +
                            error.input.attr("id") +
                            '">' +
                            error.input.attr("title") +
                            "</a> - " +
                            error.messages[0] +
                            "</p>"
                    );
                });
            },
            function (inputs) {
                // nothing when all inputs are valid
            }
        );

        $("#checkout_form")
            .validator({
                effect: "wall",
                container: ".validation_error",
                errorInputEvent: null,

                // custom form submission logic
            })
            .submit(function (e) {
                // when data is valid
                if (!e.isDefaultPrevented()) {
                    e.preventDefault();
                    if (!_submitted) {
                        // prevent double submission
                        submit_forms();
                    }
                    _submitted = 1;
                }
            });

        $("#checkout_form select").on("change", function (event) {
            hide_validator();
        });
        $("#checkout_form input:checkbox").on("change", function () {
            hide_validator();
        });
        $("#checkout_form input:radio").on("change", function () {
            hide_validator();
        });
        $("#checkout_form input:text").on("keyup", function (event) {
            if (event.which == 8 || event.which > 45) {
                hide_validator();
            }
        });

        $('input[name="payment_type"]').on("change", function () {
            if ($(this).val() == 0) {
                // CC
                $(".ccard_group").slideDown("slow");
                $("#new_paypal").slideUp("slow");
                $("#place_order").prop("disabled", false);
            } else {
                // PP
                $(".ccard_group").slideUp("slow");
                $("#new_paypal").slideDown("slow");
                $("#place_order").prop("disabled", true);
            }
        });

        // wholesaler bill address
        $('input[name="billing_address"]').change(function () {
            if ($(this).val() == 1) {
                // defSault address
                $(".bill_new").slideUp("slow");
                $(".bill_default").slideDown("slow");

                get_taxes($("#zip_default").val(), taxes_url);

                // clear new address
                $("#bill_last_name").val("");
                $("#bill_address").val("");
                $("#bill_city").val("");
                $("#bill_state").val("");
                $("#bill_zip").val("");
                $("#bill_phone").val("");
                $("#bill_email").val("");
            } else {
                // new address
                $(".bill_new").slideDown("slow");
                $(".bill_default").slideUp("slow");

                get_taxes($("#bill_zip").val(), taxes_url);
            }
        });

        $("#bill_zip").on("keyup", function (event) {
            get_taxes(event.which, $(this).val(), taxes_url);

            if ($("#same_address").is(":checked")) {
                get_rates(event.which, $(this).val(), rates_url);
            }
        });

        $("#place_order").on("click", function () {
            $("#checkout_form").submit();
        });

        $("#same_address").on("change", function () {
            if (!$(this).is(":checked")) {
                if ($(".ship_address").is(":hidden")) {
                    // clear fields
                    $("#ship_last_name").val("");
                    $("#ship_address").val("");
                    $("#ship_zip").val("");
                    $("#ship_city").val("");
                    $("#ship_state").val("");
                    $("#ship_phone").val("");

                    $(".ship_address").slideDown();
                }
                get_rates(false, $("#ship_zip").val(), rates_url);
            } else {
                $(".ship_address").slideUp();

                // use billing zip
                get_rates(false, $("#bill_zip").val(), rates_url);
            }
        });

        $("#payment_type").change();
        init_remove($ajaxManager);

        $("#coupon").on("change keyup", () => {
            $("#coupon +.help-block > em").text("");
            $ajaxManager.add({
                type: "POST",
                url: url_coupon,
                data: {
                    coupon: $("#coupon").val(),
                    sale_id: sale_id,
                },
                dataType: "json",
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                },
                success: function (data) {
                    $("#coupon +.help-block > em").text(data.msg);
                    $("#coupon +.help-block").show();
                    if (data.valid) {
                        $('.coupon_discount').removeClass('oculto');
                    }
                },
            });
        });
    });
}

function init_done() {
    var job_confirm = function (button, no_art) {
        button.data("working", true);
        button.addClass("disabled");

        let $parent = button.parent();

        let $loader = button.parents(".done_buttons").find(".loader img");
        $loader.removeClass("hidden");

        $.ajax({
            type: "GET",
            url: button.data("href") + "/1",
            dataType: "json",
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                $loader.addClass("hidden");
            },
            success: function (data) {
                
                if (data != "error") {
                    // remove upload
                    button
                        .parents("td")
                        .find(".bt_upload, .txt_upload")
                        .remove();

                    // show date due
                    var date_due = button
                        .parents(".buttons")
                        .prev()
                        .find(".date_due");
                    date_due
                        .find("span")
                        .text(
                            data["date_due"]
                                ? moment(data["date_due"]).format("MM/DD/YYYY")
                                : "-"
                        );
                    date_due.slideDown("slow");

                    var badge_done =
                        '<span class="badge badge-green"><i class="fa fa-check"></i></span> ';
                    var badge_info =
                        '<span class="badge badge-info"><i class="fa fa-info"></i></span>';

                    var msg = $("<span></span>")
                        .addClass("confirmed")
                        .html(badge_done + lng_text("done:confirmed") + "!");
                    var info = $("<span></span>")
                        .addClass("info")
                        .html(
                            badge_info +
                                (data.proof
                                    ? lng_text("done:proof_notify")
                                    : lng_text("done:ready_notify"))
                        );
                    $parent.html(msg).append(info);

                    // continue button
                    if (!$(".bt_upload").size()) {
                        //$('#continue').removeClass('hidden');
                    }
                } else {
                }
                $loader.addClass("hidden");
            },
        });
    };

    $(function () {
        $(".bt_confirm")
            .on("click", function () {
                console.log(".bt_confirm");
                if (!$(this).data("working")) {
                    if ($(this).data("status") == "no_art") {
                        if (confirm(lng_text("product:no_art"))) {
                            job_confirm($(this), true);
                        }
                    } else {
                        job_confirm($(this), false);
                    }
                }

                return false;
            })
            .data("working", false);

        // continue button
        if (!$(".bt_upload").size()) {
            $("#continue").removeClass("hidden");
        }
    });
}

function init_proof() {
    var proof_approve = function (button) {
        var approved = button.hasClass("reject") ? 0 : 1;
        var parent = button.parents(".proof_item");
        var response = parent.find("textarea").val();

        App.blockUI({ target: parent, iconOnly: true });

        $.ajax({
            type: "POST",
            url: button.data("href"),
            dataType: "json",
            data: { approved: approved, response: response },
            error: function (jqXHR, textStatus, errorThrown) {
                //trace('error');
                App.unblockUI(parent);
            },
            success: function (data) {
                if (!data.error) {
                    var h5 = parent.find(".group-status h5");
                    h5.toggleClass("approved", Boolean(approved));
                    h5.find("i")
                        .removeClass()
                        .addClass("fa fa-" + (approved ? "check" : "close"));
                    h5.find("span").text(
                        lng_text(
                            "proof:" + (approved ? "approved" : "rejected")
                        )
                    );
                    parent.find("p").html(response);

                    parent.find(".group-status").slideDown();
                    parent.find(".group-approve").slideUp();
                } else {
                    //trace(data.error);
                }

                App.unblockUI(parent);
            },
        });
    };

    $(function () {
        $(".fancybox").fancybox({ helpers: { overlay: { locked: false } } });

        $("#done").on("click", function () {
            window.location.href = $(this).data("href");
        });

        $(".bt_proof").on("click", function () {
            proof_approve($(this));
            return false;
        });
    });
}

const render_paypal = () => {
    paypal
        .Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [
                        {
                            amount: {
                                value: parseFloat(sale_total).toFixed(2),
                            },
                        },
                    ],
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    let add = details.purchase_units[0].shipping.address;
                    $.ajax({
                        type: "POST",
                        url: url_paypal,
                        data: {
                            transaction_id: details.id,
                            status: details.status,
                            email: details.payer.email_address,
                            payer_id: details.payer.payer_id,
                            value: details.purchase_units[0].amount.value,
                            value_site: parseFloat(
                                $("#sale_total").val().replace("$ ", "")
                            ).toFixed(2),
                            full_name:
                                details.purchase_units[0].shipping.name
                                    .full_name,
                            full_address: `${add.address_line_1}, ${add.admin_area_2}, ${add.admin_area_1}, ${add.postal_code},${add.country_code}`,
                        },
                        dataType: "text",
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(textStatus);
                            console.log(errorThrown);
                            $("#paypal_error").show();
                        },
                        success: function (data) {
                            if (data == 1) {
                                $("#paypal_error").hide();
                                $("#place_order").prop("disabled", false);
                                $("#place_order").click();
                            } else {
                                $("#paypal_error").show();
                            }
                        },
                    });
                });
            },
            onError: function (err) {
                console.log(err);
                $("#paypal_error").show();
            },
        })
        .render("#paypal-button-container"); // Display payment options on your web page
}