<?=$tpl->get_view('product/field3/footer_subtotal', array('object' => $object, 'product' => $product, 'measure_type' => $measure_type))?>
<?=$tpl->get_view('product/field3/footer_turnaround', array('object' => $object, 'lists' => $lists, 'info' => $info))?>

<?php if (in_array('proof', $features)) { ?>
<?=$tpl->get_view('product/field3/footer_feat_proof', array('object' => $object, 'lists' => $lists, 'info' => $info))?>
<?php } ?>
<?php if (in_array('packaging', $features)) { ?>
<?=$tpl->get_view('product/field3/footer_feat_packaging', array('object' => $object, 'packaging' => $packaging, 'info' => $info))?>
<?php } ?>

<?=$tpl->get_view('product/field3/footer_total', array('object' => $object))?>
<?=$tpl->get_view('product/field3/footer_shipping', array('object' => $object, 'lists' => $lists, 'info' => $info, 'wholesaler' => $wholesaler, 'countries' => $countries))?>
