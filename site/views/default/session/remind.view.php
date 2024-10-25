<form class="forget-form no-block" action="<?=$app->go($app->module_key . '/remind')?>" method="post">
	<h3 class="remind-title"><?=$lng->text('remind:title')?></h3>
	<p><?=$lng->text('remind:text')?></p>
	<div class="form-group">
		<div class="input-icon">
			<i class="fa fa-envelope"></i>
			<input class="form-control placeholder-no-fix input-medium" type="text" autocomplete="off" placeholder="<?=$lng->text('form:email')?>" name="email" />
		</div>
	</div>
	<div class="form-actions">
		<?php //=$tpl->get_view('_elements/token', array('token' => $token))?>
		<input type="hidden" name="action" value="remind" />
		<button type="submit" class="btn yswp-red btn-outline"><?=$lng->text('form:send')?> <i class="fa fa-arrow-circle-right"></i></button>
	</div>
</form>
