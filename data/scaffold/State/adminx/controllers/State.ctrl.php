<?
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        StateCtrl
 * GENERATION DATE:  2018-01-23
 * -------------------------------------------------------
  *
 */

class StateCtrl extends CustomCtrl {
	protected $mod = 'State';
	protected $class = 'State';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row) {
		return array(
				'',
				$objects->get_state(),
				$objects->get_region(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false) {
		$args['searchfields'] = 'state';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		// temp
		$page_args = $regions = array();

		/*
		$regions = new Region();
		$regions->set_paging(1, 0, "`region` ASC");

		*/

		$page_args = array(
				'regions' => $regions,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save() {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'state' => $this->get_input('state', '', true),
					'region_id' => $this->get_input('region_id', 0),
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
			$object->set_state($data['state']);
			$object->set_region_id($data['region_id']);
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
		$objects->set_paging(1, 0, "`state` ASC", $filter);

		$header = array(
				$this->lng->text('state:state'),
				$this->lng->text('state:region_id'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_state(),
					$objects->get_region(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}
	
}
?>
