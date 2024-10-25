<?php if ($app->user_allow_reset) { ?>
<div class="forget-password">
	<p><?=sprintf($lng->text('login:forgot_text'), '<a href="javascript:;" id="forget-password">', '</a>')?></p>
</div>
<?php } ?>
