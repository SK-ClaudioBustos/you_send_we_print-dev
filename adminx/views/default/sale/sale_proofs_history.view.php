<?
$count = sizeof($proofs[$image_id]);
if (!$count) {
	?>
		<table class="table table-hover sale-table proof-table">
			<thead>
				<tr><th class="col-md-2"></th><td class="col-md-6"><?=$lng->text('proof:no_proofs')?></td></tr>
			</thead>
		</table>
	<?
} else {
	$nro = $count;
	foreach($proofs[$image_id] as $proof) {
		$url_folder = '/bgimage/sale/' . sprintf('%08s', $object->get_sale_id());
		$url_thm = $url_folder . '/240x200/' . $proof['newname'];
		$url_img = $url_folder . '/800x600/' . $proof['newname'];
		$url_download = $app->go($app->module_key, false, '/download/') . sprintf('%08s', $object->get_sale_id()) . '/' . $proof['newname'];
		?>
		<table class="table table-hover sale-table proof-table">
			<thead>
				<tr>
					<th class="col-md-2"><b><?=$lng->text('proof:version') . $nro?></b></th>
					<td class="col-md-6<?=($count > 1) ? ' first' : ''?>">
						<a href="<?=$url_img?>" class="fancybox-button" data-rel="fancybox-button">
							<img alt="" src="<?=$url_thm?>" /></a><br />
						<?=$proof['newname']?><br />
						<a class="download" href="<?=$url_download?>"><i class="fa fa-download"></i> <?=$lng->text('sale:img:download')?></td>
				</tr>
				<tr><th><?=$lng->text('sale:img:original')?></th><td><?=$proof['filename']?></td></tr>
				<tr><th><?=$lng->text('sale:img:size')?></th><td><?=$proof['size']?> KB</td></tr>
				<tr><th><?=$lng->text('sale:img:comments')?></th><td><?=$proof['description']?></td></tr>
				<tr><th><?=$lng->text('proof:status')?></th><td><?=$proof['status']?></td></tr>
				<tr><th><?=$lng->text('proof:response')?></th><td><?=$proof['response']?></td></tr>
			</thead>
		</table>
		<?
		$nro--;
	}
}
?>
