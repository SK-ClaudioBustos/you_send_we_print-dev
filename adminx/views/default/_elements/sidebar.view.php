<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">

		<div class="page-sidebar-wrapper">
			<ul class="page-sidebar-menu" data-auto-scroll="false" data-slide-speed="200">

				<li class="nav-item visible-sm visible-xs" style="height: 6px; background: #f6f6f6;">
				</li>

				<li class="nav-item hidden-sm hidden-xs" style="height: 67px;">
					<form method="post" action="<?=$app->page_full?>" class="context-form">
						<input type="hidden" name="field_change" id="field_change" value="" />
						<input type="hidden" name="context_cicle_id" id="context_cicle_id" value="<?=$app->cicle['cicle_id']?>" />
						<input type="hidden" name="context_client_id" id="context_client_id" value="<?=$app->client['client_id']?>" />
					</form>
				</li>

				<?php
				foreach ($app->sidebar as $group) {
					if (!isset($group['perm']) || $app->user->perm($group['perm']) || $group['module'] == 'Home') {

						$active = (isset($group['items']) && array_key_exists($app->page_key, $group['items']));

						if (isset($group['module']) && $group['module']) {
							$url = (isset($group['args']) && $group['args']) ? $app->go($group['module'], false, $group['args'], $app->token) : $app->go($group['module'], false, '', $app->token);

						} else if (isset($group['link'])) {
							$url = $group['link'];

						} else {
							$url = 'javascript:;';
						}
						?>

				  		<li class="nav-item<?=((isset($group['module']) && $group['module'] == $app->page_key) || $active) ? ' active' : ''?>">
				  			<a href="<?=$url?>" class="nav-link nav-toggle"<?=($group['target']) ? ' target="' . $group['target'] . '"' : ''?>>
								<i class="<?=$group['icon']?>"></i>
								<span class="title"><?=$lng->text($group['label'])?></span>
								<?php if (isset($group['items'])) { ?>
								<span class="arrow<?=($active) ? ' open' : ''?>"></span>
								<?php } ?>
								<?php if ((isset($group['module']) && $group['module'] == $app->page_key) || $active) { ?>
								<span class="selected"></span>
								<?php } ?>
							</a>

							<?php if (isset($group['items'])) { ?>
							<ul class="sub-menu">
								<?php
								foreach ($group['items'] as $item) {
									if (!isset($item['perm']) || $app->user->perm($item['perm'])) {

										if (isset($item['module']) && $item['module']) {
											$item_url = (isset($item['args']) && $item['args']) ? $app->go($item['module'], false, $item['args'], $app->token) : $app->go($item['module'], false, '', $app->token);

										} else if (isset($item['link'])) {
											$item_url = $item['link'];

										} else {
											$item_url = 'javascript:;';
										}

										?>
										<li<?=($item['module'] == $app->page_key) ? ' class="active"' : ''?>><a href="<?=$item_url?>"><?=$lng->text($item['label'])?></a></li>
										<?php
									}
								}
								?>
							</ul>
							<?php } ?>
						</li>
						<?php
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>
