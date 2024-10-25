<?php
// For language, the language file must be added after the datepicker plugin file and called in intance ***
?>
<div class="form-group<?=(!empty($error)) ? ' has-error' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?><?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : '<span class="no_visible">*</span>'?></label>
	<?php } ?>
	<div class="col-sm-<?=(!empty($width)) ? $width : '6'?>">
		<div class="input-group input-large date-picker input-daterange" data-date-language="<?=$cfg->setting->language?>"<?=($clear_btn) ? ' data-date-clear-btn="true"' : ''?> data-date-format="<?=$app->date_picker_format?>">
			<input type="text" class="form-control" name="<?=$field?>_from" id="<?=$field?>_from" value="<?=($val_from) ? date($app->date_format, strtotime($val_from)) : ''?>">
			<span class="input-group-addon"><?=$lng->text('form:to2')?></span>
			<input type="text" class="form-control" name="<?=$field?>_to" id="<?=$field?>_to" value="<?=($val_to) ? date($app->date_format, strtotime($val_to)) : ''?>">
		</div>
		<?php if (isset($help)) { ?>
		<span class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></span>
		<?php } ?>
	</div>
</div>
