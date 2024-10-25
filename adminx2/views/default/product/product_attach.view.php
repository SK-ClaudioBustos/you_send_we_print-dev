<ol class="clear_fix attach">
	<li class="medium">
		<label for="attach"><?=$lng->text('product:attach') . ' ' . $i?></label>
		<input type="file" name="attach<?=$i?>" id="attach<?=$i?>" />
	</li>
	<li class="medium">
		<label><?=$lng->text('product:current_attach')?></label>
		<span>
		<?php if (isset($attach[$i])) { ?>
		<a target="_blank" href="<?=$folder . $attach[$i]['file']?>"><b><?=$attach[$i]['file']?></b></a>
		<?php } else { echo '-'; } ?>
		</span>
	</li>
	<li class="medium">
		<label for="label"><?=$lng->text('product:label')?></label>
		<input type="text" name="label[]" id="label<?=$i?>" value="<?=$attach[$i]['label']?>" />
	</li>
	<li class="medium check">
		<input name="remove[]" id="remove<?=$i?>" type="checkbox" value="<?=$i?>" <?=(isset($attach[$i])) ? '' : 'disabled="disabled"'?> />
		<label for="remove" class="checkbox"><?=$lng->text('product:remove')?></label>
	</li>
</ol>
