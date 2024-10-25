<div class="hor-menu hor-menu-light hidden-sm hidden-xs">
	<ul class="nav navbar-nav">
		<li class="classic-menu-dropdown">
			<?php if (!in_array($app->user->get_role_id(), $app->guest_roles)) { ?>
			<a href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
				<img src="/data/client/<?=sprintf('%04d.ico', $app->client['client_id'])?>" alt="<?=$app->client['client']?>" /> <b><?=$app->client['client']?></b> <i class="fa fa-angle-down"></i>
			</a>

			<ul class="dropdown-menu dropdown-client pull-left">
				<?php
				$clients = $app->clients;
				while($clients->list_paged()) {
					?>
					<li>
						<a data-id="<?=$clients->get_id()?>" href="javascript:;">
							<img src="/data/client/<?=sprintf('%04d.ico', $clients->get_id())?>" alt="<?=$clients->get_client()?>" /> <?=($clients->get_id() == $app->client['client_id']) ? '<b>' . $clients->get_client() . '</b>' : $clients->get_client()?>
						</a>
					</li>
					<?php
				}
				?>
			</ul>
			<?php } else { ?>
			<a href="javascript:;">
				<img src="/data/client/<?=sprintf('%04d.ico', $app->client['client_id'])?>" alt="" /> <b><?=$app->client['client']?></b>
			</a>
			<?php } ?>
		</li>

		<li class="classic-menu-dropdown">
			<a href="javascript:;" data-hover="megamenu-dropdown" data-close-others="true">
				<i class="fa fa-calendar"></i> <?=$app->cicle['cicle']?> <i class="fa fa-angle-down"></i>
			</a>

			<ul class="dropdown-menu dropdown-cicle pull-left">
				<?php
				$cicles = $app->cicles;
				while($cicles->list_paged()) {
					?>
					<li>
						<a data-id="<?=$cicles->get_id()?>" href="javascript:;">
							<i class="fa fa-calendar"></i> <?=($cicles->get_id() == $app->cicle['cicle_id']) ? '<b>' . $cicles->get_cicle() . '</b>' : $cicles->get_cicle()?>
						</a>
					</li>
					<?php
				}
				?>
			</ul>
		</li>
	</ul>
</div>
