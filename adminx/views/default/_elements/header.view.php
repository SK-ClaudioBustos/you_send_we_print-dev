<div class="page-header navbar navbar-fixed-top">
	<div class="page-header-inner clearfix">

		<div class="page-logo">
			<a href="<?=$app->go('Home')?>">
				<img src="/data/site/site_logo.png" alt="logo" class="logo-default"/>
			</a>
			<?php if ($menu !== false) { ?>
			<div class="menu-toggler sidebar-toggler hidden">
			</div>
			<?php } ?>
		</div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>

		<?php if ($user !== false) { ?>
		<div class="top-menu pull-right">
			<ul class="nav navbar-nav pull-right">
				<?=$tpl->get_view('_elements/header_user')?>
			</ul>
		</div>
		<?php } ?>

	</div>
</div>

<div class="subbar clearfix"></div>