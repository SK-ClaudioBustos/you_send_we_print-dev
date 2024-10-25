<?php
$info_title = $info['proof']['title'];
$info_text = html_entity_decode($info['proof']['info']);
?>

<div class="form-group total_gray">
    <label class="col-xs-5 col-sm-4"><?=$lng->text('product:proof')?>&nbsp;&nbsp;<a href="#" class="info" data-target="proof"><span class="badge badge-green">i</span></a></label>
    <div class="col-xs-1 col-sm-4">
        <input type="checkbox" name="proof" id="proof" value="1" <?=($object->get_proof()) ? ' checked="checked"' : ''?> />
   </div>
    <div class="col-xs-6 col-sm-4">
        <input type="text" name="proof_cost" id="proof_cost" class="form-control total_gray right" title="<?=$lng->text('product:proof_cost')?>" value="$ <?=number_format($object->get_proof_cost(), 2)?>" readonly="readonly" />
    </div>
    <div class="col-xs-12"><div class="sep-bottom"></div></div>
</div>

<div class="info info-proof">
    <div class="info-title"><?=$info_title?></div>
    <div class="info-text"><?=$info_text?></div>
</div>