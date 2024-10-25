<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form class="form-vertical login-form no-block" action="<?=$app->go()?>" method="post">
		<p><?=$lng->text(($username) ? 'reset:text' : 'reset:text_user')?></p>

		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('form:username')?></label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix input-medium" type="text" autocomplete="off" placeholder="<?=$lng->text('form:username')?>"
						name="username" value="<?=$username?>"<?=($username) ? ' readonly="readonly"' : ''?> />
			</div>
		</div>

		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9"><?=$lng->text('login:password')?></label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix input-medium" type="password" autocomplete="off" placeholder="<?=$lng->text('login:password')?>" name="password"/>
			</div>
		</div>

		<div class="form-actions clearfix">
			<?=$tpl->get_view('_elements/token', array('token' => $token))?>
			<input type="hidden" name="reset" value="<?=$activation_key?>" />
			<input type="hidden" name="action" value="reset" />
			<button type="submit" class="btn yswp-red btn-outline"><?=$lng->text('form:send')?> <i class="fa fa-arrow-circle-right"></i></button>
		</div>
	</form>
</view>
