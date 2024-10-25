<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$order?>": "<?=$app->go('Cart/done', false, '/' . $sale_hash)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<h2 class="subtitle"><?=$order?></h2>

	<?=$tpl->get_view('cart/upload_block', array(
			'object' => $object,
			'product' => $product,
			'items' => $items,
			'added_id' => $added_id,
			'ws' => false,
			'remove' => false,
		))?>

	<div class="proof_items clearfix">
		<form class="form">
		<?php
		for($i = 1; $images->list_paged(); $i++) {
			echo $tpl->get_view('cart/proof_item', array(
				'sale_hash' => $sale_hash,
				'object' => $object,
				'image' => $images,
				'url_folder' => $url_folder,
				'nro' => $i,
				'proofs' => $proofs
			));
		}
		?>
		</form>
	</div>

	<div class="upload_submit clearfix">
		<input type="hidden" name="action" id="action" value="upload" />
		<input type="hidden" name="sale_hash" id="sale_hash" value="<?=$sale_hash?>" />

		<a id="done" href="<?=$app->go('Cart/done', false, '/' . $sale_hash)?>" class="btn btn-lg yswp-red btn-outline pull-right submit"><?=$lng->text('product:upload_done')?> <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</view>


<view key="page_scripts">
	<script>
		init_proof()
	</script>
</view>


