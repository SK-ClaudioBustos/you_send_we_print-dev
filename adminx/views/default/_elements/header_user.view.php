<?php if ($app->username) { ?>
<li class="dropdown dropdown-user">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

	<?php /*
	<img alt="" class="img-circle hide1" src="/data/site/avatar3_small.jpg"/>
	*/ ?>

	<span class="username username-hide-on-mobile"><?=$app->username?></span> <i class="fa fa-angle-down"></i>
	</a>
	<ul class="dropdown-menu">
		<li>
			<a href="<?=$app->go('User/profile')?>"><i class="icon-user"></i> <?=$lng->text('menu:profile')?></a>
		</li>
		<li class="divider"></li>
		<li>
			<a href="<?=$app->go('Session/logout')?>"><i class="icon-key"></i> <?=$lng->text('menu:logout')?></a>
		</li>
	</ul>
</li>
<?php } ?>
