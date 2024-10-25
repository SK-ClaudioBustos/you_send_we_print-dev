<div class="row">
	<div class="col-sm-offset-2 col-sm-10">
		<?php if (!$wait_approval) { ?>
		<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$submit_lbl?></button>
		<?php } else if ($wait_approval && $can_approve) { ?>
		<button type="button" class="btn green approve" data-href="<?=$app->go($app->module_key, false, '/approve/' . $object->get_id())?>"><i class="fa fa-check"></i> <?=$submit_lbl?></button>
		<?php } ?>
		<?php if ($reject_lbl) { ?>
		<button type="button" class="btn red reject" data-href="<?=$app->go($app->module_key, false, '/reject/' . $object->get_id())?>"><i class="fa fa-times"></i> <?=$reject_lbl?></button>
		<?php } ?>
		<button type="button" class="btn default cancel" data-href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></button>
	</div>
</div>
