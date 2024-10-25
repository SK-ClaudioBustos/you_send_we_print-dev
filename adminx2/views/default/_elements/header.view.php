<div class="header">
	<div class="login_hidden">
	</div>

	<div class="header_left">
		<a href="<?=$app->go('Home')?>">
			<img src="/data/site/site-logo.jpg" alt="YouSendWePrint Logo" title="YouSendWePrint - Print Service Provider" /></a>
	</div>

	<div class="header_right">
		<div class="login_tab">
			<div class="login_tab_right">
			</div>

			<div class="login_tab_left">
				<span class="user_label"><?=$lng->text('menu:hello')?> <?=$this->cfg->app->username?>!</span>
				<span>|</span>
				<a class="logout_link" href="<?=$cfg->app->page_full . '/logout'?>"><?=$lng->text('menu:logout')?></a>
			</div>
		</div>

		<div class="menu">
		</div>
	</div>

	<div class="buying_steps">
	</div>
</div>