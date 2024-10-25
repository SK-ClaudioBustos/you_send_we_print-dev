<?=$tpl->get_view('product/field3/header_meas_' . $measure_type, array('object' => $object, 'product' => $product, 'parent' => $parent, 'info' => $info, 'sizes' => $sizes, 'measure_type' => $measure_type))?>
<?=$tpl->get_view('product/field3/header_quantity', array('object' => $object, 'product' => $product, 'parent' => $parent, 'info' => $info))?>

<?php if ($measure_type != 'fixed' && $measure_type != 'shirts') { ?>
<div class="form-group">
    <label class="col-xs-6 col-sm-4"><em><?=$lng->text('product:total_sqft')?></em></label>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="total_sqft" id="total_sqft" class="form-control total_light right" title="<?=$lng->text('product:total_sqft')?>" value="<?=number_format($object->get_total_sqft(), 2)?>" readonly="readonly" />
    </div>
    <div class="hidden-xs col-sm-4">
    </div>

	<?php if ($separator !== false) { ?>
    <div class="col-xs-12"><div class="sep-bottom"></div></div>
	<?php } ?>
</div>
<?php } else { ?>
<div class="form-group group-empty">
    <div class="col-xs-12"><div class="sep-bottom"></div></div>
</div>
<?php } ?>
<script type="text/javascript">
	var maximums = {};
</script>
