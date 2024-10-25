<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PictureTagCtrl
 * GENERATION DATE:  2018-06-20
 * -------------------------------------------------------
  *
 */

class PictureTagCtrl extends CustomCtrl {
	protected $mod = 'PictureTag';
	protected $class = 'PictureTag';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_active(),

				$objects->get_picture_tag(),
				$objects->get_category(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'picture_tag';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		$categories = new Category();
		$categories->set_paging(1, 0, "`category` ASC", array("`tbl_category`.`parent_id` > 0"));

		$page_args = array(
				'categories' => $categories,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'picture_tag' => $this->get_input('picture_tag', '', true),
					'category_id' => $this->get_input('category_id', 0),
					'active' => $this->get_input('active', 0),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'picture_tag' => array('string', false, 1),
					//'some_number' => array('num', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			// $this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_picture_tag($data['picture_tag']);
			$object->set_category_id($data['category_id']);
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
		$objects->set_paging(1, 0, "`picture_tag` ASC", $filter);

		$header = array(
				$this->lng->text('picturetag:picture_tag'),
				$this->lng->text('picturetag:category_id'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_picture_tag(),
					$objects->get_category(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
