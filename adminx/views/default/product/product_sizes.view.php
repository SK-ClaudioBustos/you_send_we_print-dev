<?php
$size_format = array(
	's' => $lng->text('product:square'),
	'r' => $lng->text('product:rectangular'),
	'o' => $lng->text('product:rounded'),
	'p' => $lng->text('product:panoramic'),
);
$size_format_shirts = [
	'n' => $lng->text('product:shirt_n'),
	'h' => $lng->text('product:shirt_h'),
	's' => $lng->text('product:shirt_s'),
	'm' => $lng->text('product:shirt_m'),
	'l' => $lng->text('product:shirt_l'),
	'xl' => $lng->text('product:shirt_xl'),
];

if ($object->get_product_type() == 'subproduct') {
	$product_parent = new Product();
	$product_parent->retrieve($object->get_parent_id(), false);
	if ($product_parent->get_measure_type() == "shirts")
		$size_format = $size_format_shirts;
}
if ($object->get_measure_type() == "shirts")
	$size_format = $size_format_shirts;


?>

<div class="col-sm-12">
	<div class="row">

		<div class="col-sm-6">
			<div class="form-group">
				<label class="col-sm-6 control-label lbl_sizes" for="sizes" id="lbl_sizes">
					<?= $lng->text('product:sizes_list') ?><span class="required no_visible">*</span></label>

				<div class="col-sm-6">
					<select class="form-control" name="sizes" id="sizes" size="22">
						<option value="" selected="selected">[ <?= $lng->text('product:sizes_list') ?> ]</option>
						<?php
						$size_arr = array();
						while ($sizes->list_paged()) {
							$size_arr[$sizes->get_id()] = $sizes->to_array();
							$value = strtoupper($sizes->get_format())
								. '&nbsp;&nbsp;|&nbsp;&nbsp;' . (($sizes->get_width() < 10) ? '&nbsp;&nbsp;' : '') . $sizes->get_width()
								. ' x ' . (($sizes->get_height() < 10) ? '&nbsp;&nbsp;' : '') . $sizes->get_height() . '"'
								. (($sizes->get_price_a() > 0)
									? '&nbsp;&nbsp;|&nbsp;&nbsp;' . (($sizes->get_price_a() < 100) ? '&nbsp;&nbsp;' : '') . $sizes->get_price_a()
									: '');
							echo '<option value="' . $sizes->get_id() . '">' . $value . '</option>';
						}
						?>
					</select>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<?= $tpl->get_view('_input/select', array(
				'field' => 'format', 'label' => 'product:format', 'val' => 'square',
				'required' => true, 'error' => $object->is_missing('format'),
				'options' => $size_format, 'width' => 'small', 'attr' => 'data-allow-clear="false"'
			)) ?>
			<?= $tpl->get_view('_input/text', array(
				'field' => 'size_width', 'label' => 'product:width', 'val' => '',
				'required' => true, 'error' => $object->is_missing('width'), 'width' => 'small', 'class' => 'number'
			)) ?>
			<?= $tpl->get_view('_input/text', array(
				'field' => 'size_height', 'label' => 'product:height', 'val' => '',
				'required' => true, 'error' => $object->is_missing('height'), 'width' => 'small', 'class' => 'number'
			)) ?>

			<?= $tpl->get_view('_input/text', array(
				'field' => 'price_a', 'label' => 'product:price', 'val' => '',
				'required' => true, 'error' => $object->is_missing('price_a'), 'width' => 'small',
				'class' => 'number' . (($object->get_standard_type() == 'fixed' || $provider_id) ? '' : ' hidden')
			)) ?>

			<?= $tpl->get_view('_input/text', array(
				'field' => 'provider_price', 'label' => 'product:provider_price', 'val' => '',
				'required' => true, 'error' => $object->is_missing('provider_price'), 'width' => 'small',
				'class' => 'number' . (($provider_id) ? '' : ' hidden')
			)) ?>
			<?= $tpl->get_view('_input/text', array(
				'field' => 'provider_weight', 'label' => 'product:provider_weight', 'val' => '',
				'required' => true, 'error' => $object->is_missing('provider_weight'), 'width' => 'small',
				'class' => 'number' . (($provider_id) ? '' : ' hidden')
			)) ?>

			<?= $tpl->get_view('_input/text', array(
				'field' => 'price_b', 'label' => 'product:price_b', 'val' => '',
				'required' => true, 'error' => $object->is_missing('price_b'), 'width' => 'small',
				'class' => 'number' . (($object->get_standard_type() == 'fixed') ? '' : ' hidden')
			)) ?>
			<?= $tpl->get_view('_input/text', array(
				'field' => 'price_c', 'label' => 'product:price_c', 'val' => '',
				'required' => true, 'error' => $object->is_missing('price_c'), 'width' => 'small',
				'class' => 'number' . (($object->get_standard_type() == 'fixed') ? '' : ' hidden')
			)) ?>

			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<input type="button" id="update" class="btn grey-cascade" value="<?= $lng->text('form:update') ?>" />
					<input type="button" id="delete" class="btn default" value="<?= $lng->text('form:delete') ?>" disabled="disabled" />
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
	var $sizes = <?= json_encode($size_arr) ?>;
	var $sizes_mod = {};
	var $delete_msg = '<?= $lng->text('form:delete_msg') ?>';
</script>