<?php
foreach ($promos as $promo) {
	$url = ($promo['url']['root']) ? $app->go('Product', false, '/' . $promo['url']['product']) : false;
?>
	<div class="col-md-3 col-xs-6">
		<?php if ($url) { ?>
			<a href="<?= $url ?>">
				<div class="mix-inner">
					<div class="taco">
						<span><?= $promo['title'] ?></span>
					</div>
					<img class="img-responsive" loading="lazy" src="<?= $promo['image'] ?>" alt="<?= $promo['title'] ?>" height="485" />
				</div>
			</a>
		<?php } else { ?>
			<div class="mix-inner">
				<div class="taco">
					<span><?= $promo['title'] ?></span>
				</div>
				<img class="img-responsive" loading="lazy" src="<?= $promo['image'] ?>" alt="<?= $promo['title'] ?>" height="485" />
			</div>
		<?php } ?>
	</div>
<?php
}
?>