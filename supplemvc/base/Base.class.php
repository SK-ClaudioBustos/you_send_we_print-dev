<?php
abstract class Base {

	// Protected Vars

	protected $id = 0;

	protected $page = 1;
	protected $limit = 50;
	protected $order = false;
	protected $filter = false;
	protected $values = false;

	protected $record_count = null;
	protected $page_count = null;

	protected $cfg;
	protected $utl;

	protected $db = null;
	protected $rs = null;
	protected $row = null;

	protected $missing_fields = array();

	protected $dbClass = '';

	protected $created = '';
	protected $owner_user_id = '';
	protected $date_updated = '';
	protected $last_user_id = '';
	protected $active = 0;
	protected $deleted = 0;


	protected $json_exclude = array(
			'json_exclude',
			'page', 'limit', 'order', 'filter', 'values',
			'page_count', 'record_count',
			'cfg', 'utl',
			'db', 'rs', 'row',
			'dbClass',
			'owner_user_id', 'date_updated', 'last_user_id'
		);


	// Constructors

	public function __construct() {
		$this->setup();

		$args = func_get_args();
		switch (sizeof($args)) {
			case 1:
				if ($id = (int)$args[0]) {
					$this->retrieve($id);
					break;
				}

			case 0:
				$this->created = date('Y-m-d H:i:s');
				break;
		}
	}

	public function __sleep() {
		unset($this->cfg, $this->utl, $this->db, $this->rs, $this->row);
		return array_diff(array_keys(get_object_vars($this)), $this->json_exclude);
	}

	public function __wakeup() {
		$this->setup();
	}

	public function __destruct() {
		unset($this->cfg, $this->utl, $this->db, $this->rs, $this->row);
	}

	private function setup() {
		$this->cfg = &CustomApp::$config;
		$this->utl = $this->cfg->util;

		if ($this->dbClass) {
			$this->db = new $this->dbClass();
		}
	}


	// Getters

	public function get_id() { return $this->id; }
	public function get_string() { return (string)$this->id; }

	public function get_page() { return $this->page; }
	public function get_limit() { return $this->limit; }
	public function get_order() { return $this->order; }
	public function get_filter() { return $this->filter; }
	public function get_values() { return $this->values; }

	public function get_page_count() { return $this->page_count; }
	public function get_record_count() { return $this->record_count; }

	public function get_missing_fields() { return $this->missing_fields; }

	public function get_created() { return $this->created; }
	public function get_owner_user_id() { return $this->owner_user_id; }
	public function get_date_updated() { return $this->date_updated; }
	public function get_last_user_id() { return $this->last_user_id; }
	public function get_active() { return $this->active; }
	public function get_deleted() { return $this->deleted; }


	// Setters

	public function set_id($id) { $this->id = $id; }

	public function set_page($value) { $this->page = $value; }
	public function set_limit($value) { $this->limit = $value; }
	public function set_order($value) { $this->order = $value; }
	public function set_filter($value) { $this->filter = $value; }
	public function set_values($value) { $this->values = $value; }

	public function set_record_count($value) { $this->record_count = $value; }
	public function set_page_count($value) { $this->page_count = $value; }

	public function set_missing_fields($value) { $this->missing_fields = $value; }

	public function set_created($value) { $this->created = $value; }
	public function set_active($value) { $this->active = $value; }
	public function set_deleted($value) { $this->deleted = $value; }


	// Methods

	public function to_json($json_exclude = false, $add_to = false) {
	    return json_encode($this->to_array($json_exclude, $add_to));
	}

	public function to_array($array_exclude = false, $add_to = false) {
		if (!$array_exclude) {
			$array_exclude = $this->json_exclude;
		} else if ($add_to) {
			$array_exclude = array_merge($this->json_exclude, $array_exclude);
		}

		$obj_arr = array('id' => $this->id);
	    foreach ($this as $key => $value) {
	    	if (!in_array($key, $array_exclude)) {
	    		$obj_arr[$key] = $value;
	    	}
	    }
	    return $obj_arr;
	}

	public function insert() {
		return $this->id = $this->db->insert($this);
	}

	function json_encode_53($arr) {
		//convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). 
		// So such characters are being "hidden" from normal json_encoding
		array_walk_recursive($arr, function (&$item, $key) { 
				if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); 
			});
		return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');
	}

	public function update($convert_arrays = true, $format_json = false) {
		if ($convert_arrays) {
			// convert arrays to json
			$converted = array();
		    foreach ($this as $field => $value) {
		    	if (!in_array($field, $this->json_exclude)) {
		    		if (is_array($value)) {
						if (defined(JSON_UNESCAPED_UNICODE)) {
		    				$value = json_encode($value, JSON_UNESCAPED_UNICODE); // PHP 5.4+
						} else {
		    				$value = $this->json_encode_53($value);							
						}
						if ($format_json) {
		    				$value = $this->utl->json_pretty_print($value);
		    			}
			    		$this->$field = $value;
			    		$converted[] = $field;
		    		}
		    	}
		    }
		}

		if ($this->get_id()) {
			$this->db->update($this);
		} else {
			$this->id = $this->db->insert($this);
		}

		if ($convert_arrays) {
			// convert back to arrays
		    foreach ($converted as $field) {
		   		$this->$field = json_decode($this->$field, true);
		    }
		}

		return $this->get_id();
	}

	public function delete($values = false, $hard_delete = false) {
		if ($values === false) {
			$values = $this->get_id();
		}
		return $this->db->delete($values, $hard_delete);
	}

	public function delete_by($fields, $values, $hard_delete = false) {
		return $this->db->delete_by($fields, $values, $hard_delete);
	}

	public function retrieve($values, $active_only = true, $hide_deleted = true) {
		$this->rs = $this->db->retrieve($values, $active_only, $hide_deleted);
		$this->load();
		return $this->get_id();
	}

	public function retrieve_by($fields, $values, $active_only = true, $hide_deleted = true) {
		$this->rs = $this->db->retrieve_by($fields, $values, $active_only, $hide_deleted);
		$this->load();
		return $this->get_id();
	}


	public function set_paging($page = 1, $limit = false, $order = false, $filter = false, $values = false) {
		$this->page = $page;
		$this->limit = $limit;
		$this->order = $order;
		$this->filter = $filter;
		$this->values = $values;
	}


	// Lists

	public function list_count($active_only = true, $hide_deleted = true) {
		$this->record_count = $this->db->list_count($this, $active_only, $hide_deleted);
		return $this->record_count;
	}

	public function list_count_array($active_only = true, $hide_deleted = true, $sql_parts = array(), $values = array()) {
		// TODO: $values is not used in BaseDB!
		return $this->db->list_count_array($this, $active_only, $hide_deleted, $sql_parts, $values);
	}

	public function list_paged($active_only = true, $hide_deleted = true, $sql_parts = array(), $values = array()) {
		if ($this->row == null) {
			$this->rs = $this->db->list_paged($this, $active_only, $hide_deleted, $sql_parts, $values);
		}
		return $this->load();
	}

	public function list_paged_array($active_only = true, $hide_deleted = true, $sql_parts = array(), $values = array()) {
		// TODO: $values is not used in BaseDB!
		return $this->db->list_paged_array($this, $active_only, $hide_deleted, $sql_parts, $values);
	}


	// Protected methods

	public function is_missing($field, $class = 'missing') {
		return (in_array($field, $this->missing_fields)) ? ' ' . $class : '';
	}


	protected function load() {
		return $this->row = $this->rs->fetchObject();
	}


	protected function get_new_key($key_field, $key, $key_from, $update = false) {
		// if no defined slug, create one from text
		if (!$key || $update) {
			$new_key = $this->utl->get_rewrite_string($key_from);

			//if (substr($key, 0, strlen($new_key)) != $new_key) {
			$root_key = explode('.', $key);
			$root_key = $root_key[0]; // remove .0x if exists

			if ($root_key != $new_key) {
				$existing = $this->db->check_existing_key($key_field, $new_key);

				if ($existing){
					$last_number = (int)substr($existing, strripos($existing, ".") + 1);

					if (is_numeric($last_number) && $last_number > 0) {
						$last_number++;
						$new_key .= "." . sprintf("%02d", $last_number);
					} else {
						$new_key .= ".01";
					}
				}
				return $new_key;

			} else {
				return $key;
			}

		} else {
			return $key;
		}
	}

}
?>