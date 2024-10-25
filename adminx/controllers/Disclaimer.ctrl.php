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

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_title(),
				$objects->get_featured(), // used for main disclaimer
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'title';
		$args['filter'] = array(
				"`section_key` = 'disclaimer'",
			);

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		$page_args = array(
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'section_key' => $this->get_input('section_key', 'disclaimer', true),
					'lang_iso' => $this->get_input('lang_iso', 'en', true),
					'featured' => $this->get_input('featured', 0),
					'title' => $this->get_input('title', '', true),
					'content' => $this->get_input('content', '', true),
					'active' => $this->get_input('active', 1),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'title' => array('string', false, 1),
					'content' => array('string', false, 1),
					//'some_number' => array('num', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			// $this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_section_key($data['section_key']);
			$object->set_lang_iso($data['lang_iso']);
			$object->set_featured($data['featured']);
			$object->set_title($data['title']);
			$object->set_content($data['content']);
			$object->set_active($data['active']);

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
