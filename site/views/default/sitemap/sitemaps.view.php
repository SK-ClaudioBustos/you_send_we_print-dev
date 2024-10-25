<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <div class="row sitemap-prods">
		<div class="col-md-12">
			<?php foreach($app->menu_groups as $group_key => $group) {?>
			<h3 class="uppercase"><?=$group['title']?></h3>
			<?=$tpl->get_view('sitemap/sitemap_products', array('group' => $group_key))?>
			<?php } ?>
		</div>
	</div>
</view>


<view key="page_scripts">
    <script type="text/javascript">
		var url_gallery = '<?=$app->go($app->module_key, false, '/ajax_gallery/')?>';

		init_portfolio();
    </script>
</view>

