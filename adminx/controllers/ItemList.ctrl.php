<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemListCtrl
 * GENERATION DATE:  2019-10-30
 * -------------------------------------------------------
  *
 */

class ItemListCtrl extends CustomCtrl {
	protected $mod = 'ItemList';
	protected $class = 'ItemList';


	protected function run_default($args = [], $action = []) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_active(),
				$objects->get_title(),
				$objects->get_item_list_key(),
				$objects->get_calc_by(),
				$objects->get_description(),
				$objects->get_quantity_label(),
				$objects->get_quantity_info(),				
				$objects->get_has_cut(),
				$objects->get_has_max(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'title';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = false) {
		$calc_bys = ItemList::calc_by_list();

		$args = array('calc_bys' => $calc_bys);
		parent::run_single($object, $args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title' => $this->get_input('title', '', true),
					'item_list_key' => $this->get_input('item_list_key', '', true),
					'description' => $this->get_input('description', '', true),
					'quantity_label' => $this->get_input('quantity_label', '', true),
		            'quantity_info' => $this->get_input('quantity_info', '', true),					
					'calc_by' => $this->get_input('calc_by', '', true),

					'standard' => $this->get_input('standard', 1),
					'has_cut' => $this->get_input('has_cut', 0),
					'has_max' => $this->get_input('has_max', 0),

					'active' => $this->get_input('active', 1),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'title' => array('string', false, 1),
					'calc_by' => array('string', false, 1),
					//'some_number' => array('num', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_title($data['title']);
			$object->set_description($data['description']);
			$object->set_quantity_label($data['quantity_label']);
			$object->set_quantity_info($data['quantity_info']);
			
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

	protected function run_export($args = []) {
		$version = array_shift($args);

		$objects = new $this->class();
		$filter = [];
		$objects->set_paging(1, 0, "`title` ASC", $filter);

		$header = array(
				$this->lng->text('itemlist:item_list_key'),
				$this->lng->text('itemlist:title'),
				$this->lng->text('itemlist:description'),
				$this->lng->text('itemlist:calc_by'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_item_list_key(),
					$objects->get_title(),
					$objects->get_description(),
					$objects->get_calc_by(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
