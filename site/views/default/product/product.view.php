<view key="page_metas">
</view>


<view key="breadcrumb">
	<?php if ($parent_url) { ?>
		{ "<?= htmlentities($title) ?>": "<?= $parent_url ?>", "<?= htmlentities($subtitle) ?>": "<?= $app->page_full ?>" }
	<?php } else { // remove last arg for parent
	?>
		{ "<?= $title ?>": "<?= $app->page_full ?>" }
	<?php } ?>
</view>

<?php //init bulk variable 
$_SESSION["isbulk"] = ""; //this variable is setting in field folder, the file is product.list.view.php and the line 17 aprox. values (isbulk or "" empty)
?>
<view key="body">
	<div class="row">
		<div class="col-lg-12">
			<?= ($subtitle) ? '<h2 class="subtitle">' . $subtitle . '</h2>' : '' ?>
		</div>

		<div class="col-lg-6">
			<form method="post" id="product_form" class="form-horizontal no-block clearfix" action="<?= $app->go($app->module_key, false, '/save') ?>">
				<div class="form-body product-form">

					<?php if (!$app->wholesaler_ok) { ?>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="alert alert-warning login-warning">
									<?php if (!$app->user->get_id()) { ?>
										<a href="#"><i class="fa fa-warning"></i> <?= $lng->text('product:login_warning') ?></a>
									<?php } elseif (!$app->user->get_confirmed()) { ?>
										<i class="fa fa-warning"></i> <?= $lng->text('product:confirm_warning') ?>
									<?php } else { ?>
										<a id="link_wholesaler" href="<?= $app->go('User/wholesaler') ?>"><i class="fa fa-warning"></i> <?= $lng->text('product:activate_warning') ?></a>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php
					if ($product->get_use_stock() && !$product->get_stock()) {
						$no_stock = sprintf($lng->text('product:no_stock_text'), '<a href="' . $app->go('Contact') . '">', '</a>');
					?>
						<div class="no_stock">
							<?= $no_stock ?>
						</div>
					<?php
					}
					?>
					<?= $form ?>

					<div class="form-group">
						<div class="col-xs-12">
							<div class="sep-top"></div>
						</div>
						<label class="col-xs-4"><?= $lng->text('product:job_name') ?></label>
						<div class="col-xs-8">
							<input type="text" name="job_name" id="job_name" class="form-control" data-required="required" title="<?= $lng->text('product:job_name') ?>" maxlength="24" value="<?= $object->get_job_name() ?>" />
							<span id="loader hidden"></span>
						</div>
						<span class="col-xs-12 help right"><?= $lng->text('product:job_lenght') ?></span>
					</div>

					<div class="validation_error">
						<h4><?= $lng->text('product:fix_first') ?></h4>
					</div>

					<div class="form-group form-buttons">
						<div class="col-xs-12">
							<button type="submit" class="submit btn btn-lg yswp-red btn-outline pull-right" id="add_to_cart" <?= (!$app->wholesaler_ok || ($product->get_use_stock() && !$product->get_stock())) ? ' disabled="disabled"' : '' ?>>
								<?= ($object->get_id()) ? $lng->text('product:continue') : $lng->text('product:add_to_cart') ?> <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
						<span class="col-xs-12 help right next_artwork"><?= $lng->text('product:next_artwork') ?></span>
					</div>

					<input type="hidden" name="product_key" value="<?= $product->get_product_key() ?>" />
					<input type="hidden" name="product_id" value="<?= $product->get_id() ?>" />
					<input type="hidden" name="parent_id" value="<?= ($parent) ? $parent->get_id() : '' ?>" />
					<input type="hidden" name="path" value="<?= $app->page ?>" />
					<input type="hidden" name="sale_id" id="sale_id" value="<?= $object->get_sale_id() ?>" />
					<input type="hidden" name="id" id="id" value="<?= $object->get_id() ?>" />
					<input type="hidden" name="action" value="edit" />
				</div>
			</form>
		</div>

		<div class="col-lg-6">
			<?= $tpl->get_view('product/product_info', array(
				'object' => $object,
				'product' => $product,
				'title' => $title,
				'subtitle' => $subtitle,
				'image_path' => $image_path,
				'gallery' => $gallery,
				'attach' => $attach,
				'attach_path' => $attach_path,
			)) ?>
		</div>

	</div>

</view>


<view key="page_scripts">
	<script>
		var url_info = '<?= $app->go($app->module_key, false, '/ajax_totals') ?>';
		var url_update = '<?= $app->go($app->module_key, false, '/ajax_update') ?>';

		var ajax = false;
		var minimum = <?= $app->minimum ?>;
		var maximum = {};
		var use_stock = <?= ($product->get_use_stock()) ? 'true' : 'false' ?>;
		var stock = <?= $product->get_stock() ?>;
		var item_cuts = <?= json_encode($item_cuts) ?>;

		let userid = <?= ($app->user->get_id()) ? $app->user->get_id() : 'false' ?>;
		let confirmed = <?= ($app->user->get_confirmed()) ? 'true' : 'false' ?>;

		init_product_form(<?= ($app->wholesaler_ok) ? 'true' : 'false' ?>, '<?= $product->get_measure_type() ?>');
	</script>
</view>