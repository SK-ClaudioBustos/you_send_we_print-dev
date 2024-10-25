<div class="col-md-12">
	<div class="info_full">
		<h2><?=$lng->text('home:experienced')?></h2>
	</div>
</div>
<?php 
foreach($experiences as $experience) { 
	$url = ($experience['url']['root']) ? $app->go('experience/' . $experience['url']['root'], false, '/' . $experience['url']['experience']) : false;
	?>
	<div class="col-md-3 col-xs-6">
		<div class="img">
			<img class="img-responsive" loading="lazy" src="<?=$experience['image']?>" alt="<?=$experience['title']?>" />
			<h3><?=$experience['title']?></h3>
			<p><?=$experience['text']?></p>
		</div>
	</div>
	<?php 
} 
?>
