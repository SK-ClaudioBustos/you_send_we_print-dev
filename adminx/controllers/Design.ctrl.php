<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        DesignCtrl
 * GENERATION DATE:  2018-10-11
 * -------------------------------------------------------
  *
 */

class DesignCtrl extends CustomCtrl {
	protected $mod = 'Design';
	protected $class = 'Design';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_contact(),
				$objects->get_email(),
				$objects->get_phone(),
				$objects->get_website(),
				$objects->get_restaurant(),
				$objects->get_description(),
				$objects->get_filename(),
				$objects->get_original_name(),
				$objects->get_active(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'contact';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'contact' => $this->get_input('contact', '', true),
					'email' => $this->get_input('email', '', true),
					'phone' => $this->get_input('phone', '', true),
					'website' => $this->get_input('website', '', true),
					'restaurant' => $this->get_input('restaurant', '', true),
					'description' => $this->get_input('description', '', true),
					'filename' => $this->get_input('filename', '', true),
					'original_name' => $this->get_input('original_name', '', true),
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
			$object->set_contact($data['contact']);
			$object->set_email($data['email']);
			$object->set_phone($data['phone']);
			$object->set_website($data['website']);
			$object->set_restaurant($data['restaurant']);
			$object->set_description($data['description']);
			$object->set_filename($data['filename']);
			$object->set_original_name($data['original_name']);
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
		$objects->set_paging(1, 0, "`contact` ASC", $filter);

		$header = array(
				$this->lng->text('design:contact'),
				$this->lng->text('design:email'),
				$this->lng->text('design:phone'),
				$this->lng->text('design:website'),
				$this->lng->text('design:restaurant'),
				$this->lng->text('design:description'),
				$this->lng->text('design:filename'),
				$this->lng->text('design:original_name'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_contact(),
					$objects->get_email(),
					$objects->get_phone(),
					$objects->get_website(),
					$objects->get_restaurant(),
					$objects->get_description(),
					$objects->get_filename(),
					$objects->get_original_name(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
