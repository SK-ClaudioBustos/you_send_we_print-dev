<?php
$info_title = $info['packaging']['title'];
$info_text .= html_entity_decode($info['packaging']['info']);
?>
<?php //echo '>>> ' . $object->get_packaging(); exit; ?>

<?='';//$tpl->get_view('product/select', array('field' => 'packaging', 'label' => 'product:packaging', 'val' => $object->get_packaging(), 'options' => $packaging))?>

<div class="form-group">
    <label class="col-xs-6 col-sm-4"><?=$lng->text('product:packaging')?>&nbsp;&nbsp;<a href="#" class="info" data-target="packaging"><span class="badge badge-green">i</span></a></label>
    <div class="col-xs-6 col-sm-8">
		<?=$tpl->get_view('product/select_control', array(
				'label' => false,
				'field' => 'packaging',
				'options' => $packaging,
				'attr' => ' data-required="required" title="' . $lng->text('product:packaging') . '"',
			))?>
    </div>

	<div class="col-xs-12"><div class="sep-bottom"></div></div>
</div>

<div class="info info-packaging">
    <div class="info-title"><?=$info_title?></div>
    <div class="info-text"><?=$info_text?></div>
</div>