function cb_submit() {
    // grecaptcha.execute();
    $(".register-form").submit();
}

function activate() {
    let same = $("#ship_same").prop("checked");

    $(".shipping-group").toggleClass("disabled", same);

    $(".shipping-group input").prop("disabled", same);
    $("#ship_state").select2("enable", !same);
}

function init_register() {
    $(function () {
        var timezone = calculate_time_zone(".");
        $("#tz").val(timezone.substr(2));
        $("#dst").val(timezone.substr(0, 1));
    });
}

function init_register_ws(email = false) {
    $(function () {
        $(".select2").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 20,
            allowClear: false,
        });
        if (email) {
            $("#mail_sent").show();
        }        
    });
}

function init_address() {
    $(function () {
        $(".select2").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 20,
            allowClear: false,
        });
    });
}

function init_account_ws(active = false) {
    $(function () {
        $(".select2").select2({
            placeholder: lng_text("form:select") + "...",
            minimumResultsForSearch: 20,
            allowClear: false,
        });

        if (active) {
            $("#mail_confirmed").show();
        }

        activate();

        $("#ship_same").change(function () {
            activate();
        });

        $("#wholesaler_image").on("change", function () {
            $(".permit_block").slideUp();
            $(".permit_" + $(this).val()).slideDown();
        });

        $("#certificate_image").on("change", function () {
            $(".certificate_block").slideUp();
            $(".certificate_" + $(this).val()).slideDown();
        });
    });
}

const init_confirm = () => {
    $(function () {
        $("#email_confirm").on("click", (e) => {
            e.preventDefault();
            $.ajax({
                url: ajax_confirm_url,
                type: "POST",
                success: function (data) {
                    $("#email_confirm").html(
                        lng_text("user:confirm_sent") + " ✔"
                    );
                },
                error: function (data) {                    
                    $("#email_confirm").html(
                        lng_text("user:confirm_sent_error") + " ❌"
                    );
                },
            });
        });
    });
};
