<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <div class="row">
        <div class="col-md-12 articles">
			<ul>
			<?php
			$folder = '/article';
			for ($i = 0; $articles->list_paged(); $i++) {
				$url = $app->go($app->module_key, false, '/' . $articles->get_document_key());
				$filename = sprintf('id_%06d.jpg', $articles->get_id());
				if (file_exists($cfg->path->data . $folder . '/' . $filename)) {
					$thumbnail = '/image' . $folder . '/0/' . $filename;
				} else {
					$thumbnail = false;
				}
				?>
				<li>
					<div class="row">
						<div class="col-sm-<?=($thumbnail) ? 8 : 12?> articles">
							<em><?=$utl->date_format($articles->get_date_begin())?></em>

							<h3>
								<a href="<?=$url?>"><?=$articles->get_title()?></a>
							</h3>
							<div class="text">
								<?=html_entity_decode($articles->get_brief()) //get_intro(600)?>
							</div>
							<a class="more" href="<?=$url?>"><?=$lng->text('article:more')?></a>
						</div>
						<?php if ($thumbnail) { ?>
						<div class="col-sm-4">
							<img class="img-responsive" alt="" src="<?=$thumbnail?>">
						</div>
						<?php } ?>
					</div>
				</li>
				<?php
			}
			?>
			</ul>
			<?=$tpl->get_view('_elements/paging_inv', array('url' => $url, 'record_count' => $record_count, 'records_page' => $records_page, 'page' => $page));?>
        </div>
    </div>

</view>


<view key="page_scripts">
</view>
