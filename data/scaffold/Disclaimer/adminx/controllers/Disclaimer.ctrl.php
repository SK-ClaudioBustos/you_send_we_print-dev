<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        DisclaimerCtrl
 * GENERATION DATE:  2019-06-11
 * -------------------------------------------------------
  *
 */

class DisclaimerCtrl extends CustomCtrl {
	protected $mod = 'Disclaimer';
	protected $class = 'Document';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row) {
		return array(
				'',
				$objects->get_title(),
				$objects->get_featured(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false) {
		$args['searchfields'] = 'title';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		// temp
		$page_args = $parents = $users = array();

		/*
		$parents = new Parent();
		$parents->set_paging(1, 0, "`parent` ASC");

		$users = new User();
		$users->set_paging(1, 0, "`user` ASC");

		*/

		$page_args = array(
				'parents' => $parents,
				'users' => $users,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save() {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'document_key' => $this->get_input('document_key', '', true),
					'section_key' => $this->get_input('section_key', '', true),
					'category_key' => $this->get_input('category_key', '', true),
					'lang_iso' => $this->get_input('lang_iso', '', true),
					'parent_id' => $this->get_input('parent_id', 0),
					'featured' => $this->get_input('featured', 0),
					'pre_title' => $this->get_input('pre_title', '', true),
					'title' => $this->get_input('title', '', true),
					'subtitle' => $this->get_input('subtitle', '', true),
					'author' => $this->get_input('author', '', true),
					'brief' => $this->get_input('brief', '', true),
					'content' => $this->get_input('content', '', true),
					'source' => $this->get_input('source', '', true),
					'source_url' => $this->get_input('source_url', '', true),
					'order' => $this->get_input('order', 0),
					'status' => $this->get_input('status', 0),
					'date_begin' => $this->get_input('date_begin', ''),
					'date_end' => $this->get_input('date_end', ''),
					'user_id' => $this->get_input('user_id', 0),
					'pictures' => $this->get_input('pictures', 0),
					'expand_pic' => $this->get_input('expand_pic', 0),
					'filename' => $this->get_input('filename', '', true),
					'original_name' => $this->get_input('original_name', '', true),
					'meta_description' => $this->get_input('meta_description', '', true),
					'meta_keywords' => $this->get_input('meta_keywords', '', true),
					'created' => $this->get_input('created', ''),
					'active' => $this->get_input('active', 0),
					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					//'some_string' => array('string', false, 1),
					//'some_number' => array('num', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			// $this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_document_key($data['document_key']);
			$object->set_section_key($data['section_key']);
			$object->set_category_key($data['category_key']);
			$object->set_lang_iso($data['lang_iso']);
			$object->set_parent_id($data['parent_id']);
			$object->set_featured($data['featured']);
			$object->set_pre_title($data['pre_title']);
			$object->set_title($data['title']);
			$object->set_subtitle($data['subtitle']);
			$object->set_author($data['author']);
			$object->set_brief($data['brief']);
			$object->set_content($data['content']);
			$object->set_source($data['source']);
			$object->set_source_url($data['source_url']);
			$object->set_order($data['order']);
			$object->set_status($data['status']);
			$object->set_date_begin($data['date_begin']);
			$object->set_date_end($data['date_end']);
			$object->set_user_id($data['user_id']);
			$object->set_pictures($data['pictures']);
			$object->set_expand_pic($data['expand_pic']);
			$object->set_filename($data['filename']);
			$object->set_original_name($data['original_name']);
			$object->set_meta_description($data['meta_description']);
			$object->set_meta_keywords($data['meta_keywords']);
			$object->set_created($data['created']);
			$object->set_active($data['active']);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_export($args = false) {
		$version = array_shift($args);

		$objects = new $this->class();
		$objects->set_paging(1, 0, "`title` ASC", $filter);

		$header = array(
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
				$this->lng->text('document:order'),
				$this->lng->text('document:status'),
				$this->lng->text('document:date_begin'),
				$this->lng->text('document:date_end'),
				$this->lng->text('document:user_id'),
				$this->lng->text('document:pictures'),
				$this->lng->text('document:expand_pic'),
				$this->lng->text('document:filename'),
				$this->lng->text('document:original_name'),
				$this->lng->text('document:meta_description'),
				$this->lng->text('document:meta_keywords'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_document_key(),
					$objects->get_section_key(),
					$objects->get_category_key(),
					$objects->get_lang_iso(),
					$objects->get_parent(),
					$objects->get_featured(),
					$objects->get_pre_title(),
					$objects->get_title(),
					$objects->get_subtitle(),
					$objects->get_author(),
					$objects->get_brief(),
					$objects->get_content(),
					$objects->get_source(),
					$objects->get_source_url(),
					$objects->get_order(),
					$objects->get_status(),
					$objects->get_date_begin(),
					$objects->get_date_end(),
					$objects->get_user(),
					$objects->get_pictures(),
					$objects->get_expand_pic(),
					$objects->get_filename(),
					$objects->get_original_name(),
					$objects->get_meta_description(),
					$objects->get_meta_keywords(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}
	
}
?>
