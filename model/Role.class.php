<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Role
 * GENERATION DATE:  14.07.2013
 * -------------------------------------------------------
 *
 */

class Role extends Base {

	// Pseudo Enums

	private static $role_enum = array (
			'superadmin' => 1,
			'administrator' => 2,
			'user' => 4,
			'admin_yswp' => 9,
		);


	// Protected Vars

	protected $dbClass = 'RoleDb';

	protected $role = '';
	protected $description = '';
	protected $permissions = array();
	protected $display = '';


	// Getters

	public function get_string() { return $this->role; }

	public function get_role() { return $this->role; }
	public function get_description() { return $this->description; }
	public function get_display() { return $this->display; }

	public function get_permissions($json = true) {
		if ($json) {
			return $this->permissions;
		} else {
			return json_decode($this->permissions, true);
		}
	}

	// Setters

	public function set_role($val) { $this->role = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_permissions($val) { $this->permissions = $val; }
	public function set_display($val) { $this->display = $val; }


	// Static Methods

	public static function enum($role) {
		return self::$role_enum[$role];
	}

	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->role_id);

			$this->set_role($row->role);
			$this->set_description($row->description);
			$this->set_display($row->display);

			//$this->permissions = json_decode($row->permissions, true);
			$this->set_permissions($row->permissions);

			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
