<div class="row">
	<?php 
	$len = (sizeof($gallery) > 3) ? 3 : sizeof($gallery);
	for ($i = 0; $i < $len; $i++) { 
		?>
		<div class="col-xs-4">
			<a href="<?=$gallery[$i]?>" data-fancybox="gallery">
				<img alt="" class="img-responsive" loading="lazy" src="<?=$gallery[$i]?>" />
			</a>
		</div>
		<?php 
	}
	?>
</div>

<?php if (sizeof($gallery) > 3) { ?>
<div class="row" style="margin-top: 20px;">
	<?php 
	$len = sizeof($gallery);
	for ($i = 3; $i < $len; $i++) { 
		?>
		<div class="col-xs-4">
			<a href="<?=$gallery[$i]?>" data-fancybox="gallery">
				<img alt="" class="img-responsive" loading="lazy" src="<?=$gallery[$i]?>" />
			</a>
		</div>
		<?php 
	}
	?>
</div>
<?php } ?>
