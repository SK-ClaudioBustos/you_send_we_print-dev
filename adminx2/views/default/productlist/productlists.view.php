<?php
$grid_setup = array(
	'cols' => array(
//			'product_key' => array( 'width' => '220', 'caption' => 'productlist:product_key', 'edit' => true ),
			'product' => array( 'width' => '320', 'caption' => 'productlist:product', 'edit' => true ),
			'item_list_key' => array( 'width' => '', 'caption' => 'productlist:item_list_key' ),
		),
	'row_tools' => array( 'edt' => true, 'del' => true ),
	'new' => array( 'text' => 'productlist:new' ),
	'sort_field' => 'product_key',
	'sort_order' => 'ASC',
	'show_active' => true,
);
?>
<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_list');?>

<div id="client_area">
	<?=$tpl->get_view('_output/ajax_grid', array('grid_setup' => $grid_setup))?>
</div>
