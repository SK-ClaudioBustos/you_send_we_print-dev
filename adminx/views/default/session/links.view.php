<?php if ($app->user_allow_reset) { ?>
<div class="forget-password">
	<h4><?=$lng->text('login:forgot')?></h4>
	<p><?=sprintf($lng->text('login:forgot_text'), '<a href="javascript:;" id="forget-password">', '</a>')?></p>
</div>
<?php } ?>
<?php if ($app->user_allow_signup) { ?>
<div class="create-account">
	<p><?=$lng->text('login:register')?> <a href="javascript:;" id="register-btn"><?=$lng->text('login:create')?></a>
	</p>
</div>
<?php } ?>
