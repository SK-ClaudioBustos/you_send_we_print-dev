<?php
$ws = $wholesaler['wholesaler'];

$info_title = $info['shipping']['title'];
$info_text = html_entity_decode($info['shipping']['info']);

$sale_address = $wholesaler['sale_address'];
$other_addresses = $wholesaler['other_addresses'];

$states = array('--' => '[' . $lng->text('wholesaler:outside') . ']') + $app->states;

$addresses = array();
$others = array();
while ($other_addresses->list_paged()) {
	$addresses[(string)$other_addresses->get_id()] = array('zip' => $other_addresses->get_ship_zip(), 'address' => $other_addresses->get_full_address(true));
	$others[(string)$other_addresses->get_id()] = $other_addresses->get_full_address();
	$selected = (($sale_address->get_other_address_id() == $other_addresses->get_id()) ? ' selected="selected"' : '');
}
$json_addresses = json_encode($addresses);

?>

<?= $tpl->get_view(
	'_input/hidden',
	[
		'field' => 'isBillable',
		'val' => ($wholesaler['isBillable']) ? '1' : '0'
	]
) ?>

<?php if (!$wholesaler['isBillable']) { ?>
	<div class="form-group" style="display: <?= ($app->wholesaler_ok) ? 'block' : 'none' ?>;">
		<div class="col-xs-12">
			<div class="sep-top top-shipping"></div>
		</div>
		<label class="col-sm-4"><?= $lng->text('product:bill_address') ?></label>
		<div class="col-sm-8">
			<div class="radio-list shipping_address clearfix">
				<div class="clear_fix">
					<div class="row address_form">
						<?= $tpl->get_view('_input/text', array(
							'field' => 'bill_last_name', 'label' => 'wholesaler:last_name',
							'val' => $ws->get_last_name(), 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:last_name') . '"'
						)) ?>
						<?= $tpl->get_view('_input/text', array(
							'field' => 'bill_address', 'label' => 'wholesaler:address',
							'val' => $ws->get_bill_address(), 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:address') . '"'
						)) ?>
						<?= $tpl->get_view('product/select', array(
							'field' => 'bill_country', 'label' => 'wholesaler:country',
							'none_val' => '', 'none_text' => '',
							'is_assoc' => true,
							'val' => $ws->get_bill_country(), 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:country') . '"',
							'options' => $countries,
						)) ?>
						<?= $tpl->get_view('_input/text', array(
							'field' => 'bill_zip', 'label' => 'wholesaler:zip',
							'val' => $ws->get_bill_zip(), 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:zip') . '"'
						)) ?>
						<?= $tpl->get_view('_input/text', array(
							'field' => 'bill_city', 'label' => 'wholesaler:city',
							'val' => $ws->get_bill_city(), 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:city') . '"'
						)) ?>
						<?= $tpl->get_view('product/select', array(
							'field' => 'bill_state', 'label' => 'wholesaler:state',
							'none_val' => '', 'none_text' => '', 'val' => $ws->get_bill_state(),
							'required' => true, 'lbl_width' => 4, 'width' => 8, 'options' => $states
						)) ?>
						<?= /*$tpl->get_view('_input/text', array(
							'field' => 'ship_phone', 'label' => 'wholesaler:phone',
							'val' => $ws->get_bill_phone(), 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:phone') . '"'
						)) */ '' ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="form-group">
	<div class="col-xs-12">
		<div class="sep-top top-shipping"></div>
	</div>
	<label class="col-sm-4"><?= $lng->text('product:ship_address') ?></label>
	<div class="col-sm-8">
		<div class="radio-list shipping_address clearfix">
			<label>
				<input type="radio" name="shipping_address" id="local_pickup" class="shipping_address" value="<?= $sale_address->address_ws_enum('none') ?>" <?= ($sale_address->get_address_ws() == $sale_address->address_ws_enum('none')) ? ' checked="checked"' : '' ?> />
				<?= $lng->text('product:local_pickup') ?>

				<input type="hidden" name="sale_address_id" value="<?= $sale_address->get_id() ?>" />
				<input type="hidden" name="zip_code" id="zip_code" value="<?= $sale_address->get_zip() ?>" />
			</label>
			<?php //echo $_SESSION[isbulk]=""; 
			if (!$wholesaler['isBillable'] && $_SESSION["isbulk"]!="isbulk") { ?>
				<label id='same_billing_address' class="hidden">
					<input type="radio" name="shipping_address" id="same_billing_address" class="shipping_address" value="1" />
					<?= $lng->text('product:ship_same') ?>
					<input type="hidden" name="default_zip" id="default_zip" value="<?= $ws->get_bill_zip() ?>" />
				</label>
			<?php } ?>

			<?php if ($ws->get_bill_country() == 44 && $wholesaler['isBillable'] && $_SESSION["isbulk"]!="isbulk"
			) { // US 
			?>
				<label>
					<input type="radio" name="shipping_address" id="shipping_address" class="shipping_address" value="<?= $sale_address->address_ws_enum('default') ?>" <?= ($sale_address->get_address_ws() == $sale_address->address_ws_enum('default')) ? ' checked="checked"' : '' ?> />
					<?= $lng->text('product:ship_default') ?>
					| <a href="#" id="ship_show"><?= $lng->text('product:ship_show') ?> <i class="fa fa-angle-down"></i></a>
				</label>
				<div class="ship_hidden" id="ship_default">
					<div class="address">
						<p><?= $wholesaler['default_address'] ?></p>
						<input type="hidden" name="default_zip" id="default_zip" value="<?= $wholesaler['default_zip'] ?>" />
					</div>
				</div>

				<label <?= ($other_addresses->list_count()) ? '' : ' style="display: none;"' ?>>
					<input type="radio" name="shipping_address" id="shipping_other" class="shipping_address" value="<?= $sale_address->address_ws_enum('other') ?>" <?= ($sale_address->get_address_ws() == $sale_address->address_ws_enum('other')) ? ' checked="checked"' : '' ?> />
					<?= $lng->text('product:ship_other') ?>
				</label>
				<div class="ship_hidden" <?= ($sale_address->get_address_ws() == $sale_address->address_ws_enum('other')) ? ' style="display: block;"' : '' ?>>
					<div class="address_list">
						<?= $tpl->get_view('product/select_control', array(
							'label' => false,
							'field' => 'ship_other',
							'options' => $others,
							'is_assoc' => true,
							'val' => $selected,
							'attr' => 'data-required="' . $lng->text('product:ship_other_pick') . '" title="' . $lng->text('product:ship_other_list') . '"',
						)) ?>
					</div>
					<div class="address">
						<p id="other_address"><?= ($id = $sale_address->get_other_address_id()) ? $addresses[(string)$id] : '' ?></p>
					</div>
				</div>

				<script type="text/javascript">
					var addresses = <?= $json_addresses ?>;
				</script>

				<label class="new_address">
					<input type="radio" name="shipping_address" id="new_address" class="shipping_address" value="<?= $sale_address->address_ws_enum('new') ?>" <?= ($sale_address->get_address_ws() == $sale_address->address_ws_enum('new')) ? ' checked="checked"' : '' ?> />
					<?= $lng->text('product:ship_change') ?>
				</label>
				<div class="ship_hidden clear_fix" <?= ($sale_address->get_address_ws() == $sale_address->address_ws_enum('new')) ? ' style="display: block;"' : '' ?>>
					<div class="row address_form">
						<?= $tpl->get_view('_input/text', array(
							'field' => 'ship_last_name', 'label' => 'wholesaler:last_name',
							'val' => '', 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:last_name') . '"'
						)) ?>
						<?= $tpl->get_view('_input/text', array(
							'field' => 'ship_address', 'label' => 'wholesaler:address',
							'val' => '', 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:address') . '"'
						)) ?>
						<?= $tpl->get_view('_input/text', array(
							'field' => 'ship_zip', 'label' => 'wholesaler:zip',
							'val' => '', 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:zip') . '"'
						)) ?>
						<?= $tpl->get_view('_input/text', array(
							'field' => 'ship_city', 'label' => 'wholesaler:city',
							'val' => '', 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:city') . '"'
						)) ?>
						<?= $tpl->get_view('product/select', array(
							'field' => 'ship_state', 'label' => 'wholesaler:state',
							'none_val' => '', 'none_text' => '', 'val' => $sale_address->get_state(),
							'required' => true, 'lbl_width' => 4, 'width' => 8, 'options' => $app->states
						)) ?>
						<?= $tpl->get_view('_input/text', array(
							'field' => 'ship_phone', 'label' => 'wholesaler:phone',
							'val' => '', 'required' => true, 'lbl_width' => 4, 'width' => 8,
							'attr' => 'data-required="required" title="' . $lng->text('wholesaler:phone') . '"'
						)) ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<div class="shipping_type" <?= ($sale_address->get_address_ws() == $sale_address->address_ws_enum('none')) ? ' style="display: none;"' : '' ?>>
	<div class="form-group">
		<label class="col-sm-4"><?= $lng->text('product:ship_method') ?>&nbsp;&nbsp;<a href="#" class="info" data-target="shipping"><span class="badge badge-green">i</span></a></label>
		<div class="col-sm-8">
			<?= $tpl->get_view('_input/select_control', array(
				'label' => false,
				'field' => 'shipping_type',
				'attr' => 'data-required="required" title="' . $lng->text('product:ship_method') . '"',
			)) ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-4">
		</div>
		<div class="col-sm-4">
		</div>
		<div class="col-sm-4">
			<input type="text" name="shipping_cost" id="shipping_cost" class="form-control total_gray right" title="<?= $lng->text('product:shipping_costs') ?>" value="$ <?= number_format($object->get_shipping_cost(), 2) ?>" readonly="readonly" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4"><em><?= $lng->text('product:ship_weight') ?></em></label>
		<div class="col-sm-4">
		</div>
		<div class="col-sm-4">
			<input type="text" name="ship_weight" id="shipping_weight" class="form-control total_light right" title="<?= $lng->text('product:price_piece') ?>" value="<?= number_format($object->get_shipping_weight(), 2) ?> lb" readonly="readonly" />
		</div>
	</div>
</div>

<div class="info info-shipping">
	<div class="info-title"><?= $info_title ?></div>
	<div class="info-text"><?= $info_text ?></div>
</div>