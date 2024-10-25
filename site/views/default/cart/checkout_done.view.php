<?php
$order = sprintf($lng->text('done:order_nro'), $sale->get_id(), $date_sold);
$list_count = $object->list_count();

$sale_bill_address = $address_info['sale_bill_address'];
$payment = ($sale->get_payment_type() == $sale->payment_type_enum('paypal')) ? 'Paypal' : 'CC ' . strtolower($sale->get_credit_card());
?>

<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$order?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<h2 class="subtitle"><?=$order?></h2>
	<h5 class="billed"><b><?=$lng->text('done:bill_to')?>:</b> <?=$sale_bill_address->get_full_address(false, false) . ' / ' . $payment?></h5>

	<a class="to_invoice"></a>
	<?php /*
	<a class="to_invoice" href="<?=$app->go('Cart/invoice', false, '/' . $sale->get_hash())?>"><?=$lng->text('cart:view_invoice')?> »</a>
	*/ ?>

	<div class="done_text<?=($new_sale) ? ' ntf_success' : ''?>">
		<?=$text?>
	</div>

	<div class="product_form cart_product final clearfix">
		<?=$tpl->get_view('cart/done_block', array(
				'sale' => $sale,
				'object' => $object,
				'product' => $product,
				'address_info' => $address_info,
				'items_array_by_key' => $item_array_list,
				'list_count' => $list_count,
				'from_account' => $from_account,
			))?>

		<form class="dummy form form-horizontal">
			<div class="clearfix">
				<?=$tpl->get_view('cart/checkout_total', array('sale' => $sale, 'submit' => false))?>
			</div>
		</form>

		<?php if ($from_account) { ?>
		<div class="back_orders">
			<a class="back" href="<?=$app->go('User/account')?>">&laquo; <?=$lng->text('done:back_orders')?></a>
		</div>
		<?php } else { ?>
		<div class="cart_submit clearfix">
			<a id="continue" class="btn btn-lg yswp-red yswp-big btn-outline" href="<?=$app->go('Home')?>"><?=$lng->text('cart:continue')?> <i class="fa fa-arrow-circle-right"></i></a>
		</div>
		<?php } ?>
	</div>
</view>


<view key="page_scripts">
	<script>init_done();</script>
</view>
