<div class="product-prods">
	<?php
	$groups = $app->menu_groups[$group]['groups'];

	foreach ($groups as $group_key => $title) {
		?>
		<ul class="clearfix">
			<li><h4><?=$title?>:</h4></li>
			<?php
			$items = $app->menu_items[$group][$group_key];
			$first = true;
			foreach ($items as $key => $item) {
				?>
				<li><?=($first) ? '' : ' | '?><a id="foot_<?=$key?>" href="<?=$app->go('Product', false, '/' . $key . $intro)?>"><?=$item['title']?></a></li>
				<?php
				$first = false;
			}
			?>
		</ul>
		<?php
	}
	?>
</div>
