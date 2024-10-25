<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Property
 * GENERATION DATE:  22.01.2016
 * -------------------------------------------------------
 *
 */

class Property extends Base {

	// Protected Vars

	protected $dbClass = 'PropertyDb';

	protected $property_key = '';
	protected $property = '';
	protected $type = 'str';
	protected $value = '';
	protected $value_str = '';
	protected $hidden = '';


	// Getters

	public function get_string() { return $this->property; }

	public function get_property_key() { return $this->property_key; }
	public function get_property() { return $this->property; }
	public function get_type() { return $this->type; }
	public function get_value() { return $this->value; }
	public function get_value_str() { return $this->value_str; }
	public function get_hidden() { return $this->hidden; }

	// Setters

	public function set_property_key($val) { $this->property_key = $val; }
	public function set_property($val) { $this->property = $val; }
	public function set_type($val) { $this->type = $val; }
	public function set_value($val) { $this->value = $val; }
	public function set_value_str($val) { $this->value_str = $val; }
	public function set_hidden($val) { $this->hidden = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->property_id);

			$this->set_property_key($row->property_key);
			$this->set_property($row->property);
			$this->set_type($row->type);
			$this->set_value($row->value);
			$this->set_value_str($row->value_str);
			$this->set_hidden($row->hidden);

			$this->set_created($row->created);
		}
		return $this->row = $row;
	}

}
?>
