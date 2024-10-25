<view key="page_metas">
</view>


<view key="breadcrumb">
    <?php if ($parent_url) {?>
    { "<?=htmlentities($title)?>": "<?=$parent_url?>", "<?=htmlentities($subtitle)?>": "<?=$app->page_full?>" }
    <?php } else { 
	// remove last arg for parent
	?>
    { "<?=$title?>": "<?=$app->page_full?>" }
    <?php } ?>
</view>


<view key="body">
	<div class="row row-intro row-content">
        <div class="col-xs-12">
			<a class="btn yswp-red btn-outline btn-lg pull-right" href="<?=$form_url?>"><?=$lng->text('product:buy')?> <i class="fa fa-arrow-circle-right"></i></a>
			<?=html_entity_decode($object->get_short_description())?>
        </div>
	</div>
</view>


<view key="page_scripts">
    <script>
    </script>
</view>
<?php
/*
*/
?>