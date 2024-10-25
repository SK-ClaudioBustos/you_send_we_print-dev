<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal productlist-form">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_main" data-toggle="tab"><?=$lng->text('productlist:tab:main') . $tab_error[0]?></a></li>
			<li><a href="#tab_items" data-toggle="tab"><?=$lng->text('productlist:tab:items')?></a></li>
			<li><a href="#tab_order" data-toggle="tab"><?=$lng->text('productlist:tab:order')?></a></li>
		</ul>

		<div class="form-body">
			<div class="tab-content">
				<div class="tab-pane active in" id="tab_main">
					<?=$tpl->get_view('_input/select', array('field' => 'product_id', 'label' => 'productlist:product_id', 'val' => $object->get_product_id(),
							'required' => true, 'error' => $object->is_missing('product_id'),
							'options' => $products, 'active_only' => false, 'none_val' => '', 'none_text' => ''))?>
					<?=$tpl->get_view('_input/select', array('field' => 'item_list_key', 'label' => 'productlist:item_list_key', 'val' => $object->get_item_list_key(),
							'required' => true, 'error' => $object->is_missing('item_list_key'),
							'options' => $item_lists, 'val_prop' => 'item_list_key', 'none_val' => '', 'none_text' => ''))?>
				</div>

				<div class="tab-pane" id="tab_items">
					<?=$tpl->get_view('productlist/productlist_items', array(
							'object' => $object, 
							'items' => $items, 
							'product_items' => $product_items,
						));?>
				</div>

				<div class="tab-pane" id="tab_order">
					<?=$tpl->get_view('productlist/productlist_order', array(
							'object' => $object, 
							'product_items' => $product_items,
						));?>
				</div>
			</div>
		</div>

		<div class="form-actions">
			<?=$tpl->get_view('_input/submit')?>
		</div>

		<input type="hidden" name="order_changed" id="order_changed" value="0" />
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		init_single();
	</script>
</view>
