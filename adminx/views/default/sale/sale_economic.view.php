<div class="clearfix">
	<div class="col-md-8">
		<table class="table table-hover sale-table">
			<thead>
				<tr><th class="col-xs-2"><b><?=$lng->text('sale:sale_product_id')?></b></th><td class="col-xs-6"><b><?=sprintf('%06d', $object->get_id())?></b></td></tr>
				<tr><th><?=$lng->text('sale:sale_id')?></th><td><?=sprintf('%06d', $object->get_sale_id())?></td></tr>
				<tr><th><?=$lng->text('sale:job_name')?></th><td><?=$object->get_job_name()?></td></tr>
				<tr><th><?=$lng->text('sale:product')?></th><td><?=$object->get_product()?></td></tr>
				<tr><th><?=$lng->text('sale:total_sqft')?></th><td><?=$object->get_total_sqft()?></td></tr>

				<tr><th><?=$lng->text('sale:product_subtotal')?></th><td>$ <?=$object->get_product_subtotal()?></td></tr>
				<tr><th><?=$lng->text('sale:tb:discounts')?></th><td class="less">-$ <?=$object->get_quantity_discount()?></td></tr>
				<tr><th><?=$lng->text('sale:turnaround_cost')?></th><td>$ <?=$object->get_turnaround_cost()?></td></tr>

				<tr><th><?=$lng->text('sale:proof')?></th><td>$ <?=$object->get_proof_cost()?></td></tr>

				<? if ($object->get_packaging_cost() > 0) { ?>
				<tr><th><?=$lng->text('sale:packaging')?></th><td>$ <?=$object->get_packaging_cost()?></td></tr>
				<? } ?>

				<? if (false) { //($wholesaler->get_id()) { ?>
				<tr><th><?=$lng->text('sale:shipping')?></th><td>$ <?=$object->get_shipping_cost()?></td></tr>
				<? } ?>

				<tr><th class="total"><b><?=$lng->text('sale:tb:total') . sprintf('%06d', $object->get_id())?></b></th><td class="plus sep"><b>$ <?=$object->get_product_total()?></b></td></tr>
				<tr><th></th><td class="sep"></td></tr>

				<tr><th class="col-xs-2"><?=$lng->text('sale:sale_subtotal')?></th><td class="col-xs-6">$ <?=$sale->get_subtotal()?></td></tr>
				<tr><th><?=$lng->text('sale:taxes')?></th><td>$ <?=$sale->get_taxes()?></td></tr>
				<? if (true) { //(!$wholesaler->get_id()) { ?>
				<tr><th><?=$lng->text('sale:shipping')?></th><td>$ <?=$sale->get_shipping()?></td></tr>
				<? } ?>
				<tr><th><b><?=$lng->text('sale:sale_total') . sprintf('%06d', $sale->get_id())?></b></th><td><b>$ <?=$sale->get_total()?></b></td></tr>
			</thead>
		</table>

	</div>
</div>
