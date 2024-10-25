<?php
$grid_setup = array(
	'cols' => array(
			'product_code' => array( 'width' => '70', 'caption' => 'product:product_code', 'tooltip' => true ),
			'title' => array( 'width' => '280', 'caption' => 'product:title', 'edit' => true, 'tooltip' => true ),
			'path' => array( 'width' => '', 'caption' => 'product:path', 'tooltip' => true ),
		),
	'row_tools' => array( 'edt' => true, 'del' => true, 'act' => true, ),
	'new' => array( 'text' => 'product:new' ),
	'sort_field' => 'path',
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
					<label for="parent_path"><?=$lng->text('product:filter')?></label>
					<select name="parent_path" id="parent_path">
						<option value="">[All]</option>
						<?php
						foreach($parents as $key => $value) {
							if (substr_count($key, '/') < 4) {
								$selected = (($parent_path == $key) ? ' selected="selected"' : '');
								echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
							}
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
	$(function() {
		$('#parent_path').change(function() {
			$filter = "";
			if ($val = $('#parent_path').val()) {
				$filter = "`path` like '" + $('#parent_path').val() + "%'";
			}
			$page_args = JSON.stringify({ parent_path: $val });
			get_rows(1);
		});
	});
</script>

