<?php
class ItemListCtrl extends AdminCtrl {
	protected $mod = 'ItemList';


	protected function run_single($object, $args = false) {
		//$calc_bys = array('area' => 'Area', 'perimeter' => 'Perimeter', 'variable' => 'Variable', 'special' => 'Special');
		$calc_bys = ItemList::calc_by_list();

		$args = array('calc_bys' => $calc_bys);
		parent::run_single($object, $args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title'		=> $this->get_input('title', '', true),
					'calc_by'	=> $this->get_input('calc_by', ''),

					'id'		=> $this->get_input('id', 0),
				);

			$error_fields = $this->validate_data($data, array(
					'title' 		=> array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			$object->set_title($data['title']);
			$object->set_calc_by($data['calc_by']);
			$object->set_active(1);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;

		}
	}

}
?>