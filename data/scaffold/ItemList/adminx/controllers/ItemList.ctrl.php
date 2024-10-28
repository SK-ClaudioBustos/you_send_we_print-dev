<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemListCtrl
 * GENERATION DATE:  2020-04-24
 * -------------------------------------------------------
  *
 */

class ItemListCtrl extends CustomCtrl {
	protected $mod = 'ItemList';
	protected $class = 'ItemList';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row) {
		return array(
				'',
				$objects->get_title(),
				$objects->get_item_list_key(),
				$objects->get_calc_by(),
				$objects->get_has_cut(),
				$objects->get_has_max(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false) {
		$args['searchfields'] = 'title';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_save() {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'item_list_key' => $this->get_input('item_list_key', '', true),
					'title' => $this->get_input('title', '', true),
					'description' => $this->get_input('description', '', true),
					'calc_by' => $this->get_input('calc_by', '', true),
					'standard' => $this->get_input('standard', 0),
					'has_cut' => $this->get_input('has_cut', 0),
					'has_max' => $this->get_input('has_max', 0),
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
			$object->set_item_list_key($data['item_list_key']);
			$object->set_title($data['title']);
			$object->set_description($data['description']);
			$object->set_calc_by($data['calc_by']);
			$object->set_standard($data['standard']);
			$object->set_has_cut($data['has_cut']);
			$object->set_has_max($data['has_max']);
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
				$this->lng->text('itemlist:item_list_key'),
				$this->lng->text('itemlist:title'),
				$this->lng->text('itemlist:description'),
				$this->lng->text('itemlist:calc_by'),
				$this->lng->text('itemlist:standard'),
				$this->lng->text('itemlist:has_cut'),
				$this->lng->text('itemlist:has_max'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_item_list_key(),
					$objects->get_title(),
					$objects->get_description(),
					$objects->get_calc_by(),
					$objects->get_standard(),
					$objects->get_has_cut(),
					$objects->get_has_max(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}
	
}
?>
