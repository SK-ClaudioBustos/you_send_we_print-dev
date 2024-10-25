<?php
$mod = $cfg->app->module_key;
$key = strtolower($mod);
?>
<div id="breadcrumb">
	<?=$tpl->get_view('_elements/breadcrumb', array('breadcrumb' => array(
			$lng->text('home') => $cfg->app->go('Home'),
			$lng->text("{$key}:{$key}s") => $cfg->app->go(),
		)))?>
</div>
