<?php
$subproduct = ($object->get_product_type() == 'subproduct');
$readonly = $subproduct;
$disc_label = 'product:discounts';
$disc_label_help = 'product:discount_help';

if ($subproduct) {
	if ($parent && $parent->get_measure_type() == 'fixd-fixd') {
		$discounts = $object->get_discounts();
		$readonly = false;
		$disc_label = 'product:fixed_qty';
		$disc_label_help = 'product:fixed_qty_help';

	} else {
		$discounts = ($parent) ? $parent->get_discounts() : '';
	}
	$turnarounds = ($parent) ? $parent->get_turnarounds() : '';


} else if ($object->get_product_type() == 'product-single') {
	if ($object->get_measure_type() == 'fixd-fixd') {
		$disc_label = 'product:fixed_qty';
		$disc_label_help = 'product:fixed_qty_help';
	}
	$discounts = $object->get_discounts();
	$turnarounds = $object->get_turnarounds();

} else {
	// product-multiple
	if ($object->get_measure_type() == 'fixd-fixd') {
		$readonly = true;
	}
	//$discounts = '';
	$discounts = $object->get_discounts();
	$turnarounds = $object->get_turnarounds();
}
?>
<?=$tpl->get_view('_input/label', ['field' => 'discount_by', 'val' => '', 'width' => 5])?>
<?=$tpl->get_view('_input/textarea', array('field' => 'discounts', 'label' => $disc_label, 'val' => $discounts,
		'required' => true, 'error' => $object->is_missing('discounts'), 'width' => 5, 'help' => $disc_label_help,
		'readonly' => $readonly))?>
<?=$tpl->get_view('_input/textarea', array('field' => 'turnarounds', 'label' => 'product:turnarounds', 'val' => $turnarounds,
		'required' => true, 'error' => $object->is_missing('turnarounds'), 'width' => 5, 'help' => 'product:turnaround_help',
		'readonly' => $subproduct))?>
