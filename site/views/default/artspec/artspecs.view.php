<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <div class="row">
        <div class="col-md-12">
			<?php
			foreach ($categories as $key => $category) {
				$content = $objects[$key];
				echo html_entity_decode($content['text']);
			}
			?>
        </div>
    </div>
</view>


<view key="page_scripts">
</view>

