<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu" data-auto-scroll="false" data-slide-speed="400" data-keep-expanded="false">

			<li class="nav-item hidden-sm hidden-xs nav-info lfto">
				<span id='lfto'>Large Format Trade Only!</span>
			</li>

			<li class="nav-item visible-sm visible-xs" style="height: 6px; background: #f6f6f6;">
			</li>
			<li class="nav-item hidden-sm hidden-xs nav-info">
				<span>Phone <a href="tel:3052046455">(305) 204-6455</a><br>Cut-off Time 3:00pm EST</span>
			</li>

			<li class="nav-item visible-sm visible-xs<?= ($app->module_key == 'Home') ? ' active' : '' ?>">
				<a href="<?= $app->go('Home') ?>" class="nav-link nav-toggle">
					<i class=""></i>
					<span class="title"><?= $lng->text('home') ?></span>
					<?php if ($active) { ?>
						<span class="selected"></span>
					<?php } ?>
				</a>
			</li>

			<?php
			$module_keys = array('Portfolio', 'Article', 'Faq', 'Artspec', 'Utilities', 'About', 'Contact');
			$active = in_array($app->module_key, $module_keys);
			?>
			<li class="nav-item visible-sm visible-xs<?= ($active) ? ' active' : '' ?>">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class=""></i>
					<span class="title"><?= $lng->text('menu:sections') ?></span>
					<span class="arrow<?= ($active) ? ' open' : '' ?>"></span>
					<?php if ($active) { ?>
						<span class="selected"></span>
					<?php } ?>
				</a>

				<ul class="sub-menu">
					<?= $tpl->get_view('_elements/section_menu', array('home' => false)); ?>
				</ul>
			</li>

			<li class="heading">
				<h3 class="uppercase">
					<a href="<?= $app->go('Sitemap') ?>">
						<?= $lng->text('menu:sitemap') ?>
						<span class="arrow"></span>
					</a>
				</h3>
			</li>

			<?php foreach ($app->menu_groups as $group_key => $group) { ?>
				<li class="heading">
					<h3 class="uppercase"><?= $group['title'] ?></h3>
				</li>
				<?= $tpl->get_view('_elements/sidebar_products', array('group' => $group_key)) //, 'intro' => '/intro'))
				?>
			<?php } ?>
		</ul>
	</div>
</div>