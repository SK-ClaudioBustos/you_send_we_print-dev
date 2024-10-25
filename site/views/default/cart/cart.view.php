<?php $list_count = ($sale->get_id() && $object->list_count(false)); ?>

<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<div class="product_form cart_product final clearfix">
		<?=$tpl->get_view('cart/cart_block', array(
				'sale' => $sale,
				'object' => $object,
				'product' => $product,
				'items' => $items,
				'items_array_by_key' => $item_array_list,
				'added_id' => $added_id,
				'list_count' => $list_count,
				'address_info' => $address_info,
			))?>

		<?php if ($sale->get_subtotal() > 0) { ?>
		<div class="form-horizontal cart_subtot clearfix">
			<div class="form-body checkout-total clearfix">
				<?=$tpl->get_view('cart/checkout_text', array('field' => 'subtotal', 'label' => 'product:subtotal_discount',
						'val' => '$ ' . number_format($sale->get_subtotal(), 2),
						'readonly' => true, 'width' => 3, 'lbl_width' => 9, 'class' => 'total number'))?>
				<label class="plus"><?=$lng->text('product:plus')?></label>
			</div>
		</div>
		<?php } ?>

		<div class="cart_submit clearfix">
			<a id="checkout" class="btn btn-lg yswp-red yswp-big<?=($list_count) ? '' : ' disabled'?>" href="<?=($list_count) ? $app->go('Cart/checkout') : 'javascript:;'?>"><?=$lng->text('cart:checkout')?> <i class="fa fa-arrow-circle-right"></i></a>
			<a id="continue" class="btn btn-lg yswp-red yswp-big btn-outline" href="<?=$app->go('Home')?>"><?=$lng->text('cart:continue')?> <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
</view>


<view key="page_scripts">
	<script>init_cart();</script>
</view>
