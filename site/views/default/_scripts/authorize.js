
function submit_authorize_form() {
    $('#a_name_card').val($('#name_card').val());
    $('#a_credit_card').val($('#credit_card').val());
    $('#a_card_number').val($('#card_number').val());
    $('#a_exp_month').val($('#exp_month').val());
    $('#a_exp_year').val($('#exp_year').val());
    $('#a_sec_code').val($('#sec_code').val());

console.log($('#exp_month').val() + '|' + $('#exp_year').val());   
console.log('Authorize submit');

    $('#authorize_form').submit();

}