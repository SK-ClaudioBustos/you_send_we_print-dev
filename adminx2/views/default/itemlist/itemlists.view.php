<?php
$grid_setup = array(
	'cols' => array(
			'title' => array( 'width' => '320', 'caption' => 'itemlist:title', 'edit' => true ),
			'item_list_key' => array( 'width' => '180', 'caption' => 'itemlist:item_list_key' ),
			'calc_by' => array( 'width' => '', 'caption' => 'itemlist:calc_by' ),
		),
	'row_tools' => array( 'edt' => true ),
	'new' => array( 'text' => 'itemlist:new' ),
	'sort_field' => 'title',
	'sort_order' => 'ASC',
	'show_active' => true,
);
?>
<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_list');?>

<div id="client_area">
	<?=$tpl->get_view('_output/ajax_grid', array('grid_setup' => $grid_setup))?>
</div>
