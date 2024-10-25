<form class="form-vertical login-form captcha-form no-block" action="<?=$app->go('Session/login')?>" method="post">
	<?php
	$username = $remember = '';
	if ($login_var) {
		$username = $login_var['username'];
		$remember = ($login_var['remember']) ? ' checked="checked"' : '';
	}
	?>
	<?php if (!$offline) { ?>
	<div class="form-group">
		<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
		<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('form:username')?></label>
		<div class="input-icon">
			<i class="fa fa-user"></i>
			<input class="form-control placeholder-no-fix input-medium" type="text" autocomplete="off"
				placeholder="<?=$lng->text('form:username')?>" name="username" value="<?=$username?>" />
		</div>
	</div>

	<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('login:password')?></label>
		<div class="input-icon">
			<i class="fa fa-lock"></i>
			<input class="form-control placeholder-no-fix input-medium" type="password" autocomplete="off" placeholder="<?=$lng->text('login:password')?>" name="password"/>
		</div>
	</div>

	<div class="form-actions">
		<label class="checkbox">
			<input type="checkbox" name="remember" value="1" <?=($remember) ? ' checked="checked"' : ''?> /><?=$lng->text('login:remember')?>
		</label>

		<?php //=$tpl->get_view('_elements/token', array('token' => $login_token))?>
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="target" value="<?=$target?>" />

		<?php if ($publickey) { ?>
		<button class="btn yswp-red btn-outline g-recaptcha" data-sitekey="<?=$publickey?>" data-callback="cb_submit">
			<?=$lng->text('login:login')?> <i class="fa fa-arrow-circle-right"></i>
		</button>
		<?php } else { ?>
		<button type="submit" class="btn yswp-red btn-outline">
			<?=$lng->text('login:login')?> <i class="fa fa-arrow-circle-right"></i>
		</button>
		<?php } ?>
	</div>
	<?php } ?>
</form>
