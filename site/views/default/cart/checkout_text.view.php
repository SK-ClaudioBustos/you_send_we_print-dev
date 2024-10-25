<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($readonly)) ? ' readonly' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">

    <?php if ($width == 'full') { ?>
	<label class="lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>

    <?php if (isset($icon)) { ?>
    <div class="input-icon">
        <i class="fa <?=$icon?><?=(isset($icon_class) ? ' ' . $icon_class : '')?>" <?=(isset($icon_title) ? ' title="' . $icon_title . '"' : '')?>></i>
        <input type="<?=(!empty($type)) ? $type : 'text'?>" class="form-control<?=(in_array($width, array('small', 'medium'))) ? ' input-' . $width : ''?>" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>" <?=(!empty($attr)) ? ' ' . $attr : ''?> <?=(!empty($disabled)) ? ' disabled="disabled"' : ''?> <?=(!empty($readonly)) ? ' readonly="readonly"' : ''?><?=($required) ? ' data-required="required"' : ''?><?=($title) ? ' title="' . $lng->text($title) . '"' : ''?> />
    </div>
	<?php } else { ?>
    <input type="<?=(!empty($type)) ? $type : 'text'?>" class="form-control<?=($width == 'small') ? ' input-small' : ''?>" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>" <?=(!empty($attr)) ? ' ' . $attr : ''?> <?=(!empty($disabled)) ? ' disabled="disabled"' : ''?> <?=(!empty($readonly)) ? ' readonly="readonly"' : ''?><?=($required) ? ' data-required="required"' : ''?><?=($title) ? ' title="' . $lng->text($title) . '"' : ''?> />
	<?php } ?>

	<?php } else { ?>
    <label class="col-xs-4 col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>
	
	<div class="col-xs-8 col-sm-<?=(!empty($width) && !in_array($width, array('small', 'medium'))) ? $width : '8'?>">

		<?php if (isset($icon)) { ?>
		<div class="input-icon">
			<i class="fa <?=$icon?><?=(isset($icon_class) ? ' ' . $icon_class : '')?>"<?=(isset($icon_title) ? ' title="' . $icon_title . '"' : '')?>></i>
			<input type="<?=(!empty($type)) ? $type : 'text'?>" class="form-control<?=(in_array($width, array('small', 'medium'))) ? ' input-' . $width : ''?>" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>"<?=(!empty($attr)) ? ' ' . $attr : ''?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?><?=($required) ? ' data-required="required"' : ''?><?=($title) ? ' title="' . $lng->text($title) . '"' : ''?> />
		</div>
		<?php } else { ?>
		<input type="<?=(!empty($type)) ? $type : 'text'?>" class="form-control<?=($width == 'small') ? ' input-small' : ''?>" name="<?=$field?>" id="<?=$field?>" value="<?=$val?>"<?=(!empty($attr)) ? ' ' . $attr : ''?><?=(!empty($disabled)) ? ' disabled="disabled"' : ''?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?><?=($required) ? ' data-required="required"' : ''?><?=($title) ? ' title="' . $lng->text($title) . '"' : ''?> />
		<?php } ?>

		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } else if (isset($help_text)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$help_text?></em></p>
		<?php } ?>

	</div>
    <?php } ?>

</div>
