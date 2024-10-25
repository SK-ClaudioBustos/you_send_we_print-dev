<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=htmlentities($title)?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<?php
	$tab_error = $utl->get_tab_error($object->get_missing_fields(), array(
			array('title'),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
		));
	?>

	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal product-form">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_main" data-toggle="tab"><?=$lng->text('product:tab:main') . $tab_error[0]?></a></li>
			<?php if ($object->get_id()) { ?>
				<?php if (in_array($object->get_product_type(), array('product-single', 'subproduct'))) { ?>
					<li><a href="#tab_details" data-toggle="tab"><?=$lng->text('product:tab:details') . $tab_error[5]?></a></li>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('product-single', 'product-multiple', 'subproduct'))) { ?>
					<li><a href="#tab_discounts" data-toggle="tab"><?=$lng->text('product:tab:discounts') . $tab_error[6]?></a></li>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('product-single', 'subproduct'))) { ?>
					<li><a href="#tab_provider" data-toggle="tab"><?=$lng->text('product:tab:provider') . $tab_error[7]?></a></li>
				<?php } ?>

				<?php if ($sizes) { ?>
					<li><a href="#tab_sizes" data-toggle="tab"><?=$lng->text('product:tab:sizes') . $tab_error[8]?></a></li>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('category', 'group', 'product-multiple'))) { ?>
					<li><a href="#tab_order" data-toggle="tab"><?=$lng->text('product:tab:order')?></a></li>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('product-single', 'product-multiple'))) { ?>
					<li><a href="#tab_form" data-toggle="tab"><?=$lng->text('product:tab:form') . $tab_error[10]?></a></li>
				<?php } ?>

				<?php 
				// product info -------------------------------------------------------------------------------
				if (in_array($object->get_product_type(), array('subproduct'))) { ?>
					<li><a href="#tab_intro" data-toggle="tab" class="separator"><?=$lng->text('product:tab:intro') . $tab_error[1]?></a></li>
					<li><a href="#tab_overview" data-toggle="tab"><?=$lng->text('product:tab:overview') . $tab_error[3]?></a></li>
				<?php } else if (in_array($object->get_product_type(), array('product-single', 'subproduct'))) { ?>
					<li><a href="#tab_overview" data-toggle="tab" class="separator"><?=$lng->text('product:tab:overview') . $tab_error[3]?></a></li>
				<?php } ?>

				<?php 
				if (in_array($object->get_product_type(), array('product-single', 'subproduct'))) { ?>
					<li><a href="#tab_specs" data-toggle="tab"><?=$lng->text('product:tab:specs') . $tab_error[4]?></a></li>
					<li><a href="#tab_datasheets" data-toggle="tab"><?=$lng->text('product:tab:datasheets') . $tab_error[2]?></a></li>
					<li><a href="#tab_marketing" data-toggle="tab"><?=$lng->text('product:tab:marketing') . $tab_error[4]?></a></li>
				<?php } ?>

			<?php } ?>
		</ul>

		<div class="form-body">
			<div class="tab-content">
				<div class="tab-pane active in" id="tab_main">
					<?=$tpl->get_view('product/product_main', array(
							'object' => $object,

							'parents' => $parents,
							'parent' => $parent,
							'product_groups' => $product_groups,

							'children' => $children,

							'measure_type' => $measure_type,
							'standard_type' => $standard_type,

							'measure_types' => $measure_types,
							'standard_types' => $standard_types,
							'product_types' => $product_types,
							
							'disclaimers' => $disclaimers,
							'featureds' => $featureds,
						));?>
				</div>

				<?php if (in_array($object->get_product_type(), array('product-single', 'subproduct'))) { ?>
					<div class="tab-pane" id="tab_details">
						<?=$tpl->get_view('product/product_details', array('object' => $object, 'parent' => $parent));?>
					</div>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('product-single', 'product-multiple', 'subproduct'))) { ?>
					<div class="tab-pane" id="tab_discounts">
						<?=$tpl->get_view('product/product_discounts', array('object' => $object, 'parent' => $parent));?>
					</div>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('product-single', 'subproduct'))) { ?>
					<div class="tab-pane" id="tab_provider">
						<?=$tpl->get_view('product/product_provider', array('object' => $object, 'parent' => $parent, 'providers' => $providers));?>
					</div>
				<?php } ?>

				<?php if ($sizes) { ?>
					<div class="tab-pane" id="tab_sizes">
						<?=$tpl->get_view('product/product_sizes', array('object' => $object, 'sizes' => $sizes));?>
					</div>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('category', 'group', 'product-multiple'))) { ?>
					<div class="tab-pane" id="tab_order">
						<?=$tpl->get_view('product/product_order', array('object' => $object, 'children' => $children));?>
					</div>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('product-single', 'product-multiple'))) { ?>
					<div class="tab-pane" id="tab_form">
						<?=$tpl->get_view('product/product_form', array(
								'object' => $object, 
								'product_fields' => $product_fields,
								'form_lists' => $form_lists,
							));?>
					</div>
				<?php } ?>

				<?php if (in_array($object->get_product_type(), array('product-single', 'subproduct'))) { ?>
					<div class="tab-pane" id="tab_intro">
						<?=$tpl->get_view('product/product_intro', array('object' => $object));?>
					</div>

					<div class="tab-pane" id="tab_datasheets">
						<?=$tpl->get_view('product/product_datasheets', array('object' => $object));?>
					</div>

					<div class="tab-pane" id="tab_overview">
						<?=$tpl->get_view('product/product_overview', array('object' => $object));?>
					</div>

					<div class="tab-pane" id="tab_specs">
						<?=$tpl->get_view('product/product_specs', array('object' => $object));?>
					</div>

					<div class="tab-pane" id="tab_marketing">
						<?=$tpl->get_view('product/product_marketing', array('object' => $object));?>
					</div>

				<?php } ?>
			</div>
		</div>

		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn blue"><i class="icon-ok"></i> <?=$lng->text('form:save')?></button>
					<a type="button" class="btn default cancel" href="<?=$app->go($app->module_key)?>"><?=$lng->text('form:cancel')?></a>
				</div>
			</div>
		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
		<input type="hidden" name="order" id="order" value="" />
		<input type="hidden" name="order_changed" id="order_changed" value="0" />
		<input type="hidden" name="group_changed" id="group_changed" value="0" />
		<input type="hidden" name="sizes_str" id="sizes_str" value="" />
	</form>
</view>


<view key="page_scripts">
	<script type="text/javascript">
		var url_upload = '<?=$app->go($app->module_key, false, '/ajax_upload/')?>';

		init_single(<?=($children && $children->list_count(false)) ? 1 : 0?>, <?=($sizes) ? 1 : 0?>);
	</script>
</view>
