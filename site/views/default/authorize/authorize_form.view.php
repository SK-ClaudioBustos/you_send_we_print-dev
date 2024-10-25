<form action="<?=$app->go('Authorize')?>" method="post" id="authorize_form">
    <p>
        <input type="hidden" name="name_card" id="a_name_card" value="" />
        <input type="hidden" name="credit_card" id="a_credit_card" value="" />
        <input type="hidden" name="card_number" id="a_card_number" value="" />
        <input type="hidden" name="exp_month" id="a_exp_month" value="" />
        <input type="hidden" name="exp_year" id="a_exp_year" value="" />
        <input type="hidden" name="sec_code" id="a_sec_code" value="" />
    </p>
</form>