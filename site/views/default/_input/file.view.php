<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">

    <?php if ($width == 'full') { ?>
	<label class="lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<?php } else { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?><?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<?php } ?>

	<div class="col-sm-<?=(!empty($width)) ? $width : '6'?> fileinput-container">
		<div class="fileinput fileinput-new" data-provides="fileinput">
			<div class="input-group input-large">
				<div class="form-control uneditable-input" data-trigger="fileinput">
					<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename"> </span>
				</div>
				<span class="input-group-addon btn default btn-file">
					<span class="fileinput-new"><?=$lng->text('form:select')?></span>
					<span class="fileinput-exists"><?=$lng->text('form:change')?></span>
					<input type="file" name="<?=$field?>" id="<?=$field?>" />
				</span>
				<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"><?=$lng->text('form:remove')?></a>
			</div>
		</div>
	</div>
</div>
