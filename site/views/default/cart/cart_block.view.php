<?php
$ws = $address_info['wholesaler'];
$sale_ship_address = $address_info['sale_ship_address'];
$sale_shipping = $address_info['sale_shipping'];
?>
<div class="table-responsive">
	<table class="table table-cart">
		<?=$tpl->get_view('cart/cart_block_header')?>

		<tbody>
			<?php
			if ($list_count) {
				while($object->list_paged(false)) { // include inactive
					$added = ($object->get_id() == $added_id) ? ' class="added"' : '';
					if ($ws->get_id()) {
						$sale_ship_address->retrieve($object->get_sale_address_id());
						$sale_shipping->retrieve_by('sale_product_id', $object->get_id());
					}

					echo $tpl->get_view('cart/cart_block_item', array(
							'object' => $object,
							'added' => $added,
							'ws' => $ws,
							'sale_ship_address' => $sale_ship_address,
							'sale_shipping' => $sale_shipping,
							'items_array_by_key' => $items_array_by_key,
						));
				}
			} else {
				?>
				<tr>
					<td colspan="4" class="empty"><?=$lng->text('cart:empty_cart')?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>
