<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <div class="row">
        <div class="col-md-12">

			<ul class="mix-filter">
				<li class="filter" data-filter="all">All</li>
				<?php foreach($app->menu_groups as $product_id => $category) {?>
				<li class="filter" data-filter="c<?=str_replace(['&',','],['\&','\,'], $product_id) ?>"><?=$category['title']?></li>
				<?php } ?>
			</ul>
			<div class="row mix-grid fixed">
				<?php
				foreach ($app->menu_groups as $category_id => $category) {
					$folder = '/data/portfolio/'; // . $category_id . '/';

					foreach ($category['groups'] as $group_id => $group) {
						if (!is_numeric($group_id)) {
							continue;
						}
						?>
						<div class="col-xs-6 col-sm-4 col-lg-3 mix c<?=$category_id?>">
							<a class="gallery-button" href="javascript:;" data-group="c<?=$category_id?>" data-group_id="<?=$group_id?>" title="<?=$group?>">
								<div class="mix-inner" style="float: left; width: auto; background: #f4f4f4;">
									<img class="img-responsive" loading="lazy" src="<?=$folder . sprintf('%06d', $group_id) . '.jpg'?>" alt="">
									<div class="mix-details">
										<h4><?=$group?></h4>
									</div>
								</div>
							</a>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</view>


<view key="page_scripts">
    <script type="text/javascript">
		var url_gallery = '<?=$app->go($app->module_key, false, '/ajax_gallery/')?>';

		init_portfolio();
    </script>
</view>
