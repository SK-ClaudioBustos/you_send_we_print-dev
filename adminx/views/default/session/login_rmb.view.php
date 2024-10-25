<view key="body">
	<?php
	$alert = $msg = '';
	if ($login_var) {
		$alert = $login_var['alert'];
		$msg = $login_var['msg'];
	}
	?>
	<form class="form-vertical login-form" action="<?=$app->go('Session/login_rmb')?>" method="post">
		<h3 class="form-title"><?=$lng->text('login_rmb:title')?></h3>

		<p><?=$lng->text('login_rmb:text')?></p>

		<?php if ($alert) { ?>
		<div class="alert alert-<?=$alert?> alert-fail">
			<button class="close" data-dismiss="alert"></button>
			<span><?=$msg?></span>
		</div>
		<?php } ?>

		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('login:user')?></label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="<?=$lng->text('login:user')?>"
						name="username" value="<?=$app->username?>" readonly="readonly" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('login:password')?></label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="<?=$lng->text('login:password')?>" name="password"/>
			</div>
		</div>

		<div class="form-actions clearfix">
			<input type="hidden" name="action" value="login_rmb" />
			<input type="hidden" name="target" value="<?=$target?>" />
			<button type="submit" class="btn blue pull-right"><?=$lng->text('form:send')?> <i class="m-fa fa-swapright m-fa fa-white"></i></button>
		</div>
	</form>
</view>
