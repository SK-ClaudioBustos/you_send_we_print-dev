<div class="page-header navbar navbar-fixed-top">
	<div class="page-header-inner clearfix">

		<div class="page-logo" style='background:#fff'>
			<a href="<?= $app->go('Home') ?>">
				<img src="/data/site/logo-new-m.png" alt="logo" class="logo-default" />
				<img src="/data/site/logo-new-m.png" alt="logo" class="logo-m" height='38px' />
			</a>
			<?php if ($menu !== false) { ?>
				<div class="menu-toggler sidebar-toggler hidden">
				</div>
			<?php } ?>
		</div>
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
		<a id="toggle_search-mobile" href="" title="<?= $lng->text('menu:search') ?>"><i class="fa fa-search"></i></a>
		<div class="search-container-mobile">
			<?= $tpl->get_view('_input/search_gral', ['pos' => '_top']) ?>
		</div>

			<?php if ($menu !== false) { ?>
			<center><div class="hor-menu hor-menu-light hidden-sm hidden-xs">
				<ul class="nav navbar-nav" style='text-transform:uppercase'>
					<?= $tpl->get_view('_elements/section_menu'); ?>
				</ul>
			</div>
			</center>

		<?php } ?>
		<?php if ($user !== false) { ?>
			<div id="topmenu" class="top-menu pull-right">
				<div id="mobmenu">
					<span>Phone <a href="tel:3052046455">(305) 204-6455</a><br>Cut-off Time 3:00pm EST</span>
				</div>
				<ul class="nav navbar-nav pull-right">
					<?= $tpl->get_view('_elements/header_user') ?>
				</ul>
			</div>
		<?php } ?>
		
<div id="topmenu" class="top-menu mid-menu hidden-xs hidden-sm">
				<div class="pull-left">
					<span>Ph <a href="tel:3052046455">(305) 204-6455</a></span>
				</div>
				<div class="pull-left">
					<a class="mid-menu-link" href="/all-products">
					<i class="fa fa-chevron-right"></i>	<b>All Products</b>
					</a>
				</div>
				<div class="pull-left">
				    <a id="toggle_search" class='mid-menu-link' href="" title="<?= $lng->text('menu:search') ?>"><i class="fa fa-search"></i><b> <?= $lng->text('menu:search') ?></b></a>
					</a>
				</div>
				
			
              
				<div class="pull-right">
					<span>Cut-off Time 3:00pm EST&nbsp;&nbsp;&nbsp;</span>
				</div>
				  <div class="center"><center>
				     <?php foreach ($app->menu_tags as $tag => $value) { ?>
				 	<a class="mid-menu-link" href="/<?= $value[link] ?>">
					<?= $value[title] ?>
					</a>
					<?php } ?>
					<span class="hidden-sm hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				    </center>
				</div>
			</div>
	</div>
		<div class="page-bar page-bar-top hidden-xs search-container">
				<center><?= $tpl->get_view('_input/search_gral') ?></center>
				</div>

		<?php if ($menu !== false) { ?>
			<div class="row-fluid hidden-sm hidden-xs">
			
					<?= $tpl->get_view('_elements/horizontal_menu'); ?>
			</div>

		<?php } ?>
</div>
<div class="subbar clearfix"></div>
