<?php
$val_prop = ($val_prop) ? $val_prop : 'id';
$txt_prop = ($txt_prop) ? $txt_prop : 'string';
?>
<div class="form-group<?=(!empty($error)) ? ' error' : ''?>">
	<label class="col-md-2 control-label<?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="col-md-<?=(!empty($width)) ? $width : '6'?>">
		<select class="form-control select2" name="<?=$field?>" id="<?=$field?>" data-placeholder=""<?=(!empty($attr) ? ' ' . $attr : '')?><?=($disabled) ? ' disabled="disabled"' : ''?>>
			<?php if (isset($none_val)) { ?>
			<option value="<?=$none_val?>"><?=($none_text) ? '[' . $lng->text($none_text) . ']' : ''?></option>
			<?php } ?>
			<?php while($options->list_paged()) { ?>
			<option value="<?=$options->{'get_' . $val_prop}()?>"<?=($val == $options->{'get_' . $val_prop}()) ? ' selected="selected"' : ''?>><?=$lng->text($options->{'get_' . $txt_prop}())?></option>
			<?php } ?>
		</select>
		<?php if (isset($help)) { ?>
		<p class="help-block <?=$help_class?>"><em><?=$lng->text($help)?></em></p>
		<?php } ?>
	</div>
</div>
