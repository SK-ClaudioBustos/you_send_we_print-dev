<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PropertyCtrl
 * GENERATION DATE:  22.01.2016
 * -------------------------------------------------------
  *
 */

class PropertyCtrl extends CustomCtrl {
	protected $mod = 'Property';


	protected function run_multiple($args = []) {
		$user = $this->app->user;
		$superadmin = ($user->get_role_id() == Role::enum('superadmin'));

		$page_args = array('superadmin' => $superadmin);
		parent::run_multiple($page_args);
	}

	protected function run_single($object, $args = false) {
		$user = $this->app->user;
		$superadmin = ($user->get_role_id() == Role::enum('superadmin'));

		$types = array(
				'str' => $this->lng->text('property:str'),
				'int' => $this->lng->text('property:int'),
				'dec' => $this->lng->text('property:dec'),
				'trf' => $this->lng->text('property:trf'),
				'jsn' => $this->lng->text('property:jsn'),
			);

		$page_args = array('superadmin' => $superadmin, 'types' => $types);
		parent::run_single($object, $page_args);
	}


	protected function get_row($objects, $args = [], $arg1 = false, $arg2 = false) {
		switch($objects->get_type()) {
			case 'str':
			case 'jsn':		$value = $objects->get_value_str(); break;
			case 'int':		$value = (int)$objects->get_value(); break;
			case 'dec':		$value = $objects->get_value(); break;
			case 'trf':		$value = ((int)$objects->get_value()) ? '<i class="fa fa-check-square-o"></i>' : '<i class="fa fa-square-o"></i>'; break;
		}

		return array(
				'',
				$objects->get_property(),
				$objects->get_property_key(),
				$this->lng->text('property:' . $objects->get_type()),
				($objects->get_hidden()) ? '<i class="fa fa-check-square-o"></i>' : '<i class="fa fa-square-o"></i>',
				$value,
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = array('property', 'property_key');

		$user = $this->app->user;
		$filter = array();
		if ($user->get_role_id() != Role::enum('superadmin')) {
			$filter[] = "`hidden` = 0";
		}
		$args['filter'] = $filter;
		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'property_key' => $this->get_input('property_key', '', true),
					'property' => $this->get_input('property', '', true),
					'type' => $this->get_input('type', '', true),

					'value' => $this->get_input('value', 0.00),
					'value_trf' => $this->get_input('value_trf', 0),
					'value_str' => $this->get_input('value_str', '', true),
					'value_jsn' => $this->get_input('value_jsn', '', true),

					'hidden' => $this->get_input('hidden', 0),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'property_key' 	=> array('string', false, 1),
					'property'		=> array('string', false, 1),
					'type'			=> array('string', false, 1),
				));

			if ($data['type']) {
				if ($data['type'] == 'str') {
					$value_req = $this->validate_data($data, array(
							'value_str'	=> array('string', false, 1),
						));

				} else if ($data['type'] == 'jsn') {
					$value_req = $this->validate_data($data, array(
							'value_jsn'	=> array('string', false, 1),
						));

				} else {
					$value_req = $this->validate_data($data, array(
							'value'		=> array('string', false, 1),
						));
				}
				$error_fields = array_merge($error_fields, $value_req);
			}

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object, only superadmins
			$user = $this->app->user;
			if ($user->get_role_id() == Role::enum('superadmin')) {
				$object->set_property_key($data['property_key']);
				$object->set_property($data['property']);
				$object->set_type($data['type']);
				$object->set_hidden($data['hidden']);
			}

			switch($object->get_type()) {
				case 'int':
					$object->set_value_str('');
					$object->set_value((int)$data['value']);
					break;
				case 'trf':
					$object->set_value_str('');
					$object->set_value($data['value_trf']);
					break;
				case 'dec':
					$object->set_value_str('');
					$object->set_value(number_format($data['value'], 2, '.', ''));
					break;
				case 'jsn':
					$object->set_value(0);
					$object->set_value_str((string)html_entity_decode($data['value_jsn']));
					break;
				default: // str
					$object->set_value(0);
					$object->set_value_str((string)html_entity_decode($data['value_str']));
			}

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
		$objects->set_paging(1, 0, "`property` ASC", $filter);

		$header = array(
				$this->lng->text('property:property_key'),
				$this->lng->text('property:property'),
				$this->lng->text('property:type'),
				$this->lng->text('property:value'),
				$this->lng->text('property:value_str'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_property_key(),
					$objects->get_property(),
					$objects->get_type(),
					$objects->get_value(),
					$objects->get_value_str(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel('Property', $headers, $rows, array());
		$this->export_excel($objPHPExcel, 'propertys', 'Property', $version);
	}

}
?>
