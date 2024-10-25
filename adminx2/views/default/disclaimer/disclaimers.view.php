<?php
$grid_setup = array(
	'cols' => array(
			'title' => array( 'width' => '400', 'caption' => 'disclaimer:title', 'edit' => 'true' ),
			'document_key' => array( 'width' => '', 'caption' => 'disclaimer:document_key' ),
		),
	'row_tools' => array( 'edt' => true ),
	'new' => array( 'text' => 'disclaimer:new' ),
	'sort_field' => 'title',
	'sort_order' => 'ASC',
	'show_active' => 'true',
);
?>
<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_list');?>

<div id="client_area">
	<?=$tpl->get_view('_output/ajax_grid', array('grid_setup' => $grid_setup))?>
</div>
