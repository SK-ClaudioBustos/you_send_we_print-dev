<div class="row">
	<div class="col-sm-offset-2 col-sm-10">
		<?php if ($save !== false) { ?>
		<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text('form:save')?></button>
		<?php } ?>
		<button type="button" class="btn default cancel" data-href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></button>
	</div>
</div>
