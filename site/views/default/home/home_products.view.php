<?php 
foreach($products as $product) { 
	//$url = ($product['url']['root']) ? $app->go('Product/' . $product['url']['root'], false, '/' . $product['url']['product']) : false;
	$url = ($product['url']['root']) ? $app->go('Product', false, '/' . $product['url']['product']) : false;
	?>
<div class="col-md-4 col-xs-6 mix">
	<a href="<?=$url?>">
		<div class="mix-inner">
			<img class="img-responsive" loading="lazy" src="<?=$product['image']?>" alt="<?=$product['title']?>" height="250" />
			
		</div>
		<div class="mix-details">
				<h4><?=$product['title']?></h4>
			</div>
	</a><br>
</div>
<?php } ?>
