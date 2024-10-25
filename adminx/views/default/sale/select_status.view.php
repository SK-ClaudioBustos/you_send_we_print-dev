<div class="form-group<?=(!empty($error)) ? ' has-error' : ''?>">
	<label class="col-md-<?=(!empty($lbl_width)) ? $lbl_width : '2'?> control-label<?=($disabled) ? ' disabled' : ''?>" for="<?=$field?>" id="lbl_<?=$field?>"><?=($label) ? $lng->text($label) : ' '?><?=($required) ? '<span class="required">*</span>' : ''?></label>
	<div class="col-md-<?=(!empty($width)) ? $width : '6'?>">
		<select class="form-control select2" name="<?=$field?>" id="<?=$field?>" data-placeholder=""<?=(!empty($attr) ? ' ' . $attr : '')?><?=($disabled) ? ' disabled="disabled"' : ''?>>
			<?
			if ($select) {
				foreach($options as $key => $arr) {
					?>
					<option class="status-option <?=$key?>" value="<?=$key?>"<?=($arr[1]) ? ' selected="selected"' : ''?>><?=$arr[0]?></option>
					<?
				}
			} else {
				foreach($options as $key => $arr) {
					?>
					<option class="status-option <?=$key?>" value="<?=$key?>"><?=$arr[0]?></option>
					<?
				}
			}
			?>
		</select>
		<p class="help-block <?=$help_class?>">
			<a id="sel_all" href="#"><?=$lng->text('form:all')?></a> |
			<a id="sel_none" href="#"><?=$lng->text('form:none')?></a> |
			<a id="sel_def" href="#"><?=$lng->text('form:default')?></a>
		</p>
	</div>
</div>
