<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal section-form">
		<div class="row">
			<div class="col-md-12">

				<div class="form-body form-body-top">
					<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'article:title', 'val' => $object->get_title(),
							'required' => true, 'error' => $object->is_missing('title')))?>
					<?=$tpl->get_view('_input/date', array('field' => 'date_begin', 'label' => 'article:date_begin', 'val' => $object->get_date_begin(),
							'required' => true, 'error' => $object->is_missing('date_begin')))?>
					<?=$tpl->get_view('_input/check', array('field' => 'active', 'label' => 'form:active', 'val' => 1, 
							'checked' => $object->get_active()))?>
					<?=$tpl->get_view('_input/text', array('field' => 'source_url', 'label' => 'article:source_url', 'val' => $object->get_source_url(),
							'required' => true, 'error' => $object->is_missing('source_url')))?>
					<?=$tpl->get_view('_input/textarea', array('field' => 'brief', 'label' => 'article:brief', 'val' => $object->get_brief(),
							'required' => true, 'error' => $object->is_missing('brief'), 'class' => 'mce-parent', 'ta_class' => 'tinymce'))?>
					<?=$tpl->get_view('_input/textarea', array('field' => 'content', 'label' => 'article:content', 'val' => $object->get_content(),
							'required' => true, 'error' => $object->is_missing('content'), 'class' => 'mce-parent', 'ta_class' => 'tallmce'))?>
					<div class="form-group"></div>

					<?=$tpl->get_view('_input/text', array('field' => 'meta_description', 'label' => 'article:meta_description', 'val' => $object->get_meta_description(),
							'required' => true, 'error' => $object->is_missing('meta_description')))?>
					<?=$tpl->get_view('_input/text', array('field' => 'meta_keywords', 'label' => 'article:meta_keywords', 'val' => $object->get_meta_keywords(),
							'required' => true, 'error' => $object->is_missing('meta_keywords')))?>
	
					<?=$tpl->get_view('_input/file_group', array('object' => $object, 'preview' => $preview))?>
				</div>

				<div class="form-actions">
					<?=$tpl->get_view('_input/submit')?>
				</div>

			</div>
		</div>

		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="id" value="<?=$object->get_id()?>" />
	</form>
</view>


<view key="page_scripts">
	<script>init_single();</script>
</view>
