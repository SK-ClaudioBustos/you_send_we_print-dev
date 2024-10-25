<div class="clearfix">
	<div class="col-md-8">
		<table class="table table-hover sale-table">
			<thead>
				<? //$wholesaler = new Wholesaler();
				if ($wholesaler->get_id()) { ?>
				<tr><th class="col-md-2"><b><?=$lng->text('sale:wholesaler')?></b></th><td class="col-md-6"><a target="_blank" href="<?=$app->go('Wholesaler', false, '/edit/' . $wholesaler->get_id())?>"><b><?=$wholesaler->get_company()?></b></a></td></tr>
				<tr><th><?=$lng->text('sale:contact')?></th><td><?=$wholesaler->get_full_name()?></td></tr>
				<tr><th><?=$lng->text('form:email')?></th><td><a href="mailto:<?=$wholesaler->get_email()?>"><?=$wholesaler->get_email()?></a></td></tr>
				<tr><th><?=$lng->text('sale:username')?></th><td class="sep"><?=$wholesaler->get_username()?></td></tr>
				<tr><th></th><td class="sep"></td></tr>
				<? } else { ?>
				<? } ?>

				<tr><th class="col-md-2"><b><?=$lng->text('sale:billed_to')?></b></th><td class="col-md-6"><b><?=$bill_address->get_last_name()?></b></td></tr>
				<tr><th><?=$lng->text('sale:payment_type')?></th><td><?=($sale->get_payment_type() == $sale->payment_type_enum('ccard') ? 'CC ' . $sale->get_credit_card() : 'Paypal')?></td></tr>
				<tr><th><?=$lng->text('form:address')?></th><td><?=$bill_address->get_address()?></td></tr>
				<tr><th><?=$lng->text('form:city')?></th><td><?=$bill_address->get_city()?></td></tr>
				<tr><th><?=$lng->text('form:state')?></th><td><?=$bill_address->get_state()?></td></tr>
				<tr><th><?=$lng->text('form:zip')?></th><td><?=$bill_address->get_zip()?></td></tr>
				<tr><th><?=$lng->text('form:phone')?></th><td><?=$bill_address->get_phone()?></td></tr>
				<tr><th><?=$lng->text('form:fax')?></th><td><?=$bill_address->get_fax()?></td></tr>
			</thead>
		</table>
	</div>
</div>
