<div class="form-group<?=(!empty($class)) ? ' ' . $class : ''?><?=(!empty($disabled)) ? ' disabled' : ''?><?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="col-sm-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label lbl_<?=$field?><?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>

	<div class="col-sm-6 radio-list">
		<?php
		$i = 0;
		if (is_array($options)) {
			if (((bool)count(array_filter(array_keys($options), 'is_string'))) || $is_assoc) {
				// assoc array
				foreach($options as $key => $text) {
					?>
					<label class="radio-inline">
						<input type="radio" name="<?=$field?>" id="<?=$field . '_' . $i?>" value="<?=$key?>"<?=($val == $key) ? ' checked="checked"' : ''?><?=($readonly && $val != $key) ? ' disabled' : ''?> />
						<?=$text?>
					</label>
					<?php
					$i++;
				}
			} else {
				// standar array
				foreach($options as $text) {
					?>
					<label class="radio-inline">
						<input type="radio" name="<?=$field?>" id="<?=$field . '_' . $i?>" value="<?=$text?>"<?=($val == $text) ? ' checked="checked"' : ''?><?=($readonly && $val != $text) ? ' disabled' : ''?> />
						<?=$text?>
					</label>
					<?php
					$i++;
				}
			}
		} else if (isset($options)) {
			$val_prop = ($val_prop) ? $val_prop : 'id';
			$txt_prop = ($txt_prop) ? $txt_prop : 'string';
			$iterator = ($iterator) ? $iterator : 'list_paged';

			while($options->{$iterator}()) {
				?>
				<label class="radio-inline">
					<input type="radio" name="<?=$field?>" id="<?=$field . '_' . $i?>" value="<?=$options->{'get_' . $val_prop}()?>"<?=($val == $options->{'get_' . $val_prop}()) ? ' checked="checked"' : ''?><?=($readonly && $val != $options->{'get_' . $val_prop}()) ? ' disabled' : ''?> />
					<?=$options->{'get_' . $txt_prop}()?>
				</label>
				<?php
			}
		}
		?>
	</div>
</div>
