<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$lng->text('menu:news')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <div class="articles clearfix">
        <span class="date"><?=$utl->date_format($date_begin)?></span>

        <div class="text">
			<?=$content?>
        </div>
		
		<?php if ($source) { ?>
        <div class="source">
            <a href="<?=$source?>"><?=$source?></a>
        </div>
		<?php } ?>

	    <a class="back" href="<?=$app->go($app->module_key)?>">&lsaquo; <?=$lng->text('article:back')?></a>
    </div>
</view>


<view key="page_scripts">
</view>
