<?php
$trimming_title = $info['trimming']['title'];
//$trimming_text = html_entity_decode($info['trimming']['info']);
?>

<div class="form-group">
    <div class="col-sm-12"><div class="sep-top"></div></div>

	<label class="col-sm-4 lbl_cutting" for="cutting" id="lbl_cutting"><?=$lng->text('product:trimming')?>&nbsp;&nbsp;<a href="#" class="info" data-target="trimming"><span class="badge badge-green">i</span></a></label>
	<div class="col-sm-8">

		<select name="cutting" id="cutting" class="form-control select2 product_list" data-required="required" title="<?=$lng->text('product:trimming')?>">
			<option value="" disabled="disabled" selected="selected" style="display: none;"></option>
		</select>

	</div>
</div>

<div class="info info-trimming">
    <div class="info-title"><?=$trimming_title?></div>
    <div class="info-text"></div>
</div>
