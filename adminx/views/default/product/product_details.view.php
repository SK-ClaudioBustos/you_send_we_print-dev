<?php
$disabled = true;
if (($object->get_product_type() == 'product-single' && in_array($object->get_measure_type(), array('fixed', 'fixd-fixd')))
	|| ($object->get_product_type() == 'subproduct' && in_array($object->get_measure_type(), array('fixed', 'fixd-fixd')))
) {
	$disabled = false;
}
$date = date_create($object->get_price_date());
$date_f = date_format($date, "m/d/Y") == '11/30/-0001' ? '00-00-0000' : date_format($date, "m/d/Y");
?>

<?= $tpl->get_view('_input/text', array(
	'field' => 'base_price', 'label' => 'product:base_price', 'val' => $object->get_base_price(),
	'required' => true, 'error' => $object->is_missing('base_price'), 'width' => 'small', 'class' => 'number','help' =>
	'product:price_base_help', 'inline' => true
)) ?>
<?= $tpl->get_view('_input/text', array(
	'field' => 'setup_fee', 'label' => 'product:setup_fee', 'val' => $object->get_setup_fee(),
	'required' => true, 'error' => $object->is_missing('setup_fee'), 'width' => 'small', 'class' => 'number', 'help' =>
	'product:price_setup_help', 'inline' => true
)) ?>
<?= $tpl->get_view('_input/text', array(
	'field' => 'price_from', 'label' => 'product:price_from', 'val' => $object->get_price_from(),
	'required' => true, 'error' => $object->is_missing('price_from'), 'width' => 'small', 'class' => 'number',
	'help' => 'product:price_from_help', 'inline' => true, 'disabled' => ($object->get_product_type() != 'subproduct')
)) ?>
<?= $tpl->get_view('_input/text', array(
	'field' => 'minimum', 'label' => 'product:minimum', 'val' => $object->get_minimum(),
	'required' => true, 'error' => $object->is_missing('minimum'), 'width' => 'small', 'class' => 'number',	'help' =>
	'product:price_minimum_help', 'inline' => true
)) //'help' => 'product:minimum_help', 'inline' => true, 'disabled' => ($object->get_product_type() == 'subproduct')
?>
<?= $tpl->get_view('_input/text', array(
	'field' => 'price_date', 'label' => 'product:date', 'val' => $date_f,
	'required' => false, 'width' => 'small', 'readonly' => true, 'disabled' => true, 'class' => 'number'
)) ?>
<?= $tpl->get_view('_input/text', array(
	'field' => 'weight', 'label' => 'product:base_weight', 'val' => $object->get_weight(),
	'required' => true, 'error' => $object->is_missing('weight'), 'width' => 'small', 'class' => 'number',
	'help' => 'form:pounds', 'inline' => true
)) ?>
<div class="form-group"></div>

<?= $tpl->get_view('_input/text', array(
	'field' => 'width', 'label' => 'product:width', 'val' => $object->get_width(),
	'required' => true, 'error' => $object->is_missing('width'), 'width' => 'small', 'class' => 'number',
	'help' => 'product:measure_help', 'inline' => true, 'disabled' => $disabled
)) ?>
<?= $tpl->get_view('_input/text', array(
	'field' => 'height', 'label' => 'product:height', 'val' => $object->get_height(),
	'required' => true, 'error' => $object->is_missing('height'), 'width' => 'small', 'class' => 'number',
	'help' => 'form:inches', 'inline' => true, 'disabled' => $disabled
)) ?>
<div class="form-group"></div>

<?= $tpl->get_view('_input/check', array('field' => 'use_stock', 'label' => 'product:use_stock', 'val' => 1, 'checked' => $object->get_use_stock())) ?>
<?= $tpl->get_view('_input/text', array(
	'field' => 'stock_min', 'label' => 'product:stock_min', 'val' => $object->get_stock_min(),
	'required' => true, 'error' => $object->is_missing('stock_min'), 'width' => 'small', 'class' => 'number',
	'disabled' => (!$object->get_use_stock())
)) ?>

<?= ''; //$tpl->get_view('_input/text', array('field' => 'volume', 'label' => 'product:volume', 'val' => $object->get_volume(), 'required' => true, 'error' => $object->is_missing('volume'), 'width' => 'small', 'class' => 'number'))
?>
<?= ''; //$tpl->get_view('_input/textarea', array('field' => 'attachment', 'label' => 'product:attachment', 'val' => $object->get_attachment(), 'required' => true, 'error' => $object->is_missing('attachment'), 'ta_class' => 'tinymce'))
?>
<?= ''; //$tpl->get_view('_input/text', array('field' => 'minimum', 'label' => 'product:minimum', 'val' => $object->get_minimum(), 'required' => true, 'error' => $object->is_missing('minimum'), 'width' => 'small', 'class' => 'number'))
?>