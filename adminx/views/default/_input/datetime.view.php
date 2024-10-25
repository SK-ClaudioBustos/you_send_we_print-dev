<div class="form-group<?=(!empty($error)) ? ' has-error' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?><?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<?php } ?>
	<div class="col-xs-<?=(!empty($width)) ? $width : '3'?>">
		<div data-date-format="<?=$app->date_picker_format?>" class="input-group input-small date date-picker">
			<input type="text" name="<?=$field?>" id="<?=$field?>" readonly="" class="form-control" size="16" value="<?=($val) ? date($app->date_format, strtotime($val)) : ''?>">
			<span class="input-group-btn">
				<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
			</span>
		</div>

		<div data-date-format="<?=$app->date_picker_format?>" class="input-group input-small date date-picker">
			<input type="text" name="<?=$field?>" id="<?=$field?>" readonly="" class="form-control" size="16" value="<?=($val) ? date($app->date_format, strtotime($val)) : ''?>">
			<span class="input-group-btn">
				<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
			</span>
		</div>

		<?php if (isset($help)) { ?>
		<span class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></span>
		<?php } ?>
	</div>
</div>

