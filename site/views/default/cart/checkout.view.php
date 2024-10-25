<?php $list_count = $object->list_count(false); ?>
<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $lng->text('cart:title') ?>": "<?= $app->go('Cart') ?>", "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<?= ($error_msg) ? '<div class="ntf_error"><p>' . $error_msg . '</p></div>' : '' ?>

	<form method="post" id="checkout_form" class="form form-horizontal no-block" action="<?= $app->go($app->module_key, false, '/save') ?>">
		<div class="product_form cart_product clearfix">
			<div class="clearfix">
				<h2><?= $lng->text('checkout:product_info') ?></h2>

				<?= $tpl->get_view('cart/cart_block', array(
					'sale' => $sale,
					'object' => $object,
					'product' => $product,
					'added_id' => $added_id,
					'list_count' => $list_count,
					'address_info' => $address_info,
					'items_array_by_key' => $item_array_list,
				)) ?>
			</div>

			<?php if (sizeof($disclaimers)) { ?>
				<div class="disclaimers clearfix">
					<?php $first = true;
					foreach ($disclaimers as $id => $disclaimer) { ?>
						<?php if ($first) {
							$first = false;
							$main = $disclaimer['title'];  ?>
							<h3><?= $disclaimer['title'] ?></h3>
						<?php } else { ?>
							<h4><?= $disclaimer['title'] ?></h4>
						<?php } ?>
						<?= html_entity_decode($disclaimer['content']) ?>
					<?php } ?>
					<h3><b><?= sprintf($lng->text('checkout:agreement'), '<a target="_blank" href="' . $app->go('Section/terms') . '">', '</a>') . $main ?></b></h3>
				</div>
			<?php } ?>

			<h2><?= $lng->text('checkout:bill_address') ?></h2>
			<div class="checkout_block checkout_bill clearfix">
				<?= $tpl->get_view('cart/checkout_bill', array(
					'sale' => $sale,
					'object' => $object,
					'address_info' => $address_info
				)) ?>
			</div>

			<?php if ($show_coupon) { ?>
				<h2><?= $lng->text('checkout:coupon') ?></h2>
				<div class="checkout_block checkout_coupon clearfix">
					<?= $tpl->get_view('_input/text', array(
						'label' => 'checkout:code',
						'field' => 'coupon',
						'class' => 'coupon_apply',
						'width' => 3,
						'first_help' => $lng->text('checkout:coupon_help'),
						'help_text'	=> 'placeholder'
					)) ?>
				</div>
			<?php } ?>

			<h2><?= $lng->text('checkout:payment') ?></h2>
			<div class="checkout_block checkout_pay clearfix">
				<?= $tpl->get_view('cart/checkout_pay', array(
					'sale' => $sale,
					'object' => $object,
					'address_info' => $address_info,
					'list_count' => $list_count,
					'years' => $years,
					'months' => $months,
				)) ?>
			</div>

			<div class="checkout_block final clearfix">
				<?= $tpl->get_view('cart/checkout_total', array(
					'sale' => $sale,
					'checkout' => true
				)) ?>
			</div>

		</div>
	</form>

	<form action="<?= $app->go('Cart', false, '/ajax_confirmed') ?>" method="post" id="paypal_form">
		<input type="hidden" name="paypal" value="1">
	</form>

	<?php /* $tpl->get_view('paypal/paypal_form', array(
		'token' => $pp_token,
		'item_number' => $item_number,
		'quantity' => 1,
		'sale' => $sale,
	)) */ ?>



	<?= $tpl->get_view('authorize/authorize_form', array()) ?>
</view>


<view key="page_scripts">
	<script>
		let sale_total = '<?= $sale->get_total() ?>';

		let url_coupon = '<?= $app->go('Coupon', false, '/ajax_apply') ?>';

		let sale_id = '<?= $sale->get_id() ?>';

		var url_paypal = '<?= $app->go('Paypal', false, '/ajax_confirm') ?>';

		init_checkout('<?= $address_info['rates_url'] ?>/', '<?= $address_info['taxes_url'] ?>/');
	</script>
</view>