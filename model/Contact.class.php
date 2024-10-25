<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Contact
 * GENERATION DATE:  10.01.2010
 * -------------------------------------------------------
 *
 */

class Contact extends Base {

	// Private Vars

	protected $section_key = '';
	protected $category_key = '';
	protected $first_name = '';
	protected $last_name = '';
	protected $address = '';
	protected $phone = '';
	protected $email = '';
	protected $country_id = '';
	protected $city = '';
	protected $message = '';
	protected $ip = '';
	protected $lang_iso = '';
	protected $approved = '';

	protected $dbClass = 'ContactDb';
  	protected $sort_field = 'contact_id';
	protected $last_id = '';


	// Getters

	public function get_string() { return $this->first_name; }

	public function get_full_name() { return $this->first_name . ' ' . $this->last_name; }
	public function get_full_name_rev() {
		if ($this->last_name && $this->first_name) {
			return $this->last_name . ', ' . $this->first_name;
		} else {
			return $this->last_name . $this->first_name;
		}
	}

	public function get_section_key() { return $this->section_key; }
	public function get_category_key() { return $this->category_key; }
	public function get_first_name() { return $this->first_name; }
	public function get_last_name() { return $this->last_name; }
	public function get_address() { return $this->address; }
	public function get_phone() { return $this->phone; }
	public function get_email() { return $this->email; }
	public function get_country_id() { return $this->country_id; }
	public function get_city() { return $this->city; }
	public function get_message() { return $this->message; }
	public function get_ip() { return $this->ip; }
	public function get_approved() { return $this->approved; }

	public function get_last_id() { return $this->last_id; }


	// Setters

	public function set_section_key($val) { $this->section_key = $val; }
	public function set_category_key($val) { $this->category_key = $val; }
	public function set_first_name($val) { $this->first_name = $val; }
	public function set_last_name($val) { $this->last_name = $val; }
	public function set_address($val) { $this->address = $val; }
	public function set_phone($val) { $this->phone = $val; }
	public function set_email($val) { $this->email = $val; }
	public function set_country_id($val) { $this->country_id = $val; }
	public function set_city($val) { $this->city = $val; }
	public function set_message($val) { $this->message = $val; }
	public function set_ip($val) { $this->ip = $val; }
	public function set_approved($val) { $this->approved = $val; }

	public function set_last_id($val) { $this->last_id = $val; }


	// Functions

	public function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->contact_id);

			$this->set_section_key($row->section_key);
			$this->set_category_key($row->category_key);
			$this->set_first_name($row->first_name);
			$this->set_last_name($row->last_name);
			$this->set_address($row->address);
			$this->set_phone($row->phone);
			$this->set_email($row->email);
			$this->set_country_id($row->country_id);
			$this->set_city($row->city);
			$this->set_message($row->message);
			$this->set_ip($row->ip);
			$this->set_approved($row->approved);
			$this->set_created($row->created);
			$this->set_active($row->active);
			$this->set_deleted($row->deleted);
		}
		return $this->row = $row;
	}

	// Custom

	public function remove_by_mail($email, $section_key) {
		$this->db->remove_by_mail($email, $section_key);
	}

	public function list_more_count() {
		$this->record_count = $this->rs = $this->db->list_more_count($this);
		return $this->record_count;
	}

	public function list_more() {
		if ($this->row == null) $this->rs = $this->db->list_more($this);
		return $this->load();
	}

}
?>
