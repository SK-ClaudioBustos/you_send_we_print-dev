<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SectionCtrl
 * GENERATION DATE:  2016-05-03
 * -------------------------------------------------------
  *
 */

class SectionCtrl extends CustomCtrl {
	protected $mod = 'Section';
	protected $class = 'Document';

	protected function run_default($args, $action)
	{
		switch ($action) {
			case 'ajax_upload':
				$this->authorize('run_ajax_upload', $args, "perm:{$this->mod_key}");
				break;

			default:
				$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}


	protected function get_row($objects, $arg1 = [], $arg2 = []) {
		return array(
				'',
				$objects->get_title(),
				$objects->get_lang_iso(),
				$objects->get_document_key(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'title';
		$args['filter'] = array("`section_key` = 'section'");

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title'				=> $this->get_input('title', '', true),
					'document_key'		=> $this->get_input('document_key', '', true, 'lower'),
					'content'			=> $this->get_input('content', '', true),
					'lang_iso'			=> $this->get_input('lang_iso', ''),
					'meta_description'	=> $this->get_input('meta_description', '', true),
					'meta_keywords'		=> $this->get_input('meta_keywords', '', true),

					'id'				=> $this->get_input('id', 0),
				);

			$error_fields = $this->validate_data($data, array(
					'title' 			=> array('string', false, 1),
					'document_key' 		=> array('string', false, 1),
					//'content' 			=> array('string', false, 1),
					'lang_iso' 			=> array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			$object->set_title($data['title']);
			$object->set_section_key('section');
			$object->set_document_key($data['document_key']);
			$object->set_content($data['content']);
			$object->set_meta_description($data['meta_description']);
			$object->set_meta_keywords($data['meta_keywords']);
			$object->set_lang_iso($data['lang_iso']);
			$object->set_active(1);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_export($args = []) {
		$version = array_shift($args);

		$objects = new $this->class();
		$filter = [];
		$objects->set_paging(1, 0, "`title` ASC", $filter);

		$headers = array(
				$this->lng->text('document:document_key'),
				$this->lng->text('document:section_key'),
				$this->lng->text('document:category_key'),
				$this->lng->text('document:lang_iso'),
				$this->lng->text('document:parent_id'),
				$this->lng->text('document:featured'),
				$this->lng->text('document:pre_title'),
				$this->lng->text('document:title'),
				$this->lng->text('document:subtitle'),
				$this->lng->text('document:author'),
				$this->lng->text('document:brief'),
				$this->lng->text('document:content'),
				$this->lng->text('document:source'),
				$this->lng->text('document:source_url'),
				$this->lng->text('document:status'),
				$this->lng->text('document:date_begin'),
				$this->lng->text('document:date_end'),
				$this->lng->text('document:user_id'),
				$this->lng->text('document:pictures'),
				$this->lng->text('document:expand_pic'),
				$this->lng->text('document:meta_description'),
				$this->lng->text('document:meta_keywords'),
			);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_document_key(),
					$objects->get_section_key(),
					$objects->get_category_key(),
					$objects->get_lang_iso(),
					$objects->get_parent_id(),
					$objects->get_featured(),
					$objects->get_pre_title(),
					$objects->get_title(),
					$objects->get_subtitle(),
					$objects->get_author(),
					$objects->get_brief(),
					$objects->get_content(),
					$objects->get_source(),
					$objects->get_source_url(),
					$objects->get_status(),
					$objects->get_date_begin(),
					$objects->get_date_end(),
					$objects->get_user_id(),
					$objects->get_pictures(),
					$objects->get_expand_pic(),
					$objects->get_meta_description(),
					$objects->get_meta_keywords(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel('Document', $headers, $rows, array());
		$this->export_excel($objPHPExcel, 'documents', 'Document', $version);
	}

	protected function run_ajax_upload($args)
	{
		$folder = $this->cfg->path->data . '/product/';
		$filename = time();

		$result = $this->save_attach($folder, 'file', $this->app->file_extensions, $filename, $original_name);

		if ($result === true) {
			$url = $this->cfg->url->data . '/product/' . $filename;
			header("Content-type: application/json");
			echo json_encode(array('location' => $url));
		} else {
			header('HTTP/1.1 500 Server Error');
		}
	}

}
?>
