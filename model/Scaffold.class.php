<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Scaffold
 * GENERATION DATE:  11.11.2013
 * -------------------------------------------------------
 *
 */

class Scaffold extends Base {

	// Protected Vars

	protected $dbClass = 'ScaffoldDb';

	protected $table_prefix = 'tbl_';
	protected $table_name = '';
	protected $controller = '';
	protected $class_name = '';
	protected $plural = '';

	protected $primary = '';
	protected $to_string = '';
	protected $grid_activation = 0;

	protected $fields_grid = array();
	protected $fields_form = array();
	protected $override = array();

	// fields

	protected $field_name = '';
	protected $field_type = '';

	// recordsets
	protected $rs_tables = '';
	protected $row_table = '';

	protected $rs_fields = '';
	protected $row_field = '';


	// Getters

	public function get_string() { return $this->class_name; }

	public function get_table_prefix() { return $this->table_prefix; }
	public function get_table_name() { return $this->table_name; }
	public function get_controller() { return $this->controller; }
	public function get_class_name() { return $this->class_name; }
	public function get_plural() { return $this->plural; }

	public function get_primary($table = false) {
		if (!$table) {
			return $this->primary;
		} else {
			return $this->db->get_primary($table);
		}
	}
	public function get_to_string() { return $this->to_string; }
	public function get_grid_activation() { return $this->grid_activation; }

	public function get_fields_grid() { return $this->fields_grid; }
	public function get_fields_form() { return $this->fields_form; }
	public function get_override() { return $this->override; }

	public function get_field_name() { return $this->field_name; }
	public function get_field_type() { return $this->field_type; }


	// Setters

	public function set_table_prefix($val) { $this->table_prefix = $val; }
	public function set_table_name($val) { $this->table_name = $val; }
	public function set_controller($val) { $this->controller = $val; }
	public function set_class_name($val) { $this->class_name = $val; }
	public function set_plural($val) { $this->plural = $val; }

	public function set_primary($val) { $this->primary = $val; }
	public function set_to_string($val) { $this->to_string = $val; }
	public function set_grid_activation($val) { $this->grid_activation = $val; }

	public function set_fields_grid($val) { $this->fields_grid = $val; }
	public function set_fields_form($val) { $this->fields_form = $val; }
	public function set_override($val) { $this->override = $val; }

	public function set_field_name($val) { $this->field_name = $val; }
	public function set_field_type($val) { $this->field_type = $val; }


	// Public Methods

	public function list_tables($active_only = true, $hide_deleted = true) {
		if ($this->row_table == null) {
			$this->rs_tables = $this->db->list_tables($this, $active_only, $hide_deleted);
		}
		return $this->load_table();
	}

	public function list_fields($table = false) {
		if (!$table) {
			$table = $this->table_name;
		}
		if ($this->row_field == null) {
			$this->rs_fields = $this->db->list_fields($table);
		}
		return $this->load_field();
	}

	public function get_table_arr() {
		// return an array
		return $this->db->get_table_arr();
	}

	public function get_field_arr($table = false) {
		if (!$table) {
			$table = $this->table_name;
		}
		// return an array
		return $this->db->get_field_arr($table);
	}

	public function get_field_info($table = false) {
		if (!$table) {
			$table = $this->table_name;
		}
		// return an array
		return $this->db->get_field_info($table);
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->scaffold_id);

			$this->set_table_prefix($row->table_prefix);
			$this->set_table_name($row->table_name);
			$this->set_controller($row->controller);
			$this->set_class_name($row->class_name);
			$this->set_plural($row->plural);

			$this->set_primary($row->primary);
			$this->set_to_string($row->to_string);
			$this->set_grid_activation($row->grid_activation);

			$this->set_fields_grid(json_decode($row->fields_grid, true));
			$this->set_fields_form(json_decode($row->fields_form, true));
			$this->set_override(json_decode($row->override, true));

			$this->set_created($row->created);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

	protected function load_table() {
		if ($row = $this->rs_tables->fetchObject()) {
			$this->set_table_name($row->TABLE_NAME);
		}
		return $this->row_table = $row;
	}

	protected function load_field() {
		if ($row = $this->rs_fields->fetchObject()) {
			$this->set_field_name($row->Field);
			$this->set_field_type($row->Type);
		}
		return $this->row_field = $row;
	}

}
?>
