<div class="clearfix">
	<div class="col-md-8">
		<table class="table table-hover sale-table">
			<thead>
				<tr><th class="col-md-2"><b><?=$lng->text('sale:sale_id')?></b></th><td class="col-md-6"><b><?=sprintf('%06d', $object->get_sale_id())?></b></td></tr>
				<? if ($wholesaler->get_id()) { ?>
				<tr><th class="col-md-2"><b><?=$lng->text('sale:wholesaler')?></b></th><td><a target="_blank" href="<?=$app->go('Wholesaler', false, '/edit/' . $wholesaler->get_id())?>"><b><?=$wholesaler->get_company()?></b></a></td></tr>
				<tr><th class="col-md-2"><b><?=$lng->text('sale:billed_to')?></b></th><td<?=($sale->get_source() == 'wp') ? ' class="sep"' : ''?>><?=$bill_address->get_last_name()?></td></tr>
				<? } else { ?>
				<tr><th class="col-md-2"><b><?=$lng->text('sale:client')?></b></th><td<?=($sale->get_source() == 'wp') ? ' class="sep"' : ''?>><?=$bill_address->get_last_name()?></td></tr>
				<? } ?>

				<? if ($user->perm('perm:sale_price') && $sale->get_source() != 'wp') { ?>
				<tr><th><?=$lng->text('sale:url')?></th><td><a href="<?=$sale_url?>" target="_blank"><?=$sale_url?></a></td></tr>
				<tr><th><?=$lng->text('sale:invoice')?></th><td><a href="<?=$invoice_url?>" target="_blank"><?=$invoice_url?></a></td></tr>
				<? } ?>
				<? if ($sale->get_source() != 'wp') { ?>
				<tr><th><?=$lng->text('sale:work_order')?></th><td class="sep"><a href="<?=$work_order_url?>" target="_blank"><?=$work_order_url?></a></td></tr>
				<? } ?>

				<tr><th></th><td class="sep"></td></tr>

				<tr><th class="col-md-2"><b><?=$lng->text('sale:sale_product_id')?></b></th><td class="col-md-6"><b><?=sprintf('%06d', $object->get_id())?></b></td></tr>
				<tr><th><?=$lng->text('sale:job_name')?></th><td><?=$object->get_job_name()?></td></tr>
				<tr><th><?=$lng->text('sale:product')?></th><td><?=($sale->get_source() == 'wp') ? sprintf('%06d', $object->get_job_id()) . ' | ' . $object->get_product() : $object->get_product()?></td></tr>

				<tr>
					<th><?=$lng->text('sale:status')?></th>
					<td>
						<span class="label label-sm <?=$object->get_status()?>"><?=$lng->text($object->get_status())?></span>

						<?=$this->get_view('sale/sale_actions', array('object' => $object))?>
					</td>
				</tr>

				<tr><th><?=$lng->text('sale:date_sold')?></th><td><?=$date_sold?></td></tr>
				<tr><th><?=$lng->text('sale:date_confirm')?></th><td><?=$date_confirm?></td></tr>
				<? if ($sale->get_source() == 'wp') { ?>
				<tr>
					<th><?=$lng->text('sale:date_due')?></th>
					<td class="sep">
						<div data-date-format="mm/dd/yyyy" data-date="<?=date('m/d/Y')?>" class="input-group input-small date date-picker">
							<input type="text" name="date_due" id="date_due" readonly class="form-control input-sm" size="16" value="<?=($date_due != '-') ? $date_due : ''?>"><span class="input-group-btn">
								<button type="button" class="btn btn-sm default date_due"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
					</td>
				</tr>
				<? } else { ?>
				<tr><th><?=$lng->text('sale:date_due')?></th><td><?=$date_due?></td></tr>
				<tr><th><?=$lng->text('sale:measures')?></th><td><?=$object->get_width()?>" x <?=$object->get_height()?>"</td></tr>
				<tr><th><?=$lng->text('sale:partial_sqft')?></th><td><?=$object->get_partial_sqft()?></td></tr>
				<tr><th><?=$lng->text('sale:quantity')?></th><td><?=$object->get_quantity()?></td></tr>
				<tr><th><?=$lng->text('sale:total_sqft')?></th><td class="sep"><?=$object->get_total_sqft()?></td></tr>
				<? } ?>
				<tr>
					<th><?=$lng->text('sale:comment')?></th>
					<td>
						<form class="form form-horizontal" action="<?=$app->go()?>">
							<textarea name="comment" id="comment" cols="50" rows="5" class="form-control"><?=$object->get_comment()?></textarea>
							<button type="button" data-field="comment" data-id="<?=$object->get_id()?>"
									class="btn blue-madison btn-sm margin-top-10 save_comment"><?=$lng->text('sale:save_comment')?></button>
						</form>
					</td>
				</tr>
			</thead>
		</table>
	</div>
</div>
