<div class="clearfix">
	<div class="col-md-8">
		<?
		if (!$count = $images->list_count()) {
			?>
			<table class="table table-hover sale-table">
				<thead>
					<tr><th class="col-md-2"></th><td class="col-md-6"><?=$lng->text('sale:no_images')?></td></tr>
				</thead>
			</table>
			<?
		} else {
			$nro = 0;
			while($images->list_paged()) {
				$url_folder = '/bgimage/sale/' . sprintf('%08s', $object->get_sale_id());
				$url_thm = $url_folder . '/240x200/' . $images->get_newname();
				$url_img = $url_folder . '/800x600/' . $images->get_newname();
				$url_download = $app->go($app->module_key, false, '/download/') . sprintf('%08s', $object->get_sale_id()) . '/' . $images->get_newname();
				$extension = pathinfo($images->get_newname(), PATHINFO_EXTENSION);
				$nro++;
				?>
				<table class="table table-hover sale-table">
					<thead>
						<tr>
							<th class="col-md-2<?=($count > 1) ? ' first' : ''?>"><b><?=$lng->text('sale:img:image') . $nro?></b></th>
							<td class="col-md-6<?=($count > 1) ? ' first' : ''?>">
								<? /*if (in_array($extension, array('jpg', 'png'))) { ?>
								<a href="<?=$url_img?>" class="fancybox-button" data-rel="fancybox-button">
									<img alt="" src="<?=$url_thm?>" /></a><br />
								<? } */ ?>
								<?=$images->get_newname()?><br />
								<a class="download" href="<?=$url_download?>"><i class="fa fa-download"></i> <?=$lng->text('sale:img:download')?></td>
						</tr>
						<tr><th><?=$lng->text('sale:img:original')?></th><td><?=$images->get_filename()?></td></tr>
						<tr><th><?=$lng->text('sale:img:size')?></th><td><?=$tpl->size_format($images->get_size())?></td></tr>
						<tr><th><?=$lng->text('sale:img:quantity')?></th><td><?=$images->get_quantity() . ' ' . $lng->text('sale:img:units')?></td></tr>
						<tr><th><?=$lng->text('sale:img:comments')?></th><td><?=$images->get_description()?></td></tr>
					</thead>
				</table>
				<?
			}
		}
		?>
	</div>
</div>
