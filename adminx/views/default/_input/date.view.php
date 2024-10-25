<?php
// For language, the language file must be added after the datepicker plugin file ***

$date_format = ($date_format) ? $date_format : $app->date_format;
?>
<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<?php } ?>
	<div class="col-sm-<?=(!empty($width)) ? $width : '3'?>">
		<div
				class="input-group input-small date<?=($readonly) ? '' : ' date-picker'?>"
				data-date-format="<?=($picker_format) ? $picker_format : $app->date_picker_format?>"
				data-date-language="<?=$cfg->setting->language?>"<?=($clear_btn) ? ' data-date-clear-btn="true"' : ''?>
				data-min-view-mode="<?=($view_mode) ? $view_mode : 0?>">

			<input type="text" name="<?=$field?>" id="<?=$field?>"
					readonly="readonly"<?=($disabled) ? ' disabled="disabled"' : ''?>
					class="form-control<?=($readonly) ? ' readonly' : ''?>" size="16"
					value="<?=($val && !in_array($val, array('0000-00-00', '0000-00-00 00:00:00'))) ? date($date_format, strtotime($val)) : ''?>">

			<span class="input-group-btn">
				<button type="button" class="btn default"<?=($readonly || $disabled) ? ' disabled' : ''?>><i class="fa fa-calendar"></i></button>
			</span>
		</div>
		<?php if (isset($help)) { ?>
		<span class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></span>
		<?php } ?>
	</div>
</div>

