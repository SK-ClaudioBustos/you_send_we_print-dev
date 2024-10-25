<?php
$repeated = $image->get_repeated();
$disabled = ($repeated) ? ' disabled="disabled"' : '';
$filename = (strlen($filename = $image->get_filename()) > 50) ? substr($filename, 0, 48) . '&hellip;' : $filename;
?>
<div class="row uploadedItem<?=($repeated) ? ' repeated' : ''?>" id="img_<?=$image->get_id()?>">
	<div class="col-sm-6 uploadedInfo">
		<span class="fileName" title="<?=$image->get_filename()?>"><?=$filename?></span>
		<span class="fileSize">(<?=$utl->size_format($image->get_size())?>) - 100%</span>
		<span class="fileReady"><?=$lng->text(($repeated) ? 'product:file_exist' : 'product:file_uploaded')?></span>
		<a data-id="<?=$image->get_id()?>" href="<?=$app->go($app->module_key, false, '/ajax_remove')?>" class="remove"><?=$lng->text('product:upload_remove')?></a>
	</div>

	<div class="col-sm-6 product_form uploadedForm">
		<div class="row">
			<div class="form-group clearfix">
				<input type="hidden" name="image_id[]" value="<?=$image->get_id()?>" />
				<label class="col-sm-3" for="quantity_<?=$image->get_id()?>"><?=$lng->text('product:upload_partial_qty')?></label>

				<div class="col-sm-3">
					<input type="text" name="quantity[]" id="quantity_<?=$image->get_id()?>" class="form-control quantity small" maxlength="5" min="1" value="<?=$image->get_quantity()?>"<?=$disabled?> />
				</div>

				<div class="col-sm-6">
					<label><?=$lng->text('product:units')?></label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3" for="description_<?=$image->get_id()?>"><?=$lng->text('product:comments')?></label>
				<div class="col-sm-9">
					<textarea class="form-control" rows="5" cols="30" id="description_<?=$image->get_id()?>" name="description[]"<?=$disabled?>><?=$image->get_description()?></textarea>
				</div>
			</div>
		</div>
	</div>
</div>