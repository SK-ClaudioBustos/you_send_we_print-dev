<?php
$filename = (strlen($filename = $image->get_filename()) > 50) ? substr($filename, 0, 48) . '&hellip;' : $filename;
$url_img = $url_folder . '/120x120/' . $image->get_newname();

$proof = $proofs[(string)$image->get_id()];
//print_r($proofs);
//exit;
$url_thm = $url_folder . '/480x320/' . $proof['newname'];
$url_prf = $url_folder . '/960x720/' . $proof['newname'];
$url_full = $url_folder . '/0/' . $proof['newname'];
$url_download = $app->go($app->module_key, false, '/download/sale/' . sprintf('%08s', $object->get_sale_id()) . '/' . $proof['newname']);

$url_approve = $app->go($app->module_key, false, '/ajax_approve/' . $sale_hash . '/' . $object->get_id() . '/' . $proof['id']); //$image->get_id());
?>
<div class="proof_item clearfix<?=($repeated) ? ' repeated' : ''?>" id="img_<?=$image->get_id()?>">
	<div class="row">
		<div class="col-xs-12">
			<h4>Image #<?=$nro?></h4>
			<p>
				<b><?=$lng->text('form:filename')?>:</b> <?=$filename?> (<?=$image->get_size()?> KB)<br />
				<b><?=$lng->text('product:upload_partial_qty')?>:</b> <?=$image->get_quantity() . ' ' . $lng->text('product:units')?>
			</p>
		</div>
	</div>

	<div class="row row-comment">
		<div class="col-xs-12">
			<h5>Proof #<?=$nro?></h5>
			<p><b><?=$lng->text('proof:comment')?>:</b> <?=($proof['description']) ? $proof['description'] : '-'?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-4 col-sm-2 tools">
			<a href="<?=$url_prf?>" class="tool_zoom fancybox"><span class="badge badge-proof"><i class="fa fa-search"></i></span><?=$lng->text('proof:zoom')?></a>
			<a href="<?=$url_full?>" target="_blank" class="tool_open"><span class="badge badge-proof"><i class="fa fa-image"></i></span><?=$lng->text('proof:open')?></a>
			<a href="<?=$url_download?>" class="tool_dwnl"><span class="badge badge-proof"><i class="fa fa-download"></i></span><?=$lng->text('proof:download')?></a>
		</div>

		<div class="col-xs-8 col-sm-4 proof">
			<a href="<?=$url_prf?>" class="fancybox">
				<img alt="" src="<?=$url_thm?>" class="img-responsive" />
			</a>
		</div>

		<div class="col-xs-12 col-sm-6<?=($proof['status'] == 'rejected') ? ' rejected' : ''?>">
			<div class="form-group group-status clearfix"<?=(!$proof['status']) ? ' style="display: none;"' : ''?>>
				<h5 class="<?=$proof['status']?>">
					<i class="fa fa-<?=($proof['status'] == 'approved') ? 'check' : 'close'?>"></i> <span><?=ucwords($proof['status'])?></span>
				</h5>
				<p><?=$proof['response']?></p>
			</div>

			<?php if (!$proof['status']) { // approved or rejected ?>
			<div class="form-group group-approve clearfix">
				<label for="description_<?=$proof['id']?>"><?=$lng->text('product:comments')?></label>
				<textarea rows="5" cols="20" class="form-control" id="description_<?=$proof['id']?>" name="description[]"></textarea>
				<p class="help"><?=$lng->text('proof:reject_comment')?></p>
				<div class="buttons">
					<button data-href="<?=$url_approve?>" class="btn btn-outline yswp-green bt_proof"><?=$lng->text('form:approve')?></button>
					<button data-href="<?=$url_approve?>" class="btn btn-outline yswp-red bt_proof reject"><?=$lng->text('form:reject')?></button>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
