<?php
class CostCtrl extends AdminCtrl {
	protected $mod = 'Cost';


	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'title'		=> $this->get_input('title', '', true),
					'cost_key'	=> $this->get_input('cost_key', '', true, 'lower'),
					'value'		=> $this->get_input('value', 0.00),
					'id'		=> $this->get_input('id', 0),
				);

			$error_fields = $this->validate_data($data, array(
					'title' 	=> array('string', false, 1),
					'cost_key' 	=> array('string', false, 1),
					'value' 	=> array('num'),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			$object->set_title($data['title']);
			$object->set_cost_key($data['cost_key']);
			$object->set_value($data['value']);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;

		}
	}

}
?>