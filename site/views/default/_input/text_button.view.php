<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	<?php } ?>
	<div class="col-sm-<?=(!empty($width) && $width != 'small') ? $width : '6'?>">
		<div class="input-group<?=($width == 'small') ? ' input-small' : ''?>">
			<input type="<?=(!empty($type)) ? $type : 'text'?>" class="form-control" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>"<?=(!empty($attr)) ? ' ' . $attr : ''?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?> />
			<span class="input-group-btn">
				<?php if ($href) { ?>
				<a href="<?=$href?>" id="btn_<?=$field?>" class="btn <?=($btn_color) ? $btn_color : 'default'?>" title="<?=$lng->text($btn_title)?>"><i class="fa fa-<?=$btn_icon?>"></i></a>
				<?php } else { ?>
				<button type="button" id="btn_<?=$field?>" class="btn <?=($btn_color) ? $btn_color : 'default'?>" title="<?=$lng->text($btn_title)?>"<?=(!empty($btn_attr)) ? ' ' . $btn_attr : ''?><?=(!empty($disabled) || !empty($btn_disabled)) ? ' disabled="disabled"' : ''?>><i class="fa fa-<?=$btn_icon?>"></i></button>
				<?php } ?>
			</span>
		</div>
		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } else if (isset($help_text)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$help_text?></em></p>
		<?php } ?>
	</div>
</div>
