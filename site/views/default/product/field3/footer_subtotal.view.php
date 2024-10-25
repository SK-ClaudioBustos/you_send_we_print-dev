<div class="form-group total">
    <div class="col-xs-12"><div class="sep-top"></div></div>
    <label class="col-xs-6 col-sm-4"><?=$lng->text('product:subtotal')?></label>
    <div class="hidden-xs col-sm-4">
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="product_subtotal" id="product_subtotal" class="form-control total right" title="<?=$lng->text('product:subtotal')?>" value="$ <?=number_format($object->get_product_subtotal(), 2)?>" readonly="readonly" />
    </div>
</div>

<div class="form-group total_gray">
    <label class="col-xs-6 col-sm-4"><?=$lng->text('product:quantity_discount')?></label>
    <div class="hidden-xs col-sm-4">
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="quantity_discount" id="quantity_discount" class="form-control total_gray right" title="<?=$lng->text('product:quantity_discount')?>" value="$ <?=number_format($object->get_quantity_discount(), 2)?>" readonly="readonly" />
    </div>
</div>

<div class="form-group total">
    <label class="col-xs-6 col-sm-4"><?=$lng->text('product:subtotal_discount')?></label>
    <div class="hidden-xs col-sm-4">
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="subtotal_discount" id="subtotal_discount" class="form-control total right" title="<?=$lng->text('product:subtotal_discount')?>" value="$ <?=number_format($object->get_subtotal_discount(), 2)?>" readonly="readonly" />
    </div>
    <span id="minimum" class="col-xs-12 help right"<?=($measure_type != 'custom' || $object->get_product_subtotal() >= $app->minimum || !$app->wholesaler_ok) ? ' style="display: none;"' : ''?>><em><?=$lng->text('product:minimum', $app->minimum)?></em></span>
</div>

<?php if ($measure_type != 'fixed' && $measure_type != 'shirts') { ?>
<div class="form-group total_light">
    <label class="col-xs-6 col-sm-4"><em><?=$lng->text('product:price_sqft')?></em></label>
    <div class="hidden-xs col-sm-4">
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="price_sqft" id="price_sqft" class="form-control total_light right" title="<?=$lng->text('product:price_sqft')?>" value="$ <?=number_format($object->get_price_sqft(), 2)?>" readonly="readonly" />
    </div>
</div>
<?php } ?>

<div class="form-group total_light">
    <label class="col-xs-6 col-sm-4"><em><?=$lng->text('product:price_piece')?></em></label>
    <div class="hidden-xs col-sm-4">
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="price_piece" id="price_piece" class="form-control total_light right" title="<?=$lng->text('product:price_piece')?>" value="$ <?=number_format($object->get_price_sqft(), 2)?>" readonly="readonly" />
    </div>
    <div class="col-xs-12"><div class="sep-bottom"></div></div>
</div>

