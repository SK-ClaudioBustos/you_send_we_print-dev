<div class="form-group<?=(!empty($error)) ? ' has-error' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?><?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<?php } ?>
	<div class="col-xs-<?=(!empty($width)) ? $width : '3'?>">
		<div class="input-group input-small">
			<input type="text" name="<?=$field?>" id="<?=$field?>" readonly="" class="form-control timepicker timepicker-24" value="<?=($val) ? date($app->time_format, strtotime($val)) : ''?>"<?=($readonly) ? ' data-readonly="readonly"' : ''?> />
			<span class="input-group-btn">
				<button type="button" class="btn default"<?=($readonly) ? ' disabled="disabled"' : ''?>><i class="fa fa-clock-o"></i></button>
			</span>
		</div>
		<?php if (isset($help)) { ?>
		<span class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></span>
		<?php } ?>
	</div>
</div>
