<?php
$sale_ship_address = $address_info['sale_ship_address'];
$sale_shipping = $address_info['sale_shipping'];

//print_r($sale_shipping->get_shipping_types());
//var_dump($sale_shipping);
//exit;
//$types = array();
//if ($shipping_types = $address_info['shipping_types']) {
//    $types = json_decode($shipping_types, true);
//}

$shipping_types = array();
if (sizeof($sale_shipping->get_shipping_types())) {
	foreach($sale_shipping->get_shipping_types() as $type => $rate) {
		$shipping_types[$type] = $type;
	}
}

//echo '////////////////////////' . $sale_shipping->get_shipping_type();
?>
<input type="hidden" name="sale_ship_address_id" id="sale_ship_address_id" value="<?=$sale_ship_address->get_id()?>" />

<div class="form-body">
	<?=$tpl->get_view('_input/check', array('field' => 'same_address', 'label' => 'checkout:same_address', 'val' => 1, 
			'checked' => ($sale_ship_address->get_same_address() == $sale_ship_address->same_address_enum('same_address'))))?>

	<div class="ship_address" <?=($sale_ship_address->get_same_address() == 1) ? ' style="display: none;"' : ''?>>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_last_name', 'label' => 'form:last_name', 
				'val' => $sale_ship_address->get_last_name(), 'required' => true, 'title' => 'form:last_name'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_address', 'label' => 'form:address', 
				'val' => $sale_ship_address->get_address(), 'required' => true, 'title' => 'form:address'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_city', 'label' => 'form:city', 
				'val' => $sale_ship_address->get_city(), 'required' => true, 'title' => 'form:city'))?>
		<?=$tpl->get_view('_input/select', array('field' => 'ship_state', 'label' => 'form:state', 
				'val' => $sale_ship_address->get_state(), 'required' => true, 'title' => 'form:state', 
				'options' => $app->states_short, 'none_val' => '', 'none_text' => '', 'width' => 'small'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_zip', 'label' => 'form:zip', 'width' => 'small', 
				'val' => $sale_ship_address->get_zip(), 'required' => true, 'title' => 'form:zip', 'attr' => 'autocomplete="off"'))?>
		<?=$tpl->get_view('_input/text', array('field' => 'ship_phone', 'label' => 'form:phone', 'width' => 3, 
				'val' => $sale_ship_address->get_phone(), 'required' => true, 'title' => 'form:phone'))?>
		<div class="form-group"></div>
	</div>	

	<div class="ship_type">	
		<?=$tpl->get_view('_input/select', array('field' => 'shipping_type', 'label' => 'product:ship_method', 
				'val' => $sale_shipping->get_shipping_type(), 'help' => 'checkout:select_zip',
				'required' => true, 'title' => 'product:ship_method', 'disabled' => (!sizeof($shipping_types)),
				'options' => $shipping_types, 'none_val' => '', 'none_text' => ''))?>

		<?=$tpl->get_view('_input/text', array('field' => 'ship_cost', 'label' => 'product:ship_cost', 
				'val' => number_format($sale_shipping->get_shipping_cost(), 2), 'title' => 'product:ship_cost',
				'readonly' => true, 'width' => 'small', 'class' => 'number'))?>
		<input type="hidden" name="shipping_cost" id="shipping_cost" value="<?=$sale_shipping->get_shipping_cost()?>" />
		<input type="hidden" name="shipping_weight" id="shipping_weight" value="<?=$sale->get_total_weight()?>" />
	</div>	
</div>	

<script>
	var _rates = <?=json_encode($sale_shipping->get_shipping_types())?>;
</script>