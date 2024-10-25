<?php
$grid_setup = array(
	'cols' => array(
			'item_code' => array( 'width' => '50', 'caption' => 'item:item_code', 'tooltip' => true ),
			'title' => array( 'width' => '330', 'caption' => 'item:title', 'edit' => true, 'tooltip' => true ),
			'price' => array( 'width' => '40', 'caption' => 'item:price', 'align' => 'right' ),
			'item_list_key' => array( 'width' => '100', 'caption' => 'item:list' ),
			'calc_by' => array( 'width' => '', 'caption' => 'item:calc_by' ),
		),
	'row_tools' => array( 'edt' => true, 'del' => true ),
	'new' => array( 'text' => 'item:new' ),
	'sort_field' => 'item_code',
	'sort_order' => 'ASC',
	'show_active' => true,
	'filter' => $filter,
	'page_args' => $page_args,
);
?>
<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_list');?>

<div id="client_area">
	<form id="filter_form" name="filter_form" method="post" action="<?=$app->go()?>">
		<fieldset>
			<ol>
				<li class="medium">
					<label for="item_list"><?=$lng->text('item:list')?></label>
					<select name="item_list" id="item_list">
						<option value="">[All]</option>
						<?php
						foreach($item_lists as $key => $value) {
							$selected = (($item_list_key == $key) ? ' selected="selected"' : '');
							echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
						}
						?>
					</select>
				</li>
			</ol>
		</fieldset>
	</form>
	<?=$tpl->get_view('_output/ajax_grid', array('grid_setup' => $grid_setup))?>
</div>

<script type="text/javascript">
	init_multiple();
</script>

