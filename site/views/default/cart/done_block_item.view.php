<?php
$detail = $object->get_detail();
?>
<tr>
	<td class="job_id"><?=sprintf('%08d', $object->get_id())?></td>
	<td class="job_name details clearfix">
		<h4><b><?=$object->get_job_name()?></b> - <em><?=$object->get_product()?></em></h4>
		<?=$tpl->get_view('cart/cart_block_item_details', array(
				'object' => $object,
				'items' => $items,
				'ws' => $ws,
				'sale_ship_address' => $sale_ship_address,
				'sale_shipping' => $sale_shipping,
				'images' => $images,
				'work_order' => $work_order,
				'items_array_by_key' => $items_array_by_key
			))?>
	</td>
	<?php if ($work_order) { ?>
	<td class="right qty"><?=$object->get_quantity()?></td>
	<td class="date_due"> <?=$date_due?></td>
	<?php } else { ?>
	<td class="right qty"><?=$object->get_quantity()?></td>
	<td class="right subtot">$ <?=$object->get_product_total()?></td>
	<?php } ?>
</tr>

<?php
if (!$hide_buttons) {
	$img_text = '';
	if ($count = $images->list_count() || ($object->get_status() == 'st_confirmed')) {
		for($i = 0; $images->list_paged(); $i++) {
			$img_text .= $images->get_filename() . ', ';
		}
		$img_text = substr($img_text, 0, strlen($img_text) - 2);

		if ($img_text) {
			?>
			<tr class="done_buttons">
				<td></td>
				<td colspan="3">
					<span class="images"><b><?=$lng->text('done:uploaded')?></b> <?=$img_text?></span>
				</td>
			</tr>
			<?php
		}
	}
}
?>

<tr class="done_buttons">
	<td class="loader"><img class="hidden" src="/data/site/loader2.gif" width="36" height="36" /></td>
	<td colspan="3">
		<?php
		if (!$hide_buttons) {
//echo '002 >>> ' . $images->list_count() . ' | ' . $object->get_status();
//exit;
			$count = $images->list_count();
			if (true) { //$count = $images->list_count() || ($object->get_status() == 'st_confirmed')) {
//echo '001 >>> ';
//exit;
				?>
				<div class="confirm clearfix">
					<?php if ($object->get_status_customer() == 'st_confirmed') { ?>
						<span class="confirmed"><span class="badge badge-green"><i class="fa fa-check"></i></span> <?=$lng->text('done:confirmed')?></span>
						<!-- <span class="info"><span class="badge badge-info"><i class="fa fa-info"></i></span> <?=/*
						$lng->text('done:ready_notify')*/ ''?></span> -->

					<?php } else if ($object->get_status_customer() == 'st_wait_proof') { ?>
						<span class="confirmed"><span class="badge badge-green"><i class="fa fa-check"></i></span> <?=$lng->text('done:confirmed')?></span>
						<span class="info"><span class="badge badge-info"><i class="fa fa-info"></i></span> <?=$lng->text('done:proof_notify')?></span>

					<?php } else if ($object->get_status_customer() == 'st_wait_appr') { ?>
						<span class="confirmed"><span class="badge badge-green"><i class="fa fa-check"></i></span> <?=$lng->text('done:confirmed')?></span>
						<span class="proof_ready"><span class="badge badge-proof"><i class="fa fa-image"></i></span>
							<?=sprintf($lng->text('done:proof_ready'),
									'<a href="' . $app->go($app->module_key . '/proof', false, '/' . $sale->get_hash() . '/' . $object->get_id()) . '">', '</a>')?></span>

					<?php } else if ($object->get_status_customer() == 'st_proof_appr') { ?>
						<span class="confirmed"><span class="badge badge-green"><i class="fa fa-check"></i></span> <?=$lng->text('done:proof_approved')?></span>
						<!-- <span class="info"><span class="badge badge-info"><i class="fa fa-info"></i></span> <?=/*
						$lng->text('done:ready_notify')*/''?></span> -->

					<?php } else if ($object->get_status_customer() == 'st_proof_rejt') { ?>
						<span class="confirmed"><span class="badge badge-green"><i class="fa fa-check"></i></span> <?=$lng->text('done:confirmed')?></span>
						<span class="info"><span class="badge badge-info"><i class="fa fa-info"></i></span> <?=$lng->text('done:proof_notify_new')?></span>

					<?php } else { // ready to production ?>
						<div class="clearfix">
							<a class="btn yswp-green btn-outline bt_upload" href="<?=$app->go($app->module_key . '/upload', false, '/' . $sale->get_hash() . '/' . $object->get_id())?>">
								<?=$lng->text(($count) ? 'done:change' : 'done:upload')?></a>
							<span class="txt_upload"><?=$lng->text('done:upload_text')?></span>
						</div>
						<div class="confirm clearfix">
							<a class="btn yswp-red bt_confirm"<?=(!$count) ? ' data-status="no_art"' : ''?> data-href="<?=$app->go($app->module_key, false, '/ajax_confirm/' . $sale->get_hash() . '/' . $object->get_id())?>">
								<?=$lng->text('done:confirm')?></a>
							<span class="txt_upload"><?=$lng->text('done:confirm_text')?></span>
						</div>

					<?php } ?>
				</div>
				<?php
			} else {
				// upload or send to production anyway
				?>
				<div class="clearfix">
					<a class="btn yswp-green btn-outline bt_upload" href="<?=$app->go($app->module_key . '/upload', false, '/' . $sale->get_hash() . '/' . $object->get_id())?>">
						<?=$lng->text('done:upload')?></a>
					<span class="txt_upload"><?=$lng->text('done:upload_text')?></span>
				</div>
				<div class="confirm clearfix">
					<a class="btn yswp-red bt_confirm" data-status="no_art" data-href="<?=$app->go($app->module_key, false, '/ajax_confirm/' . $sale->get_hash() . '/' . $object->get_id())?>">
						<?=$lng->text('done:confirm')?></a>
					<span class="txt_upload"><?=$lng->text('done:confirm_text')?></span>
				</div>
				<?php
			}
		}
		?>
	</td>
</tr>
