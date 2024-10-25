<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'product:title', 'val' => $object->get_title(),
		'required' => true, 'error' => $object->is_missing('title')))?>
<?=$tpl->get_view('_input/select', array('field' => 'product_type', 'label' => 'product:product_type', 'val' => $object->get_product_type(),
		'required' => true, 'error' => $object->is_missing('product_type'), 'width' => 5, 'attr' => 'data-allow-clear="false"',
		'options' => $product_types, 'none_val' => '', 'none_text' => '', 'readonly' => ($object->get_id())))?>

<?php if ($object->get_id()) { ?>
	<?=$tpl->get_view('_input/text', array('field' => 'product_order', 'label' => 'product:categ_order', 'val' => $object->get_product_order(),
			'required' => true, 'error' => $object->is_missing('product_order'), 'width' => 'small', 
			'class' => 'number' . (($object->get_product_type() == 'category') ? '' : ' hidden')))?>

	<?php if (in_array($object->get_product_type(), array('product-single', 'product-multiple', 'subproduct'))) { ?>
		<?=$tpl->get_view('_input/text', array('field' => 'product_key', 'label' => 'product:product_key', 'val' => $object->get_product_key(),
				'required' => false, 'error' => $object->is_missing('product_key'), 'width' => 5, 'readonly' => true))?>

		<?=$tpl->get_view('_input/text', array('field' => 'product_code', 'label' => 'product:product_code', 'val' => $object->get_product_code(),
				'required' => false, 'error' => $object->is_missing('product_code'), 'width' => 'small'))?>
	<?php } ?>

	<?php if (in_array($object->get_product_type(), array('group', 'subproduct'))) { ?>
		<div class="form-group"></div>
		<?=$tpl->get_view('_input/select', array('field' => 'parent_id', 'label' => 'product:parent_key', 'val' => $object->get_parent_id(),
				'required' => true, 'error' => $object->is_missing('parent_id'),
				'options' => $parents, 'active_only' => false, 'none_val' => '', 'none_text' => ''))?>

	<?php } else if (in_array($object->get_product_type(), array('product-single', 'product-multiple'))) { ?>
		<div class="form-group"></div>
		<?=$tpl->get_view('_input/select', array('field' => 'group_id[]', 'label' => 'product:groups', 'val' => $product_groups,
				'required' => false, 'error' => $object->is_missing('parent_id'), 'options' => $parents, 'is_assoc' => true, 'multiple' => true))?>
		<div class="form-group"></div>
	<?php } ?>

	<?php if (in_array($object->get_product_type(), array('product-single', 'product-multiple', 'subproduct'))) { ?>
		<?=$tpl->get_view('_input/select', array('field' => 'measure_type', 'label' => 'product:measure_type', 'val' => $measure_type,
				'required' => true, 'error' => $object->is_missing('measure_type'), 'width' => 5, 'attr' => 'data-allow-clear="false"',
				'options' => $measure_types, 'none_val' => '', 'none_text' => '', 'readonly' => ($object->get_product_type() == 'subproduct')))?>
		<?=$tpl->get_view('_input/select', array('field' => 'standard_type', 'label' => 'product:standard_type', 'val' => $standard_type,
				'required' => true, 'error' => $object->is_missing('standard_type'), 'width' => 5, 'attr' => 'data-allow-clear="false"',
				'options' => $standard_types, 'none_val' => '', 'none_text' => '', 'readonly' => ($object->get_product_type() == 'subproduct')))?>
	<?php } ?>

	<?php if (in_array($object->get_product_type(), array('product-single', 'product-multiple'))) { ?>
		<div class="form-group"></div>
		<?=$tpl->get_view('_input/select', array('field' => 'disclaimer_id', 'label' => 'product:disclaimer', 'val' => $object->get_disclaimer_id(),
				'required' => false, 'error' => $object->is_missing('disclaimer_id'),
				'options' => $disclaimers, 'none_val' => '', 'none_text' => ''))?>
		<?=$tpl->get_view('_input/select', array('field' => 'featured', 'label' => 'product:featured', 'val' => $object->get_featured(),
				'required' => false, 'error' => $object->is_missing('featured'), 'width' => 'small',
				'options' => $featureds, 'none_val' => '', 'none_text' => ''))?>
	<?php } ?>
	<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'product:active', 'val' => 1, 'checked' => $object->get_active()))?>

	<?php 
		if ($object->get_product_type() =='group') {
			echo $tpl->get_view('_input/check', array('field' => 'group_home', 'label' => 'product:group_home', 'val' => 1, 'checked' => $object->get_group_home()));
		}
	?>
<?php } ?>


<?=''; //$tpl->get_view('_input/textarea', array('field' => 'form', 'label' => 'product:form', 'val' => $object->get_form(), 'required' => true, 'error' => $object->is_missing('form'), 'ta_class' => 'tinymce'))?>
