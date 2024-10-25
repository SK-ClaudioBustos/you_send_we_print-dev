<tr <?=$added?>>
	<td colspan="4" class="col-xs-12 job_name">
		<h4><b><?=$object->get_job_name()?></b> - <em><?=$object->get_product()?></em></h4>
		<div class="visible-xs">
			<?=$tpl->get_view('cart/cart_block_item_details', array(
					'object' => $object,
					'ws' => $ws,
					'sale_ship_address' => $sale_ship_address,
					'sale_shipping' => $sale_shipping,
					'items_array_by_key' => $items_array_by_key,
				))?>
		</div>
	</td>
</tr>
<tr>
	<td class="col-xs-8 col-sm-3 remove">
		<?php if ($remove !== false) { ?>
		<a class="remove" data-id="<?=$object->get_id()?>" href="<?=$app->go($app->module_key, false, '/remove/')?>">Remove</a>
		<?php } ?>
	</td>
	<td class="hidden-xs col-sm-5 details">
		<?=$tpl->get_view('cart/cart_block_item_details', array(
				'object' => $object,
				'ws' => $ws,
				'sale_ship_address' => $sale_ship_address,
				'sale_shipping' => $sale_shipping,
				'items_array_by_key' => $items_array_by_key,
			))?>
	</td>
	<td class="col-xs-2 right qty"><?=$object->get_quantity()?></td>
	<td class="col-xs-2 right subtot">$ <?=$object->get_product_total()?></td>
</tr>
