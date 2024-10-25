<?php
$show_tabs = ($object->get_id() && (substr_count($object->get_parent_path(), '/') > 1) && (!$object->has_children()));
?>
<h1><?=$title?></h1>

<?=$tpl->get_view('_elements/breadcrumb_item', array('object' => $object));?>

<div id="client_area">
	<ul class="spp_tabs">
		<li><a class="current" href="#"><?=$lng->text('product:tab:main')?></a></li>
		<?php
		if ($show_tabs) {
			?>
			<li><a href="#"><?=$lng->text('product:tab:intro')?></a></li>
			<li><a href="#"><?=$lng->text('product:tab:overview')?></a></li>
			<li><a href="#"><?=$lng->text('product:tab:application')?></a></li>
			<li><a href="#"><?=$lng->text('product:tab:specs')?></a></li>
			<li><a href="#"><?=$lng->text('product:tab:details')?></a></li>
			<?php if ($provider_id !== false) { ?>
			<li><a href="#"><?=$lng->text('product:tab:provider')?></a></li>
			<?php } ?>
			<?php if ($sizes) { ?>
			<li><a href="#"><?=$lng->text('product:tab:sizes')?></a></li>
			<?php } ?>
			<?php
		}
		?>

		<?php if ($is_parent) { //if ($parent && (!in_array($parent->get_measure_type(), array('standard', 'fixd-fixd')))) { ?>
		<li><a href="#"><?=$lng->text('product:tab:details')?></a></li>
		<?php } ?>
		<?php if ($object->get_id() && $children) { ?>
		<li><a href="#"><?=$lng->text('product:tab:order')?></a></li>
		<?php } ?>
		<li class="clear_float"></li>
	</ul>

	<form id="edit_form" name="edit_form" method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>">
		<div class="spp_panes">
			<div>
				<?=$tpl->get_view('product/product_main', array(
						'object' => $object,
						'is_parent' => $is_parent,
						'parents' => $parents,
						'parent' => $parent,
						'children' => $children,
						'measure_types' => $measure_types,
						'disclaimers' => $disclaimers,
					));?>
			</div>

			<?php
			if ($show_tabs) {
				?>

				<div>
					<?=$tpl->get_view('product/product_intro', array('object' => $object));?>
				</div>

				<div>
					<?=$tpl->get_view('product/product_overview', array('object' => $object));?>
				</div>

				<div>
					<?=$tpl->get_view('product/product_application', array('object' => $object));?>
				</div>

				<div>
					<?=$tpl->get_view('product/product_specs', array(
							'object' => $object, 
							'folder' => $folder, 
							'attach' => $attach,
						));?>
				</div>

				<div>
					<?=$tpl->get_view('product/product_details', array(
							'object' => $object, 
							'is_parent' => $is_parent,
							'parent' => $parent,
							'children' => $children,
							'featureds' => $featureds,
						));?>
				</div>

				<?php if ($provider_id !== false) { ?>
				<div>
					<?=$tpl->get_view('product/product_provider', array(
							'object' => $object, 
							'providers' => $providers,
						));?>
				</div>
				<?php } ?>

				<?php if ($sizes) { ?>
				<div>
					<?=$tpl->get_view('product/product_sizes', array(
							'object' => $object,
							'sizes' => $sizes,
							'provider_id' => $provider_id,
							'fineart' => $fineart,
						));?>
				</div>
				<?php } ?>
				<?php
			}
			?>

			<?php
			if ($is_parent || !$children) {
/*
				<div>
					<?=$tpl->get_view('product/product_metatags', array('object' => $object));?>
				</div>
*/
				?>
				<?php
			}

			//if ($parent && (!in_array($parent->get_measure_type(), array('standard', 'fixd-fixd')))) {
			if ($is_parent) {
				?>
				<div>
					<?=$tpl->get_view('product/product_details', array('object' => $object, 'children' => $children));?>
				</div>
				<?php
			}
			if ($children) {
				?>
				<div>
					<?=$tpl->get_view('product/product_children', array('object' => $object, 'children' => $children));?>
				</div>
				<?php
			}
			?>

		</div>
		<input type="hidden" name="order" id="order" value="" />
		<input type="hidden" name="order_changed" id="order_changed" value="0" />
		<input type="hidden" name="lang_iso" value="es" />
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />

		<input type="submit" id="submit" name="submit" class="submit_form" value="<?=$lng->text('form:save')?>" />
		<input type="button" id="cancel" name="cancel" class="cancel_form" value="<?=$lng->text('form:cancel')?>" />
	</form>
</div>

<script type="text/javascript" src="<?=$cfg->url->tinymce_folder?>/jquery.tinymce.js"></script>
<script type="text/javascript">
	var tinymce_folder = '<?=$cfg->url->tinymce_folder?>';
	var lang_iso = '<?=$lng->get_lang_iso()?>';
	var fineart = <?=($fineart) ? 'true' : 'false'?>;

	init_single(<?=($children) ? 1 : 0?>, <?=($sizes) ? 1 : 0?>);
</script>
