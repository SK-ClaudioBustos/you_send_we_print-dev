<div class="table-responsive">
	<table class="table table-cart">
		<?=$tpl->get_view('cart/done_block_header', array(
				'first' => true,
			))?>
		<tr>
			<td class="job_id"><?=sprintf('%08d', $object->get_id())?></td>
			<td class="job_name details clearfix">
				<h4><b><?=$object->get_job_name()?></b> - <em><?=$object->get_product()?></em></h4>
				<?=$tpl->get_view('cart/cart_block_item_details', array(
						'object' => $object,
						'items' => $items,
						'ws' => $ws,
						'sale_ship_address' => $sale_ship_address,
						'sale_shipping' => $sale_shipping,
						'images' => $images,
						'work_order' => $work_order,
						'items_array_by_key' => $items_array_by_key
					))?>
			</td>
			<td class="right qty"><?=$object->get_quantity()?></td>
			<td class="right subtot">$ <?=$object->get_product_total()?></td>
		</tr>
	</table>
</div>
