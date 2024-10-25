<?php
//print_r($wholesaler); exit;
$sale_bill_address = $address_info['sale_bill_address'];
$ccard = ($sale->get_payment_type() == $sale->payment_type_enum('ccard'));
?>

<div class="form-body">
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<div class="radio-list">
					<label class="radio-inline lbl_ccard">
						<input type="radio" name="payment_type" id="payment_type" value="<?= $sale->payment_type_enum('ccard') ?>" <?= ($ccard) ? ' checked="checked"' : '' ?> />
						<?= $lng->text('checkout:pay_ccard') ?></label>
				</div>
				<div class="cc_info">
					<p><?= $lng->text('checkout:cc_authorize') ?></p>
					<img alt="" src="/data/cart/cc_authorize.png" />
				</div>
			</div>

			<div class="ccard_group" <?= (!$ccard) ? ' style="display: none;"' : '' ?>>
				<?= $tpl->get_view('cart/checkout_text', array(
					'field' => 'name_card', 'label' => 'checkout:name_card',
					'val' => $sale->get_name_card(), 'title' => 'checkout:name_card', 'attr' => 'maxlength="100"',
					'required' => true, 'error' => $object->is_missing('name_card'), 'width' => 8, 'lbl_width' => 3
				)) ?>
				<?= $tpl->get_view('cart/checkout_text', array(
					'field' => 'card_number', 'label' => 'checkout:card_number',
					'val' => $sale->get_card_number(), 'width' => 5, 'lbl_width' => 3, 'title' => 'checkout:card_number',
					'required' => true, 'error' => $object->is_missing('card_number'), 'attr' => 'maxlength="22"'
				)) ?>
				<?= $tpl->get_view('cart/checkout_select', array(
					'field' => 'exp_month', 'label' => 'checkout:expiration',
					'val' => $sale->get_exp_month(), 'width' => 'small', 'lbl_width' => 3, 'title' => 'checkout:expiration',
					'required' => true, 'error' => $object->is_missing('exp_month'),
					'options' => $months, 'is_assoc' => true, 'none_val' => '', 'none_text' => ''
				)) ?>
				<?= $tpl->get_view('cart/checkout_select', array(
					'field' => 'exp_year', 'label' => 'checkout:year',
					'val' => $sale->get_exp_year(), 'width' => 'small', 'lbl_width' => 3, 'title' => 'checkout:year',
					'required' => true, 'error' => $object->is_missing('exp_year'),
					'options' => $years, 'none_val' => '', 'none_text' => ''
				)) ?>
				<?= $tpl->get_view('cart/checkout_text', array(
					'field' => 'sec_code', 'label' => 'checkout:sec_code',
					'val' => $sale->get_sec_code(), 'width' => 'small', 'lbl_width' => 3, 'title' => 'checkout:sec_code',
					'required' => true, 'error' => $object->is_missing('sec_code'), 'attr' => 'maxlength="5"'
				)) ?>

				<div class="hidden clearfix" <?= (!$ccard) ? ' style="display: none;"' : '' ?>>
					<div class="address card_info clearfix">
						<div class="back_address_top">
						</div>

						<img class="secure" src="<?= $cfg->url->data ?>/checkout/secure.jpg" alt="secure" />

						<h5><?= $lng->text('checkout:sec_title1') ?></h5>
						<p class="secure"><b><?= $lng->text('checkout:sec_text1') ?></b></p>
						<h5><?= $lng->text('checkout:sec_title2') ?></h5>
						<p><?= $lng->text('checkout:sec_text2') ?></p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<div class="radio-list">
					<label class="radio-inline lbl_paypal">
						<input type="radio" name="payment_type" value="<?= $sale->payment_type_enum('paypal') ?>" <?= (!$ccard) ? ' checked="checked"' : '' ?> />
						<?= $lng->text('checkout:pay_paypal') ?></label>
				</div>
				<div class="cc_info cc_paypal">
					<p><?= $lng->text('checkout:cc_paypal') ?></p>
					<img alt="" src="/data/cart/cc_paypal.png" />					
					<div id="new_paypal" style="display: none;">
						<?= $tpl->get_view('paypal/new_paypal', array())  ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>