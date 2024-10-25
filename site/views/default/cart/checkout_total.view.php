<div class="form-body checkout-total clearfix">
	<?=$tpl->get_view('cart/checkout_text', array('field' => 'subtotal', 'label' => 'product:subtotal_discount', 
			'val' => '$ ' . number_format($sale->get_subtotal(), 2),
			'readonly' => true, 'width' => 3, 'lbl_width' => 9, 'class' => 'total number'))?>
	<?=$tpl->get_view('cart/checkout_text', array('field' => 'taxes', 'label' => 'checkout:tax', 
			'val' => '$ ' . number_format($sale->get_taxes(), 2),
			'readonly' => true, 'width' => 3, 'lbl_width' => 9, 'class' => 'total_gray number'))?>
	<?=$tpl->get_view('cart/checkout_text', array('field' => 'ship_total', 'label' => 'checkout:shipping', 
			'val' => '$ ' . number_format($sale->get_shipping(), 2),
			'readonly' => true, 'width' => 3, 'lbl_width' => 9, 'class' => 'total_gray number'))?>
	<?=$tpl->get_view('cart/checkout_text', array('field' => 'coupon_discount', 'label' => 'checkout:coupon_discount',
			'val' => '$ ' . number_format($sale->get_shipping(), 2),
			'readonly' => true, 'width' => 3, 'lbl_width' => 9, 'class' => 'total_gray number oculto coupon_discount'))?>
	<?=$tpl->get_view('cart/checkout_text', array('field' => 'sale_total', 'label' => 'checkout:total', 
			'val' => '$ ' . number_format($sale->get_total(), 2),
			'readonly' => true, 'width' => 3, 'lbl_width' => 9, 'class' => 'grand_total number'))?>


	<?php if ($submit !== false) { ?>
	<div class="validation_error" style="display: none;">
		<h5><?=$lng->text('product:fix_first')?></h5>
	</div>

	<button type="submit" class="col-sm-2 btn btn-lg yswp-red yswp-big" id="place_order"><?=$lng->text('checkout:submit')?> <i class="fa fa-arrow-circle-right"></i></button>
	<img class="loader hidden" src="/data/site/loader2.gif" width="36" height="36" />

	<input type="hidden" name="action" value="place_order" />
	<input type="hidden" name="sale_id" id="sale_id" value="<?=$sale->get_id()?>" />
	<?php } ?>
</div>

