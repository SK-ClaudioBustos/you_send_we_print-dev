<?php
$groups = $app->menu_groups[$group]['groups'];

foreach ($groups as $group_key => $title) {
	if (is_numeric($group_key)) {
		continue;
	}
	?>
	<h4 class="uppercase"><?=$title?></h4>
	<div class="row">
		<?php
		$items = $app->menu_items[$group][$group_key];
		$count = 0;
		foreach ($items as $key => $item) {
			if ($count == 6) {
				$count = 0;
				?>
				</div>
				<div class="row">
				<?php
			}
			$count++;
			?>
			<div class="col-md-2 col-sm-3 col-xs-6">
				<a class="clearfix" id="foot_<?=$key?>" href="<?=$app->go('Product', false, '/' . $key . $intro)?>">
					<img src="/image/sitemap/0/<?=sprintf('%06d.jpg', $item['id'])?>" />
					<?=$item['title']?>
				</a>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
?>
