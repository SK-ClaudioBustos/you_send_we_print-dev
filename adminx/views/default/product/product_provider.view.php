<?php
$disabled = true;
if (($object->get_product_type() == 'product-single' && $object->get_measure_type() == 'standard')
		|| ($object->get_product_type() == 'subproduct' && $parent && $parent->get_measure_type() == 'standard')) {
	$disabled = false;
}
?>
<div class="form-group">
	<div class="col-md-offset-3 col-md-9">
		<p><?=$lng->text('product:provider_active')?></p>
	</div>
</div>

<?=$tpl->get_view('_input/select', array('field' => 'provider_id', 'label' => 'product:provider', 'val' => $object->get_provider_id(),
		'required' => false, 'error' => $object->is_missing('provider_id'),
		'options' => $providers, 'none_val' => '', 'none_text' => '', 'disabled' => $disabled))?>
<?=$tpl->get_view('_input/text', array('field' => 'provider_name', 'label' => 'product:provider_name', 'val' => $object->get_provider_name(),
		'required' => false, 'error' => $object->is_missing('provider_name'), 'disabled' => $disabled))?>
<?=$tpl->get_view('_input/text', array('field' => 'provider_code', 'label' => 'product:provider_code', 'val' => $object->get_provider_code(),
		'required' => false, 'error' => $object->is_missing('provider_code'), 'width' => 'small', 'disabled' => $disabled))?>
<?=$tpl->get_view('_input/text', array('field' => 'provider_url', 'label' => 'product:provider_url', 'val' => $object->get_provider_url(),
		'required' => false, 'error' => $object->is_missing('provider_url'), 'disabled' => $disabled))?>
