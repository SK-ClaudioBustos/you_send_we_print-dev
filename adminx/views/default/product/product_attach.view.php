<div class="row">
	<div class="col-sm-6">
		<?=$tpl->get_view('_input/file', array('field' => 'attach' . $i,
				'label' => 'product:attach' . $i, 'val' => '', 'required' => false))?>
		<?=$tpl->get_view('_input/text', array('field' => 'label', 'name' => 'label[]',
				'label' => 'product:label', 'val' => $attach[$i]['label'], 'required' => false, 'width' => 9))?>
	</div>
	<div class="col-sm-6">
		<?php if (isset($attach[$i])) { ?>
		<?=$tpl->get_view('_input/file_download', array('field' => 'current' . $i, 'label' => 'product:current_attach', 
				'val' => $attach[$i]['file'], 'readonly' => true, 'url' => $folder . $attach[$i]['file']
			))?>

		<?=$tpl->get_view('_input/check', array('field' => 'remove' . $i, 'label' => 'product:remove', 'val' => 1))?>
		<?php } ?>
	</div>
</div>
<div class="form-group"></div>

<?php
/*
		<?=$tpl->get_view('_input/text', array('field' => 'prj_task_attach', 'name' => 'task_attach', 
				'label' => 'product:current_attach', 'val' => '', 'required' => false, 'width' => 9))?>


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
*/
?>