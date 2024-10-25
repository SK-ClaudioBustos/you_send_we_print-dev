<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($readonly)) ? ' readonly' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">

    <?php if ($width == 'full') { ?>
    <label class="lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>

    <textarea name="<?=$field?>" id="<?=$field?>" cols="50" rows="5" class="form-control<?=(!empty($ta_class) ? ' ' . $ta_class : '')?>" <?=(!empty($attr) ? ' ' . $attr : '')?> <?=(!empty($readonly)) ? ' readonly="readonly"' : ''?>><?=$val?></textarea>

    <?php } else { ?>
    <label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><span class="required<?=($required) ? '' : ' no_visible'?>">*</span></label>

	<div class="col-sm-<?=(!empty($width)) ? $width : '6'?>">
		<textarea name="<?=$field?>" id="<?=$field?>" cols="50" rows="5" class="form-control<?=(!empty($ta_class) ? ' ' . $ta_class : '')?>"<?=(!empty($attr) ? ' ' . $attr : '')?><?=(!empty($readonly)) ? ' readonly="readonly"' : ''?>><?=$val?></textarea>
	</div>
    <?php } ?>
</div>
