<?=$tpl->get_view('product/field2/standard', array('object' => $object, 'info' => $info, 'wholesaler' => $wholesaler, 'sizes' => $sizes, 'product' => $product, 'measure_type' => $measure_type))?>
<?=$tpl->get_view('product/field2/quantity', array('object' => $object, 'product' => $product, 'info' => $info, 'wholesaler' => $wholesaler))?>
<?=$tpl->get_view('product/field2/total_sqft', array('object' => $object, 'separator' => $separator))?>

