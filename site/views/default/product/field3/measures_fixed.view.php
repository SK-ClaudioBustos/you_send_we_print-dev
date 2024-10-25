<input type="hidden" name="width" id="width" value="<?=$product->get_width()?>" />
<input type="hidden" name="height" id="height" value="<?=$product->get_height()?>" />
<input type="hidden" name="closed" id="closed" value="1" />

<?=$tpl->get_view('product/field2/quantity', array('object' => $object, 'product' => $product, 'info' => $info, 'wholesaler' => $wholesaler))?>

