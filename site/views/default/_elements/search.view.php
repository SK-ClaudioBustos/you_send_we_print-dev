<div class="form-group clearfix">
    <div class="pull-left product_list">
        <?= $tpl->get_view('_input/select', array(
            'field' => 'product_list', 'label' => false, 'val' => '',
            'width' => 12, 'options' => $products, 'val_prop' => 'product_id', 'none_val' => '', 'none_text' => ''
        )) ?>
    </div>
</div>