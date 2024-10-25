<view key="body">
	<?php
	$username = $remember = $alert = '';
	if ($login_var) {
		$offline =  $login_var['offline'];

		if (!$signup) {
			// login
			$username = $login_var['username'];
			$remember = ($login_var['remember']) ? ' checked="checked"' : '';
		}
		$alert = $login_var['alert'];
		$msg = $login_var['msg'];
	}

	if ($publickey) {
		?>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<?php
	}
	?>

	<?php if (!$signup) { ?>
	<form class="form-vertical login-form" action="<?=$app->go()?>" method="post">
		<h3 class="form-title"><?=$lng->text(($offline) ? 'ERROR:OFFLINE_TITLE' : 'login:title')?></h3>

		<?php if ($alert) { ?>
		<div class="alert alert-<?=$alert?> alert-fail">
			<button class="close" data-dismiss="alert"></button>
			<span><?=$msg?></span>
		</div>
		<?php } ?>

		<?php if (!$offline) { ?>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('login:user')?></label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="<?=$lng->text('login:user')?>" name="username" />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('login:password')?></label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="<?=$lng->text('login:password')?>" name="password" />
			</div>
		</div>

		<?php if ($publickey) { ?>
		<div class="form-group">
			<div class="controls">
				<div class="g-recaptcha" data-size="compact" data-sitekey="<?=$publickey?>"></div>
				<input type="hidden" name="recaptcha_field" value="1" />
			</div>
		</div>
		<?php } ?>

		<div class="form-actions">
			<label class="checkbox"><input type="checkbox" name="remember" value="1"/> <?=$lng->text('login:remember')?></label>

			<?=$tpl->get_view('_elements/token', array('token' => $login_token))?>
			<input type="hidden" name="action" value="login" />
			<button type="submit" class="btn blue pull-right"><?=$lng->text('login:login')?> <i class="m-fa fa-swapright m-fa fa-white"></i></button>
		</div>

		<?=$tpl->get_view('session/links')?>
		<?php } ?>
	</form>
	<?php } ?>

	<?=$tpl->get_view('session/remind', array('token' => $remind_token))?>
	<?=$tpl->get_view('session/signup', array('signup' => $signup, 'object' => $object, 'countries' => $countries, 'alert' => $alert, 'msg' => $msg, 'token' => $signup_token))?>

</view>


<view key="page_scripts">
	<script>
		$(function() {
			Login.init();
		});
	</script>
</view>

