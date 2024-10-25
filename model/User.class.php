<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        User
 * GENERATION DATE:  14.07.2013
 * -------------------------------------------------------
 *
 */

class User extends Base {

	// Protected Vars

	protected $dbClass = 'UserDb';

	protected $username = '';
	protected $username_clean = '';
	protected $password = '';
	protected $role_id = '';

	protected $first_name = '';
	protected $last_name = '';
	protected $email = '';

	protected $city_id = '';
	protected $country_key = '';

	protected $time_offset = 0;
	protected $dst = 0;

	protected $signup_ip = '';
	protected $signup_time = '';

	protected $last_ip = '';
	protected $last_time = '';

	protected $login_attempts = '';
	protected $attempt_ip = '';
	protected $attempt_time = '';

	protected $activation_key = '';
	protected $activation_limit = '';

	protected $newsletter = 0;

	protected $confirmed = 0;

	protected $name = '';
	protected $role = '';

	protected $permissions = array();

	// for carrying
	protected $email_repeat = '';
	protected $agreed = 0;


	// Getters

	public function get_string() { return $this->username; }

	public function get_username() { return $this->username; }
	public function get_username_clean() { return $this->username_clean; }
	public function get_role_id() { return $this->role_id; }

	public function get_first_name() { return $this->first_name; }
	public function get_last_name() { return $this->last_name; }
	public function get_email() { return $this->email; }

	public function get_country_key() { return $this->country_key; }
	public function get_city_id() { return $this->city_id; }

	public function get_time_offset() { return $this->time_offset; }
	public function get_dst() { return $this->dst; }

	public function get_signup_ip() { return $this->signup_ip; }
	public function get_signup_time() { return $this->signup_time; }

	public function get_last_ip() { return $this->last_ip; }
	public function get_last_time() { return $this->last_time; }

	public function get_login_attempts() { return $this->login_attempts; }
	public function get_attempt_time() { return $this->attempt_time; }
	public function get_attempt_ip() { return $this->attempt_ip; }

	public function get_activation_key() { return $this->activation_key; }
	public function get_activation_limit() { return $this->activation_limit; }

	public function get_newsletter() { return $this->newsletter; }

	public function get_confirmed() { return $this->confirmed; }

	public function get_name() { return $this->name; }
	public function get_role() { return $this->role; }

	public function get_email_repeat() { return $this->email_repeat; }
	public function get_agreed() { return $this->agreed; }


	// Setters

	public function set_username($val) { $this->username = $val; }
	public function set_username_clean($val) { $this->username_clean = $val; }
	public function set_password($val) {
		if ($val) {
			$hasher = new PasswordHash(8, true);
			$this->password = $hasher->HashPassword($val);
		}
	}
	public function set_role_id($val) { $this->role_id = $val; }

	public function set_first_name($val) { $this->first_name = $val; }
	public function set_last_name($val) { $this->last_name = $val; }
	public function set_email($val) { $this->email = $val; }

	public function set_city_id($val) { $this->city_id = $val; }
	public function set_country_key($val) { $this->country_key = $val; }

	public function set_time_offset($val) { $this->time_offset = $val; }
	public function set_dst($val) { $this->dst = $val; }

	public function set_signup_ip($val) { $this->signup_ip = $val; }
	public function set_signup_time($val) { $this->signup_time = $val; }

	public function set_last_ip($val) { $this->last_ip = $val; }
	public function set_last_time($val) { $this->last_time = $val; }

	public function set_login_attempts($val) { $this->login_attempts = $val; }
	public function set_attempt_time($val) { $this->attempt_time = $val; }
	public function set_attempt_ip($val) { $this->attempt_ip = $val; }

	public function set_activation_key($val) { $this->activation_key = $val; }
	public function set_activation_limit($val) { $this->activation_limit = $val; }

	public function set_newsletter($val) { $this->newsletter = $val; }

	public function set_confirmed($val) { $this->confirmed = $val; }

	public function set_name($val) { $this->name = $val; }
	public function set_role($val) { $this->role = $val; }

	public function set_email_repeat($val) { $this->email_repeat = $val; }
	public function set_agreed($val) { $this->agreed = $val; }


	// Public Methods

	public function insert() {
		return $this->id = $this->db->insert($this, $this->password);
	}

	public function update($convert_arrays = true, $format_json = false) {
		if ($this->get_id()) {
			return $this->db->update($this, $this->password);
		} else {
			return $this->id = $this->db->insert($this, $this->password);
		}
	}

	public function retrieve_by_activation_key($values) {
	    $this->rs = $this->db->retrieve_by_activation_key($values);
	    $this->load();
	    return (int)$this->get_id();
	}


	public function perm($perm) {
		return ($this->role_id == 1 || in_array($perm, $this->permissions)); // superadmin
	}

	// TODO: admin can't delete himself
//	public function delete($values = false, $hard_delete = false) {
//		if ($id = (int)$id) {
//			$this->set_id($id);
//		}
//		return $this->db->delete($this->get_id());
//	}

	public function login($username, $password, $ip) {
		$this->rs = $this->db->retrieve_by('username', $username);
		$this->load();

		// validate password
		$hasher = new PasswordHash(8, true);
		$valid = ($hasher->CheckPassword($password, $this->password));

		return ($valid) ? $this->get_id() : false;
	}

	public function verify($username, $email, $id = 0) {
		return $this->db->verify($this, $username, $email, $id);
	}

	public function add_login_attempt($username) {
		return $this->db->add_login_attempt($username);
	}

	public function reset_login_attempts() {
		return $this->db->reset_login_attempts($this->get_id());
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->user_id);

			$this->password = $row->password; // don't use property

			$this->set_username($row->username);
			$this->set_username_clean($row->username_clean);
			$this->set_role_id($row->role_id);

			$this->set_first_name($row->first_name);
			$this->set_last_name($row->last_name);
			$this->set_email($row->email);

			$this->set_city_id($row->city_id);
			$this->set_country_key($row->country_key);

			$this->set_time_offset($row->time_offset);
			$this->set_dst($row->dst);

			$this->set_signup_ip($row->signup_ip);
			$this->set_signup_time($row->signup_time);

			$this->set_last_ip($row->last_ip);
			$this->set_last_time($row->last_time);

			$this->set_login_attempts($row->login_attempts);
			$this->set_attempt_time($row->attempt_time);
			$this->set_attempt_ip($row->attempt_ip);

			$this->set_activation_key($row->activation_key);
			$this->set_activation_limit($row->activation_limit);

			$this->set_confirmed($row->confirmed);

			$this->set_created($row->created);
			$this->set_active($row->active);

			$this->set_role($row->role);

			$this->permissions = json_decode($row->permissions, true);
		}
		return $this->row = $row;
	}

}
?>
