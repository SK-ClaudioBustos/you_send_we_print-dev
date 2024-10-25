<div class="row">
	<div class="col-sm-offset-3 col-sm-9">
		<?php if ($save !== false) { ?>
		<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text('form:save')?></button>
		<?php } ?>
		<a type="button" class="btn default cancel" href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></a>
	</div>
</div>
