<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PictureCtrl
 * GENERATION DATE:  2018-06-18
 * -------------------------------------------------------
  *
 */

class PictureCtrl extends CustomCtrl {
	protected $mod = 'Picture';
	protected $class = 'Picture';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_active(),

				$objects->get_picture(),
				$objects->get_category(),
				$objects->get_filename(),
				$objects->get_original_name(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'picture';
		$args['active_only'] = false;

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_download($args) {
		if ($id = $this->get_url_arg($args, 0)) {
			$object = new $this->class($id);
			$page_args = array(
					'file' => $object->get_filename(),
					'filename' => $object->get_original_name(),
					'folder' => 'picture',
				);
			if ($object->get_id() && $page_args['file']) {
				parent::run_download($page_args);
			} else {
				// ?
			}
		}
	}

	protected function run_single($object, $args = array()) {
		$categories = new Category();
		$categories->set_paging(1, 0, "`category` ASC", array("`tbl_category`.`parent_id` > 0"));

		$preview = false;
		if ($object->get_filename()) {
			$preview = '/image/picture/0/' . $object->get_filename();
		}

		$preview_sq = false;
		if ($object->get_filename_sq()) {
			$preview_sq = '/image/picture/0/' . $object->get_filename_sq();
		}

		$picture_tags = new PictureTag();
		$picture_tags->set_paging(1, 0, "`picture_tag` ASC");

		$page_args = array(
				'categories' => $categories,
				'picture_tags' => $picture_tags,
				'preview' => $preview,
				'preview_sq' => $preview_sq,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'picture' => $this->get_input('picture', '', true),
					'description' => $this->get_input('description', '', true),
					'category_id' => $this->get_input('category_id', 0),
					'tags' => $this->get_input('tags', array( 0 ), true),

					'remove' => $this->get_input('remove', 0),
					'remove_sq' => $this->get_input('remove_sq', 0),
					'active' => $this->get_input('active', 0),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					//'some_string' => array('string', false, 1),
					'category_id' => array('num', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			// $this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_picture($data['picture']);
			$object->set_description($data['description']);
			$object->set_category_id($data['category_id']);
			$object->set_tags($data['tags']);
			$object->set_active($data['active']);

			if ($data['remove']) {
				$file = $this->cfg->path->data . '/picture/' . $object->get_filename();
				$object->set_filename('');
				$object->set_original_name('');
				if (file_exists($file)) {
					unlink($file);
				}
			}

			if ($data['remove_sq']) {
				$file = $this->cfg->path->data . '/picture/' . $object->get_filename_sq();
				$object->set_filename_sq('');
				$object->set_original_name_sq('');
				if (file_exists($file)) {
					unlink($file);
				}
			}

			if ($this->save($object, $error, 'return')) {
				// set label if not present
				if (!$data['picture']) {
					$object->set_picture('ID ' . sprintf('%06d', $object->get_id()));
				}

				// save rectangular picture
				$folder = $this->cfg->path->data . '/picture/';
				$filename = 'id_' . sprintf('%06d', $object->get_id());
				$result = $this->save_attach($folder, 'filename', $this->app->file_extensions, $filename, $original_name);
				if ($result === true) {
					$object->set_filename($filename);
					$object->set_original_name($original_name);
				} else {
					//error_log('invoice_attach: ' . $result);
				}

				// save square picture
				$folder = $this->cfg->path->data . '/picture/';
				$filename = sprintf('id_%06d_sq', $object->get_id()) ;
//echo $filename;
//exit;
				$result = $this->save_attach($folder, 'filename_sq', $this->app->file_extensions, $filename, $original_name);
				if ($result === true) {
					$object->set_filename_sq($filename);
					$object->set_original_name_sq($original_name);
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
		$objects->set_paging(1, 0, "`picture` ASC", $filter);

		$header = array(
				$this->lng->text('picture:picture'),
				$this->lng->text('picture:description'),
				$this->lng->text('picture:filename'),
				$this->lng->text('picture:original_name'),
				$this->lng->text('picture:category_id'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_picture(),
					$objects->get_description(),
					$objects->get_filename(),
					$objects->get_original_name(),
					$objects->get_category(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
