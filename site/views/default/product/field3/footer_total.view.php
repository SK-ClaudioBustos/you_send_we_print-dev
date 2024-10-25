<div class="form-group grand_total">
    <label class="col-xs-6 col-sm-4"><?=$lng->text('product:total')?></label>
    <div class="hidden-xs col-sm-4">
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="product_total" id="product_total" class="form-control grand_total right" title="<?=$lng->text('product:price_sqft')?>" value="$ <?=number_format((($app->wholesaler_ok) ? $object->get_product_total() : '0.00'), 2)?>" readonly="readonly" />
        <span id="loader hidden"></span>
   </div>
    <span class="col-xs-12 help right"><?=$lng->text('product:plus')?></span>
</div>

