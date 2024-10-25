<view key="page_metas">
</view>


<view key="breadcrumb">
	{}
</view>


<view key="body">
	<?php if ($user_id == 0) { ?>
		<div class="row info" id="r_i_g_t">
			<?= $tpl->get_view('home/home_' . $user_type, array('info' => $info, 'user_id' => $user_id, 'banner' => $banner, 'pos' => '_top')) ?>
		</div>
	<?php } ?>
	<?php if ($app->warning) { ?>
			<div id="home-warning" class="warning">
				<?= $app->warning ?>
			</div>
	<?php } ?>
	<div class="row-fluid slideshow">
		<?= $tpl->get_view('home/home_slideshow', array('slides' => $slides, 'slides_mobile' => $slides_mobile)) ?>
	</div>
	<?php // 'home/home_'. $user_type; ?>
	<?php if ($user_id == 0) { ?>
		<div class="row info" id="r_i_g_b">
			<?= $tpl->get_view('home/home_' . $user_type, array('info' => $info, 'user_id' => $user_id, 'banner' => $banner, 'pos' => '_bot')) ?>
		</div>
	<?php } ?>
	<?php if ($user_id != 0) { ?>
		<div class="row info" id="r_i_l">
			<?= $tpl->get_view('home/home_' . $user_type, array('info' => $info, 'user_id' => $user_id, 'banner' => $banner, 'pos' => '')) ?>
		</div>
	<?php } ?>

	<?php /*if ($app->wholesaler_ok) {*/ ?>
	<?php if ($user_type == 'wholesaler') { ?>
		<div class="row promo">
			<?= $tpl->get_view('home/home_promos', array('promos' => $promos)) ?>
		</div>

		<div class="row info info2">
		    <br>
			<div class="col-md-12">
				<div class="info_full">
					<h1 ><?= $lng->text('home:oustanding1') ?></h1>
					<h2><?= $lng->text('home:oustanding2') ?></h2>
					<p><?= $lng->text('home:oustanding3') ?></p>
				</div>
			</div>
			<br>
		</div>
	<?php } ?>

	<div class="row mix-grid fixed">
		<?= $tpl->get_view('home/home_products', array('products' => $products)) ?>
	</div>

	<div class="row info what_we_do">
		<div class="container">
			<div class="info_full">
				<h2><?= $what_we_do2["title"] ?></h2>
				<p><?= $what_we_do2["text"] ?> <a class="more" href="<?= $what_we_do2["link"] ?>"><?= $lng->text('home:see_more') ?> <i class="fa fa-angle-double-right"></i></a>
				</p><br>
			</div>
		</div>
	</div>

	<div class="row info experience">
		<a href="<?= $app->go('Sitemap') ?>">
			<?= $tpl->get_view('home/home_experience', array('experiences' => $experiences)) ?>
		</a>
	</div>
</view>

<view key="page_scripts">
	<script>
		let user_id = <?= $user_id ?>;
		init_home(<?= $slide_speed ?>);
	</script>
</view>