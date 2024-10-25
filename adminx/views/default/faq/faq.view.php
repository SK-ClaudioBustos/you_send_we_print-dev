<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?= $lng->text('object:multiple') ?>": "<?= $app->go($app->module_key) ?>", "<?= $title ?>": "<?= $app->page_full ?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?= $app->go($app->module_key, false, '/save') ?>" class="form form-horizontal section-form">
		<div class="row">
			<div class="col-md-12">

				<div class="form-body form-body-top">
					<?= $tpl->get_view('_input/text', array(
						'field' => 'title', 'label' => 'faq:title', 'val' => $object->get_title(),
						'required' => true, 'error' => $object->is_missing('title')
					)) ?>
					<?= $tpl->get_view('_input/select', array(
						'field' => 'category_key', 'label' => 'faq:category', 'val' => $object->get_category_key(),
						'required' => true, 'error' => $object->is_missing('category_key'), 'width' => 4,
						'options' => $categories, 'none_val' => '', 'none_text' => ''
					)) ?>
					<?= $tpl->get_view('_input/text', array(
						'field' => 'order', 'label' => 'faq:order', 'val' => $object->get_order(),
						'required' => false, 'error' => $object->is_missing('order'), 'width' => 'small', 'class' => 'number',
						'attr' => 'maxlenght="2"'
					)) ?>
					<?= $tpl->get_view('_input/textarea', array(
						'field' => 'content', 'label' => 'faq:content', 'val' => $object->get_content(),
						'required' => true, 'error' => $object->is_missing('content'), 'ta_class' => 'tallmce'
					)) ?>
				</div>

				<div class="form-actions">
					<?= $tpl->get_view('_input/submit') ?>
				</div>

			</div>
		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?= $object->get_id() ?>" />
	</form>
</view>


<view key="page_scripts">
	<script>
		var url_upload = '<?= $app->go($app->module_key, false, '/ajax_upload/') ?>';
		init_single();
	</script>
</view>