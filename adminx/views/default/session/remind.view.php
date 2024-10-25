<form class="forget-form" action="<?=$app->go($app->module_key . '/remind')?>" method="post">
	<h3><?=$lng->text('remind:title')?></h3>
	<p><?=$lng->text('remind:text')?></p>
	<div class="form-group">
		<div class="input-icon">
			<i class="fa fa-envelope"></i>
			<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="<?=$lng->text('login:email')?>" name="email" />
		</div>
	</div>
	<div class="form-actions">
		<?=$tpl->get_view('_elements/token', array('token' => $token))?>
		<input type="hidden" name="action" value="remind" />
		<button type="button" id="back-btn" class="btn"><i class="m-icon-swapleft"></i> <?=$lng->text('form:back')?></button>
		<button type="submit" class="btn blue pull-right"><?=$lng->text('form:send')?> <i class="m-icon-swapright m-icon-white"></i></button>
	</div>
</form>
