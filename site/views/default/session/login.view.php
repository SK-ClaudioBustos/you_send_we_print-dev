<view key="page_metas">
	<?php if ($publickey) { ?>
	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
	<?php } ?>
</view>


<view key="breadcrumb">
	{ "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<div class="row fields">
		<div class="col-md-6">
			<h3 class="form-title"><?=$lng->text('login:enter')?></h3>
			<?=$tpl->get_view('session/login_form', array(
					'token' => $login_token,
					'login_var' => $login_var,
					'publickey' => $publickey,
				))?>

			<?=$tpl->get_view('session/remind', array(
					'token' => $remind_token,
				))?>
		</div>

		<div class="col-sm-6 picture">
            <div class="form-group">
            </div>
		</div>
	</div>
</view>


<view key="page_scripts">
</view>

