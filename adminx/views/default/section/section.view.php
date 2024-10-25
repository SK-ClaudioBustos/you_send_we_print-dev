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
						'field' => 'title', 'label' => 'section:title', 'val' => $object->get_title(),
						'required' => true, 'error' => $object->is_missing('title')
					)) ?>
					<?= $tpl->get_view('_input/text', array(
						'field' => 'document_key', 'label' => 'section:document_key', 'val' => $object->get_document_key(),
						'required' => true, 'error' => $object->is_missing('document_key'), 'width' => 3, 'readonly' => ($object->get_id())
					)) ?>
					<?= $tpl->get_view('_input/text', array(
						'field' => 'lang_iso', 'label' => 'section:lang_iso', 'val' => $object->get_lang_iso(),
						'required' => true, 'error' => $object->is_missing('lang_iso'), 'width' => 'small', 'attr' => 'maxlenght="2"',
						'readonly' => ($object->get_id())
					)) ?>
					<?= $tpl->get_view('_input/textarea', array(
						'field' => 'content', 'label' => 'section:content', 'val' => $object->get_content(),
						'required' => true, 'error' => $object->is_missing('content'), 'ta_class' => 'tallmce'
					)) ?>
					<?= $tpl->get_view('_input/text', array(
						'field' => 'meta_description', 'label' => 'section:meta_description', 'val' => $object->get_meta_description(),
						'required' => true, 'error' => $object->is_missing('meta_description')
					)) ?>
					<?= $tpl->get_view('_input/text', array(
						'field' => 'meta_keywords', 'label' => 'section:meta_keywords', 'val' => $object->get_meta_keywords(),
						'required' => true, 'error' => $object->is_missing('meta_keywords')
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