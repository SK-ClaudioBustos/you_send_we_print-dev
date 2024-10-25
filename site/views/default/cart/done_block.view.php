<?php
$ws = $address_info['wholesaler'];
$sale_bill_address = $address_info['sale_bill_address'];
$sale_ship_address = $address_info['sale_ship_address'];
$sale_shipping = $address_info['sale_shipping'];
?>
<div class="table-responsive">
	<table class="table table-cart">
		<?php
		echo $tpl->get_view('cart/done_block_header', array(
				'work_order' => $work_order,
				'first' => true,
			));

		if ($list_count) {
			while($object->list_paged()) {
				$product->retrieve($object->get_product_id());
				$images = new Image();
				$images->set_paging(1, 0, '`image_id` ASC', array("`sale_product_id` = {$object->get_id()}"));
				if ($ws->get_id()) {
					$sale_ship_address->retrieve($object->get_sale_address_id());
					$sale_shipping->retrieve_by('sale_product_id', $object->get_id());
				}

				echo $tpl->get_view('cart/done_block_item', array(
						'object' => $object,
						'sale' => $sale,
						'product' => $product,
						'items' => $items,
						'added' => $added,
						'images' => $images,
						'items_array_by_key' => $items_array_by_key,

						'ws' => $ws,
						'sale_ship_address' => $sale_ship_address,
						'sale_shipping' => $sale_shipping,

						'hide_buttons' => $hide_buttons,
						'work_order' => $work_order,
					));
			}

		} else {
			?>
			<tr>
				<td colspan="5" class="empty"><?=$lng->text('done:empty')?></td>
			</tr>
			<?php
		}
		?>
	</table>
</div>
