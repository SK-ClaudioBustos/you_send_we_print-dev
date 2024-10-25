<?= $tpl->get_view('product/field2/product_list', array('field' => 'accesory1', 
		'object' => $object, 'lists' => $lists, 'item_list_key' => 'accessories-1', 'allow_none' => true, 'sep' => true, 
		'attr' => 'data-required="required" title="Accessory 1"', 'select2' => false))?>

<div class="form-group">
	    <label class="col-xs-12 col-sm-4" id='label_accessories-1'><?=$lng->text('product:quantity')?></label>
    <div class="col-xs-12 col-sm-4">
        <input type="text" name="accesory1_qty" id="accesory1_qty" class="form-control right" maxlength="5" reference="accesory1" title="<?=$lng->text('product:total_units')?> Accessory 1" value="" />
    </div>
        <div class="col-xs-12 col-sm-4">
          <span class="help" id='acc_quantity1' style='display:none; font-size:11px; margin-left:-6px; color:#6c9e2b'>Confirm required Quantity</span>
        </div>
</div>
