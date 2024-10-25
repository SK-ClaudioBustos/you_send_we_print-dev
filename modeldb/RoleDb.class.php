<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        RoleDb
 * GENERATION DATE:  14.07.2013
 * -------------------------------------------------------
 *
 */


class RoleDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'role';
	protected $primary = 'role_id';

	protected $fields = array(
			'role' => false, 'description' => false, 'permissions' => false, 'display' => false, 'active' => false,
		);


	public function update($object, $fields = false) {
//		$fields = array(
//			'role' => false, 'description' => false, 'permissions' => $object->get_permissions(true), 'display' => false, 'active' => false,
//		);
		parent::update($object, $fields);
	}

	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'where' => "`display` = 1"
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'where' => "`display` = 1"
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

}
?>
