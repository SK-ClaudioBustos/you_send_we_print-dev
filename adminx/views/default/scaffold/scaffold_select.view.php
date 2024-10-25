<div class="form-group<?=(!empty($error)) ? ' has-error' : ''?><?=(!empty($disabled)) ? ' disabled' : ''?>">
	<?php if ($label !== false) { ?>
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '3'?> control-label lbl_<?=$field?><?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<?php } ?>
	<div class="col-sm-<?=(!empty($width)) ? $width : '8'?>">
		<select class="form-control select2" name="<?=$field?>" id="<?=str_replace('[]', '', $field)?>" data-placeholder=""<?=(!empty($attr) ? ' ' . $attr : '')?><?=($disabled) ? ' disabled="disabled"' : ''?><?=($multiple) ? ' multiple="multiple"' : ''?>>
			<?php if (isset($none_val)) { ?>
			<option value="<?=$none_val?>"><?=($none_text) ? '[' . $lng->text($none_text) . ']' : ''?></option>
			<?php } ?>
			<?php
			if (is_array($options)) {
				if (((bool)count(array_filter(array_keys($options), 'is_string'))) || $is_assoc) {
					// assoc array
					if (is_array($val)) {
						foreach($options as $key => $text) {
							?>
							<option value="<?=$key?>"<?=(in_array($key, $val)) ? ' selected="selected"' : ''?>><?=$text?></option>
							<?php
						}
					} else {
						foreach($options as $key => $text) {
							?>
							<option value="<?=$key?>"<?=($val == $key) ? ' selected="selected"' : ''?>><?=$text?></option>
							<?php
						}
					}

				} else {
					// standar array
					if (is_array($val)) {
						foreach($options as $text) {
							?>
							<option value="<?=$text?>"<?=(in_array($text, $val)) ? ' selected="selected"' : ''?>><?=$text?></option>
							<?php
						}
					} else {
						foreach($options as $text) {
							?>
							<option value="<?=$text?>"<?=($val == $text) ? ' selected="selected"' : ''?>><?=$text?></option>
							<?php
						}
					}
				}
			} else if (isset($options)) {
				$val_prop = ($val_prop) ? $val_prop : 'id';
				$txt_prop = ($txt_prop) ? $txt_prop : 'string';
				$iterator = ($iterator) ? $iterator : 'list_paged';

				if (is_array($val)) {
					while($options->{$iterator}()) {
						?>
						<option value="<?=$options->{'get_' . $val_prop}()?>"<?=(in_array($options->{'get_' . $val_prop}(), $val)) ? ' selected="selected"' : ''?>><?=$options->{'get_' . $txt_prop}()?></option>
						<?php
					}

				} else {
					while($options->{$iterator}()) {
						?>
						<option value="<?=$options->{'get_' . $val_prop}()?>"<?=($val == $options->{'get_' . $val_prop}()) ? ' selected="selected"' : ''?>><?=$options->{'get_' . $txt_prop}()?></option>
						<?php
					}
				}
			}
			?>
		</select>
		<p class="help-block <?=$help_class?>">
			<a class="sel_all" href="#"><?=$lng->text('scaffold:all')?></a> |
			<a class="sel_none" href="#"><?=$lng->text('scaffold:none')?></a>
		</p>
	</div>
</div>
