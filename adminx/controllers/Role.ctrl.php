<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        RoleCtrl
 * GENERATION DATE:  14.07.2013
 * -------------------------------------------------------
  *
 */

class RoleCtrl extends CustomCtrl {
	protected $mod = 'Role';


	protected function run_default($args, $action) {
		switch ($action) {
			default:
				if ($action) {
					$this->run_not_found($args);
				} else {
					$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
				}
		}
	}

	protected function get_row($objects, $args = [], $arg1 = []) {
		return array(
				'',
				$objects->get_role(),
				implode(' | ', $objects->get_permissions(false)),
			);
	}


	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'role' => $this->get_input('role', '', true),
					'description' => $this->get_input('description', '', true),
					'permissions' => $this->get_input('permissions', '', true),
					'display' => $this->get_input('display', 0),

					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					'role' 	=> array('string', false, 1),
					'permissions' => array('string', false, 1),
				));

			$error = $this->missing_fields($error_fields);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_role($data['role']);
			$object->set_description($data['description']);
			$object->set_permissions(stripslashes(html_entity_decode($data['permissions'])));
			$object->set_display($data['display']);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->cfg->app->go($this->app->module_key));
			exit;
		}
	}
}
?>
