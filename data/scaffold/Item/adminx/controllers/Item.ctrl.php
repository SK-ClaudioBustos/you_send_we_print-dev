<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemCtrl
 * GENERATION DATE:  2019-06-11
 * -------------------------------------------------------
  *
 */

class ItemCtrl extends CustomCtrl {
	protected $mod = 'Item';
	protected $class = 'Item';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row) {
		return array(
				'',
				$objects->get_active(),

				$objects->get_title(),
				$objects->get_item_code(),
				$objects->get_item_list_key(),
				$objects->get_price(),
				$objects->get_calc_by(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false) {
		$args['searchfields'] = 'title';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_save() {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'item_code' => $this->get_input('item_code', '', true),
					'item_key' => $this->get_input('item_key', '', true),
					'item_list_key' => $this->get_input('item_list_key', '', true),
					'title' => $this->get_input('title', '', true),
					'description' => $this->get_input('description', '', true),
					'price' => $this->get_input('price', 0),
					'order' => $this->get_input('order', 0),
					'max_width' => $this->get_input('max_width', 0),
					'max_length' => $this->get_input('max_length', 0),
					'max_absolute' => $this->get_input('max_absolute', 0),
					'calc_by' => $this->get_input('calc_by', '', true),
					'weight' => $this->get_input('weight', 0),
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
			$object->set_item_code($data['item_code']);
			$object->set_item_key($data['item_key']);
			$object->set_item_list_key($data['item_list_key']);
			$object->set_title($data['title']);
			$object->set_description($data['description']);
			$object->set_price($data['price']);
			$object->set_order($data['order']);
			$object->set_max_width($data['max_width']);
			$object->set_max_length($data['max_length']);
			$object->set_max_absolute($data['max_absolute']);
			$object->set_calc_by($data['calc_by']);
			$object->set_weight($data['weight']);
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
				$this->lng->text('item:item_code'),
				$this->lng->text('item:item_key'),
				$this->lng->text('item:item_list_key'),
				$this->lng->text('item:title'),
				$this->lng->text('item:description'),
				$this->lng->text('item:price'),
				$this->lng->text('item:order'),
				$this->lng->text('item:max_width'),
				$this->lng->text('item:max_length'),
				$this->lng->text('item:max_absolute'),
				$this->lng->text('item:calc_by'),
				$this->lng->text('item:weight'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_item_code(),
					$objects->get_item_key(),
					$objects->get_item_list_key(),
					$objects->get_title(),
					$objects->get_description(),
					$objects->get_price(),
					$objects->get_order(),
					$objects->get_max_width(),
					$objects->get_max_length(),
					$objects->get_max_absolute(),
					$objects->get_calc_by(),
					$objects->get_weight(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}
	
}
?>
