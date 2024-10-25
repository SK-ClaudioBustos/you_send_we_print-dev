<?php
$groups = $app->menu_groups[$group]['groups'];
$item_key = explode('/', $app->page_args);
$subitem_key = $item_key[1];
$item_key = $item_key[0];


	if ($parent_id = $app->menu_subitems[$subitem_key]["parent_id"]) {
	   $subitems = $app->menu_subitems[$parent_id];
	}

foreach ($groups as $group_key => $title) {
	if (is_numeric($group_key)) {
		continue;
	}
	$active = false;
	$group_home = $app->menu_group_homes[$group_key];
	$group_home_link = "";
	if ($group_home) {
		/* $group_home_link = "onclick = \"window.history.pushState({},null,'{$app->go('Product/group', false, '/' . $group_key)}'); window.location.reload();\""; */
		$group_home_link = "onclick = \"smooth_reload('{$app->go('Product/group', false, '/' . $group_key)}')\""; 
	}
	if ($items = $app->menu_items[$group][$group_key]) {
		$active = (array_key_exists($item_key, $items));
	}

	if ($item_key == $group_key) {
		$active = true;
	}

if ($active)
    echo "<script>var element = document.getElementById('".str_replace(array('&',','),'',$group)."'); element.classList.add('active_mega'); </script>";

?>
	<li class="nav-item<?= ($active) ? ' active' : '' ?>" <?php echo $group_home_link ?>>
		<?php if ($group_home_link == "") { ?>
			<a class="nav-link nav-toggle">
		<?php } else { ?>
			<a class="nav-link">
		<?php } ?>
			<span class="title"><?= $title ?></span>
			<span class="arrow<?= ($active) ? ' open' : '' ?>"></span>
			<?php if ($active) { 
                        echo "<script>var element = document.getElementById('".str_replace(array('&',','),'',$group)."'); element.classList.add('active_mega'); </script>"; ?>
				<span class=""></span>
			<?php } ?>
		</a>

		<ul class="sub-menu">
			<?php
			if ($items) {
				foreach ($items as $key => $item) {
					$active = ($item_key && $item_key == $key);
					if ($active)
                        echo "<script>var element = document.getElementById('".str_replace(array('&',','),'',$group)."'); element.classList.add('active_mega'); </script>";

			?>
					<li class="<?= ($active && !$subitems) ? 'active' : '' ?>">
						<a id="prod_<?= $key ?>" href="<?= $app->go('Product', false, '/' . $key . $intro) ?>">
							<?= $item['title'] ?>
							<?php if ($item['featured']) { ?>
								<span class="badge badge-<?= $item['class'] ?>"><?= $item['featured'] ?></span>
							<?php } ?>
						</a>
					</li>
			<?php
				}
			}
			if ($subitems) {
				foreach ($subitems as $key => $item) {
					$active = ($subitem_key && $subitem_key == $key); ?>
					<li class="<?= ($active) ? 'active' : '' ?>">
						<a id="prod_<?= $key ?>" href="<?= $app->go('Product', false, '/' .$item_key.'/'. $key . $intro) ?>">
							<?= $item ?>
						</a>
					</li>
			<?php
				}
			}
			?>
		</ul>
	</li>
<?php

}
?>