<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<div class="row product_sel">

		<?php
		while ($children->list_children()) {
			$url = $app->go($app->module_key, false, '/product/' . $object->get_product_key() . '/' . $children->get_product_key());
			?>
	        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
				<a class="image" href="<?=$url?>">
					<img alt="" class="img-responsive" src="/image/product/<?=$object->get_product_key() . '/0/' . sprintf('%06d', $children->get_id())?>.00.jpg">
				</a>
				<h2><a href="<?=$url?>"><?=$children->get_title()?> <?=($children->get_use_stock() && !$children->get_stock() ? '<span class="no_stock">' . $lng->text('product:no_stock') . '</span>' : '')?></a></h2>
				<span class="from"><?=$lng->text('product:price_from', number_format($children->get_price_from() * $incr_retail, 2))?></span>
				<div><?=html_entity_decode($children->get_short_description())?></div>
			</div>
			<?php
		}
		?>

	</div>
</view>


<view key="page_scripts">
</view>

