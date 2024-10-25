<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProviderCtrl
 * GENERATION DATE:  2019-09-17
 * -------------------------------------------------------
  *
 */

class ProviderCtrl extends CustomCtrl {
	protected $mod = 'Provider';
	protected $class = 'Provider';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $args = []) {
		return array(
				'',
				$objects->get_active(),

				$objects->get_provider(),
				$objects->get_provider_email(),
				$objects->get_provider_phone(),
				$objects->get_provider_url(),
				$objects->get_provider_city(),
				$objects->get_provider_state(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'provider';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'provider' => $this->get_input('provider', '', true),
					'provider_address' => $this->get_input('provider_address', '', true),
					'provider_city' => $this->get_input('provider_city', '', true),
					'provider_state' => $this->get_input('provider_state', '', true),
					'provider_zip' => $this->get_input('provider_zip', '', true),
					'provider_email' => $this->get_input('provider_email', '', true),
					'provider_phone' => $this->get_input('provider_phone', '', true),
					'provider_url' => $this->get_input('provider_url', '', true),
					'active' => $this->get_input('active', 0),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'provider' => array('string', false, 1),
					'provider_address' => array('string', false, 1),
					'provider_city' => array('string', false, 1),
					'provider_state' => array('string', false, 1),
					'provider_zip' => array('string', false, 1),
					'provider_phone' => array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			$this->validate_email($data['provider_email'], $error_fields, $error, 'provider_email');

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_provider($data['provider']);
			$object->set_provider_address($data['provider_address']);
			$object->set_provider_city($data['provider_city']);
			$object->set_provider_state($data['provider_state']);
			$object->set_provider_zip($data['provider_zip']);
			$object->set_provider_email($data['provider_email']);
			$object->set_provider_phone($data['provider_phone']);
			$object->set_provider_url($data['provider_url']);
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
		$objects->set_paging(1, 0, "`provider` ASC", $filter);

		$header = array(
				$this->lng->text('provider:provider'),
				$this->lng->text('provider:provider_address'),
				$this->lng->text('provider:provider_city'),
				$this->lng->text('provider:provider_state'),
				$this->lng->text('provider:provider_zip'),
				$this->lng->text('provider:provider_email'),
				$this->lng->text('provider:provider_phone'),
				$this->lng->text('provider:provider_url'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_provider(),
					$objects->get_provider_address(),
					$objects->get_provider_city(),
					$objects->get_provider_state(),
					$objects->get_provider_zip(),
					$objects->get_provider_email(),
					$objects->get_provider_phone(),
					$objects->get_provider_url(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
