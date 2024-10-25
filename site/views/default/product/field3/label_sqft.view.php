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
