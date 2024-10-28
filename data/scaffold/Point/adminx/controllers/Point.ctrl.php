<?
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PointCtrl
 * GENERATION DATE:  2018-01-23
 * -------------------------------------------------------
  *
 */

class PointCtrl extends CustomCtrl {
	protected $mod = 'Point';
	protected $class = 'Point';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row) {
		return array(
				'',
				$objects->get_point(),
				$objects->get_chain(),
				$objects->get_manager(),
				$objects->get_leader(),
				$objects->get_state(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false) {
		$args['searchfields'] = 'point';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		// temp
		$page_args = $chains = $managers = $leaders = $states = array();

		/*
		$chains = new Chain();
		$chains->set_paging(1, 0, "`chain` ASC");

		$managers = new Manager();
		$managers->set_paging(1, 0, "`manager` ASC");

		$leaders = new Leader();
		$leaders->set_paging(1, 0, "`leader` ASC");

		$states = new State();
		$states->set_paging(1, 0, "`state` ASC");

		*/

		$page_args = array(
				'chains' => $chains,
				'managers' => $managers,
				'leaders' => $leaders,
				'states' => $states,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save() {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'point' => $this->get_input('point', '', true),
					'chain_id' => $this->get_input('chain_id', 0),
					'manager_id' => $this->get_input('manager_id', 0),
					'leader_id' => $this->get_input('leader_id', 0),
					'state_id' => $this->get_input('state_id', 0),
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
			$object->set_point($data['point']);
			$object->set_chain_id($data['chain_id']);
			$object->set_manager_id($data['manager_id']);
			$object->set_leader_id($data['leader_id']);
			$object->set_state_id($data['state_id']);
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
		$objects->set_paging(1, 0, "`point` ASC", $filter);

		$header = array(
				$this->lng->text('point:point'),
				$this->lng->text('point:chain_id'),
				$this->lng->text('point:manager_id'),
				$this->lng->text('point:leader_id'),
				$this->lng->text('point:state_id'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_point(),
					$objects->get_chain(),
					$objects->get_manager(),
					$objects->get_leader(),
					$objects->get_state(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}
	
}
?>
