<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        CountryCtrl
 * GENERATION DATE:  2016-09-05
 * -------------------------------------------------------
  *
 */

class CountryCtrl extends CustomCtrl {
	protected $mod = 'Country';
	protected $class = 'Country';


	protected function get_row($objects, $arg1 = [], $arg2 = []) {
		return array(
				'',
				$objects->get_country(),
				$objects->get_country_key(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'country_id';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'country' => $this->get_input('country', '', true),
					'country_key' => $this->get_input('country_key', '', true),
					'active' => $this->get_input('active', 1),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'country' => array('string', false, 1),
					'country_key' => array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_country_key($data['country_key']);
			$object->set_country($data['country']);
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
		$objects->set_paging(1, 0, "`country_id` ASC", $filter);

		$header = array(
				$this->lng->text('country:country'),
				$this->lng->text('country:country_key'),
				$this->lng->text('country:lang_iso'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_country(),
					$objects->get_country_key(),
					$objects->get_lang_iso(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel('Country', $headers, $rows, array());
		$this->export_excel($objPHPExcel, 'countrys', 'Country', $version);
	}

}
?>
