<div class="info_right clearfix">
	<? if ($app->username) { ?>
	<a href="<?=$app->go('User/account')?>"><?=$lng->text('home:register')?> <i class="fa fa-chevron-right"></i></a>
	<? } else { ?>
	<a href="<?=$app->go('Session/login')?>"><?=$lng->text('home:register')?> <i class="fa fa-chevron-right"></i></a>
	<? } ?>
</div>

<div class="info_left">
	<h2><?=$lng->text('home:retail1')?></h2>
	<p><?=$lng->text('home:retail2')?></p>
</div>

