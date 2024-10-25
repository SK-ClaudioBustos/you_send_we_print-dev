<?=$tpl->get_view('product/field2/product_list', array('field' => 'accesory1', 'label' => 'product:accesory1',
		'object' => $object, 'lists' => $lists, 'item_list_key' => 'accesories', 'allow_none' => true, 'sep' => true, 
		'attr' => 'title="' . $lng->text('product:accesory1') . '" data-required="required"', 'select2' => false))?>

<div class="form-group">
    <div class="col-xs-12 col-sm-4">
	    <label class="total_units"><?=$lng->text('product:total_units')?> 1</label>
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="accesory1_qty" id="accesory1_qty" class="form-control right" maxlength="5" reference="accesory1" title="<?=$lng->text('product:total_units')?> 1" value="" />
    </div>
</div>

<?=$tpl->get_view('product/field2/product_list', array('field' => 'accesory2', 'label' => 'product:accesory2',
		'object' => $object, 'lists' => $lists, 'item_list_key' => 'accesories', 'allow_none' => true, 
		'attr' => 'title="' . $lng->text('product:accesory2') . '" data-required="required"', 'select2' => false))?>

<div class="form-group">
    <div class="col-xs-12 col-sm-4">
	    <label class="total_units"><?=$lng->text('product:total_units')?> 2</label>
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="accesory2_qty" id="accesory2_qty" class="form-control right" maxlength="5" reference="accesory2" title="<?=$lng->text('product:total_units')?> 2" value="" />
    </div>
</div>
