<?php
$ws = $address_info['wholesaler'];
$sale_ship_address = $address_info['sale_ship_address'];
$sale_shipping = $address_info['sale_shipping'];

if (!$separate) {
	?>
	<div class="table-responsive">
		<table class="table table-cart">
			<?php
			echo $tpl->get_view('cart/done_block_header', array(
					'work_order' => $work_order,
					'first' => true,
				));
}

if ($list_count) {
	$first = true;
	while($object->list_paged()) {

		$shirts = false;
		$details = $object->get_detail();
		if (isset($details['size']['shape_back'])) {
			$shirts = true;
			if ($object->get_comment() == "") {
				$size_front = new Size($details['size']['id']);
				$size_back = new Size($details['size']['id_back']);
				$comment = "Front: " . $size_front->get_width() . "\" * " . $size_front->get_height() . "\"  -  Back: " . $size_back->get_width() . "\" * " . $size_back->get_height() . '"';
				$object->set_comment($comment);
				$object->update();
			}
		}


		$product->retrieve($object->get_product_id());
		if ($ws->get_id()) {
			$sale_ship_address->retrieve($object->get_sale_address_id());
			$sale_shipping->retrieve_by('sale_product_id', $object->get_id());
		}

		if ($separate) {
			echo $tpl->get_view('cart/work_order_header', array(
					'sale' => $sale,
					'object' => $object,
					'product' => $product,
					'items' => $items,
					'address_info' => $address_info,
					'title' => $title,
					'date_sold' => $date_sold,
					'first' => $first,
				));

			?>
			<div class="table-responsive">
				<table class="table table-cart">
					<?php
					echo $tpl->get_view('cart/done_block_header', array(
							'work_order' => $work_order,
							'pagebreak' => true,
							'first' => $first,
						));
			$first = false;
		}

		echo $tpl->get_view('cart/work_order_block_item', array(
				'object' => $object,
				'sale' => $sale,
				'product' => $product,
				'items' => $items,
				'items_array_by_key' => $items_array_by_key,
				'added' => $added,
				'images' => $images,
				'ws' => $ws,
				'sale_ship_address' => $sale_ship_address,
				'sale_shipping' => $sale_shipping,
				'hide_buttons' => $hide_buttons,
				'work_order' => $work_order,
				'shirts' => $shirts,
			));

		if ($separate) {
			?>
			</table>
			</div>
			<?php
		}
	}
} else {
	?>
	<tr>
		<td colspan="4" class="empty"><?=$lng->text('done:empty')?></td>
	</tr>
	<?php
}

if (!$separate) {
	?>
	</table>
	</div>
	<?php
}
?>
