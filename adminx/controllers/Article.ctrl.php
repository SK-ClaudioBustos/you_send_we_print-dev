<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ArticleCtrl
 * GENERATION DATE:  2016-05-03
 * -------------------------------------------------------
  *
 */

class ArticleCtrl extends CustomCtrl {
	protected $mod = 'Article';


	protected function get_row($objects, $args = [], $override = []) {
		return array(
				'',
				$objects->get_active(),

				$objects->get_title(),
				$objects->get_date_begin(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $mysql_parts = [], $override = [], $return = false) {
		$args['searchfields'] = 'title';
		$args['active_only'] = false;
		$args['filter'] = array("`section_key` = 'article'");

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_download($args) {
		if ($id = $this->get_url_arg($args, 0)) {
			$object = new $this->class($id);
			$page_args = array(
					'file' => $object->get_filename(),
					'filename' => $object->get_original_name(),
					'folder' => 'article',
				);
			if ($object->get_id() && $page_args['file']) {
				parent::run_download($page_args);
			} else {
				// ?
			}
		}
	}

	protected function run_single($object, $args = array()) {
		$preview = false;
		if ($object->get_filename()) {
			$preview = '/image/article/0/' . $object->get_filename();
		}

		$page_args = array(
				'preview' => $preview,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save( $args = [] ) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title'				=> $this->get_input('title', '', true),
					'lang_iso'			=> $this->get_input('lang_iso', '', false, 'lower'),
					'source_url'		=> $this->get_input('source_url', '', true, 'lower'),
					'brief'				=> $this->get_input('brief', '', true),
					'content'			=> $this->get_input('content', '', true),
					'date_begin'		=> $this->get_input('date_begin', ''),
					'meta_description'	=> $this->get_input('meta_description', '', true),
					'meta_keywords'		=> $this->get_input('meta_keywords', '', true),
					'active'			=> $this->get_input('active', 0),
					'del_thumbnail'		=> $this->get_input('del_thumbnail', 0),

					'id'				=> $this->get_input('id', 0),
				);
//print_r($data);
			$error_fields = $this->validate_data($data, array(
					'title' 			=> array('string', false, 1),
					'date_begin'		=> array('string', false, 1),
					'content' 			=> array('string', false, 1),
				));

//echo $data['date_begin'];
//exit;
			$date_fields = array();
			$date_begin = $this->get_date($data, 'date_begin', $date_fields);
			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			$object->set_title($data['title']);
			$object->set_section_key('article');
			$object->set_lang_iso('en');
			$object->set_source_url($data['source_url']);
			$object->set_brief($data['brief']);
			$object->set_content($data['content']);
			$object->set_date_begin($date_begin);
			$object->set_meta_description($data['meta_description']);
			$object->set_meta_keywords($data['meta_keywords']);
			$object->set_active($data['active']);

			if ($this->save($object, $error, 'return')) {
				// save attach
				$folder = $this->cfg->path->data . '/article/';
				$filename = 'id_' . sprintf('%06d', $object->get_id());
				$result = $this->save_attach($folder, 'filename', $this->app->file_extensions, $filename, $original_name);
				if ($result === true) {
					$object->set_filename($filename);
					$object->set_original_name($original_name);
				} else {
					//error_log('invoice_attach: ' . $result);
				}
				$object->update();
			}

			$go = ($id = $object->get_id()) ? '/edit/' . $id : '/new/';
			$go = $this->app->go($this->app->module_key, false, $go);
			header('Location: ' . $go);
			exit;

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

}
?>
