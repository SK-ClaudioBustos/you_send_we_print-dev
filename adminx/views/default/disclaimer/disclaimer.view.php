<view key="page_metas">
</view>


<view key="breadcrumb">
	{ "<?=$lng->text('object:multiple')?>": "<?=$app->go($app->module_key)?>", "<?=$title?>": "<?=$app->page_full?>" }
</view>


<view key="body">
	<form method="post" enctype="multipart/form-data" action="<?=$app->go($app->module_key, false, '/save')?>" class="form form-horizontal disclaimer-form">
		<div class="row">
			<div class="col-md-12">

				<div class="form-body form-body-top">
					<?=$tpl->get_view('_input/text', array('field' => 'title', 'label' => 'disclaimer:title', 'val' => $object->get_title(),
							'required' => true, 'error' => $object->is_missing('title')))?>
					<?=$tpl->get_view('_input/check', array('field' => 'featured', 'label' => 'disclaimer:featured', 'val' => 1, 'checked' => $object->get_featured()))?>
					<?=$tpl->get_view('_input/textarea', array('field' => 'content', 'label' => 'disclaimer:content', 'val' => $object->get_content(),
							'required' => true, 'error' => $object->is_missing('content'), 'ta_class' => 'tallmce'))?>
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
	<script type="text/javascript">
		init_single();
	</script>
</view>
