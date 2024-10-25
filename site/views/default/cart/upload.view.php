<?php
$order = sprintf($lng->text('done:order_nro'), $sale->get_id(), $date_sold);

$readonly = ($object->get_job_name());
$checked = ($agree) ? ' checked="checked" disabled="disabled"' : '';
?>

<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$order?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" id="upload_form" class="product_form" action="<?=$app->go($app->module_key, false, '/upload_save/' . $object->get_id())?>">
		<h2 class="subtitle"><?=sprintf($lng->text('done:order_nro'), $sale->get_id(), $date_sold)?></h2>
		<div class="back_orders">
			<a class="back" href="<?=$app->go('Cart/done', false, '/' . $sale_hash)?>">&laquo; <?=$lng->text('done:back_order')?></a>
		</div>

		<?=$tpl->get_view('cart/upload_block', array(
				'object' => $object,
				'product' => $product,
				'items' => $items,
				'items_array_by_key' => $item_array_list,
				'added_id' => $added_id,
				'ws' => false,
				'remove' => false,
			))?>

		<div>
			<a class="prepare" target="_blank" href="/data/artspec/artwork-specs.pdf"><i class="fa fa-info-circle"></i> <?=$lng->text('product:upload_prepare')?> <i class="fa fa-external-link"></i></a>
		</div>

		<div class="row upload_artwork clearfix">
			<div class="col-sm-6 upload_type upload_local">
				<h3><?=$lng->text('product:upload_local')?></h3>
				<h5><?=$lng->text('product:upload_local_sub')?></h5>
				<p><?=$lng->text('product:upload_local_text')?></p>
			</div>

			<div class="col-sm-6 upload_type upload_big">
				<h3><a class="big_a" target="_blank" href="https://yousendweprint.wetransfer.com/"><?=$lng->text('product:upload_big')?></a></h3>
				<h5><?=$lng->text('product:upload_big_sub', $object->get_id())?></h5>
				<p><?=$lng->text('product:upload_big_text')?></p>
			</div>
		</div>

		<div class="upload_buttons clearfix">
			<?php if ($object->get_sides() == 2) { ?>
			<div class="agree clearfix">
				<label id="sides"><?=$lng->text('product:double_side')?></label>
			</div>
			<?php } ?>
			<div class="agree clearfix">
				<label for="agree"><input type="checkbox" id="agree" name="agree" value="1"<?=$checked?> /> <?=$lng->text('product:agree')?></label>
			</div>

			<div class="left">
				<a class="upload_cancel" href="#"><?=$lng->text('product:upload_cancel')?></a>

				<span class="btn yswp-green fileinput-button<?=(!$agree) ? ' disabled' : ''?>"><?=$lng->text('product:upload_file')?> <i class="fa fa-arrow-circle-up"></i></span>
			</div>

			<div class="right">
				<span class="upload_msg"><?=$lng->text('product:upload_message')?></span>
			</div>
		</div>

		<div class="form-body upload_files" id="existing">
			<?php
			// existing images
			for($i = 0; $images->list_paged(); $i++) {
				?>
				<div class="uploadify-queue-item">
					<?=$tpl->get_view('cart/upload_item', array('image' => $images, 'url_folder' => $url_folder));?>
				</div>
				<?php
			}
			?>
		</div>

		<div class="upload_files" id="upload_inner">
			<div class="uploadify-queue-item" id="template">
				<div class="file-item">
					<div class="cancel">
						<a href="#" data-dz-remove><i class="fa fa-close"></i></a>
					</div>

					<span class="fileName" data-dz-name></span>
					<span class="fileError" data-dz-errormessage></span>

					<span class="fileSize" data-dz-size></span> <span class="data" data-dz-uploadprogress></span>

					<div class="uploadify-progress">
						<div class="uploadify-progress-bar" style="width: 0%;" data-dz-uploadprogress><!--Progress Bar--></div>
					</div>

					<span class="processing" style="display: none;"><?=$lng->text('product:upload_processing')?></span>
				</div>
			</div>
		</div>

		<div class="validation_error">
			<h5><?=$lng->text('product:fix_first')?></h5>
			<p><?=$lng->text('product:fix_partial')?></p>
		</div>

		<div class="upload_submit clearfix">
			<input type="hidden" name="action" id="action" value="upload" />
			<input type="hidden" name="sale_hash" id="sale_hash" value="<?=$sale_hash?>" />

			<button type="button" id="done" class="btn btn-lg yswp-red btn-outline pull-right submit"><?=$lng->text('product:upload_done')?> <i class="fa fa-arrow-circle-right"></i></button>
		</div>

	</form>
</view>


<view key="page_scripts">
	<script>
		var baseUrl = '<?=$app->go($app->module_key)?>';

		init_upload(<?=$object->get_sale_id()?>, <?=$object->get_id()?>, <?=$object->get_quantity()?>, '<?=session_id()?>');
	</script>
</view>
