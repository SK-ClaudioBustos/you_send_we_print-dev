<div class="clearfix">
	<div class="col-md-8">
		<table class="table table-hover sale-table">
			<thead>
				<? if ($sale->get_source() == 'wp') { ?>
					<? if ($object->get_description()) { ?>
						<tr><th><?=$lng->text('sale:description')?></th><td><?=nl2br($object->get_description())?></td></tr>
					<? } ?>
					<tr><th class="col-md-2"><?=$lng->text('sale:details')?></th><td class="col-md-6"><?=nl2br($sale_product_wp->get_detail_text())?></td></tr>
				<? } else {
					$info = json_decode($object->get_detail(), true);
					$detail = $info['detail'];
					?>
					<tr><th class="col-md-2"><?=$lng->text('sale:job_name')?></th><td class="col-md-6"><?=$object->get_job_name()?></td></tr>
					<tr><th><?=$lng->text('sale:product')?></th><td><?=$object->get_product()?></td></tr>

					<tr><th class="col-md-2"><?=$lng->text('product:size')?></th><td class="col-md-6"><?=$object->get_width() . ' x ' . $object->get_height()?>"</td></tr>
					<? //=($object->get_sides()) ? '<tr><th>' . $lng->text('product:sides') . '</th><td>' . $object->get_sides() . '</td></tr>' : ''?>
					<tr><th><?=$lng->text('sale:quantity')?></th><td><?=$object->get_quantity()?></td></tr>

					<?
					foreach($detail as $key => $info) {
						//echo '<tr><th>' . $lng->text('product:' . $key) . '</th><td>' . $items[$info['id']] . '</td></tr>';
						echo '<tr><th>' . $lng->text('product:' . $key) . '</th><td>' . $info['descr'] . '</td></tr>';
					}

					if (isset($detail['cutting']) && $detail['cutting']['quantity']) {
						echo '<tr><th>' . $lng->text('product:cut_quantity') . '</th><td>' . $detail['cutting']['quantity'] . '</td></tr>';
					}
					?>

					<?=($object->get_packaging()) ? '<tr><th>' . $lng->text('product:packaging') . '</th><td>Yes</td></tr>' : ''?>
					<?=($object->get_proof()) ? '<tr><th>' . $lng->text('product:proof') . '</th><td>Yes</td></tr>' : ''?>
				<? } ?>
			</thead>
		</table>
	</div>
</div>
