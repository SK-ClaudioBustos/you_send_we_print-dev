<div class="form-group measure_unit_ctm">
    <label class="col-xs-12 col-sm-4"><?=$lng->text('product:measures')?></label>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="width" id="width" class="form-control right" title="<?=$lng->text('product:width')?>" placeholder="<?=$lng->text('product:width')?>" maxlength="10" min="1" value="<?=($object->get_measure_unit() == 'ft') ? $object->get_width() / 12 : $object->get_width()?>" />
    </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="height" id="height" class="form-control right" title="<?=$lng->text('product:height')?>" placeholder="<?=$lng->text('product:height')?>" maxlength="10" min="1" value="<?=($object->get_measure_unit() == 'ft') ? $object->get_height() / 12 : $object->get_height()?>" />
    </div>
</div>