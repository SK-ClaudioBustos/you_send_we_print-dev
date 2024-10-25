<view key="page_metas">
</view>


<view key="breadcrumb">
    { "<?=$lng->text('contact')?>": "<?=$app->go('Contact')?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
    <div class="row">
		<div class="col-xs-12 clearfix">
			<div class="links">
				<a class="back pull-right" target="_blank" href="https://goo.gl/maps/zz7fNDT1G5U2"><?=$lng->text('contact:view_map')?></a>
				<a class="back" href="<?=$app->go($app->module_key)?>">&laquo; <?=$lng->text('contact:back')?></a>
			</div>

			<iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3592.5492782546476!2d-80.3248193845333!3d25.785446983625906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b90a60b2fee5%3A0x9c44b959a094cb1d!2s1352+NW+78th+Ave%2C+Doral%2C+FL+33126!5e0!3m2!1sen!2sus!4v1445967127849" allowfullscreen></iframe>
		</div>
	</div>
</view>


<view key="page_scripts">
</view>

