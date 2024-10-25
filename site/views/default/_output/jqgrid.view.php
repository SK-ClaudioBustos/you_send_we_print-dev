<?php
$grid_id = (empty($grid_id) ? 'jqg-list' : $grid_id);
if ($search_id !== false) {
	$search_id = (empty($search_id) ? 'jqg-search' : $search_id);
	?>
	<div id="<?=$search_id?>"></div>
<?php } ?>
<table id="<?=$grid_id?>"></table>
<?php
if ($pager_id !== false) {
	$pager_id = (empty($pager_id) ? 'jqg-pager' : $pager_id);
	?>
	<div id="<?=$pager_id?>"></div>
<?php } ?>
