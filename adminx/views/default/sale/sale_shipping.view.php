<div class="clearfix">
	<div class="col-md-8">
		<table class="table table-hover sale-table">
			<thead>
				<tr><th class="col-md-2"><b><?=$lng->text('sale:ship_by')?></b></th><td class="col-md-6"><b><?=$shipping_by?></b></td></tr>
				<tr><th><?=$lng->text('sale:shipping_type')?></th><td><?=($ship = $shipping->get_shipping_type()) ? $ship : $lng->text('sale:ship_pick')?></td></tr>

				<? if (!$ship) { ?>
				<tr><th><?=$lng->text('sale:weight')?></th><td><?=$object->get_shipping_weight()?></td></tr>
				<? if ($sale->get_source() == 'wp') { ?>
				<tr>
					<th><?=$lng->text('sale:ship_comment')?></th>
					<td>
						<form class="form form-horizontal" action="<?=$app->go()?>">
							<textarea name="shipping_comment" id="shipping_comment" cols="50" rows="5" class="form-control"><?=$shipping->get_shipping_comment()?></textarea>
							<button type="button" data-field="shipping_comment" data-id="<?=$shipping->get_id()?>"
									class="btn blue-madison btn-sm margin-top-10 save_comment"><?=$lng->text('sale:save_comment')?></button>
						</form>
					</td>
				</tr>
				<? } ?>
				<? } else { ?>
				<tr><th><?=$lng->text('sale:weight')?></th><td class="sep"><?=$object->get_shipping_weight()?></td></tr>
				<tr><th></th><td class="sep"></td></tr>

				<tr><th><b><?=$lng->text('sale:ship_to')?></b></th><td><b><?=$ship_address->get_last_name()?></b></td></tr>
				<tr><th><?=$lng->text('form:address')?></th><td><?=$ship_address->get_address()?></td></tr>
				<tr><th><?=$lng->text('form:city')?></th><td><?=$ship_address->get_city()?></td></tr>
				<tr><th><?=$lng->text('form:state')?></th><td><?=$ship_address->get_state()?></td></tr>
				<tr><th><?=$lng->text('form:zip')?></th><td><?=$ship_address->get_zip()?></td></tr>
				<tr><th><?=$lng->text('form:phone')?></th><td><?=$ship_address->get_phone()?></td></tr>
				<tr><th><?=$lng->text('form:fax')?></th><td><?=$ship_address->get_fax()?></td></tr>
				<? } ?>
			</thead>
		</table>
	</div>
</div>

