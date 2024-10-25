<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        UserDb
 * GENERATION DATE:  14.07.2013
 * -------------------------------------------------------
 *
 */


class UserDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'user';
	protected $primary = 'user_id';

	protected $fields = array(
			'username' => false,
			'password' => false,
			'role_id' => false,
			'first_name' => false,
			'last_name' => false,
			'email' => false,
			'country_key' => false,
			'city_id' => false,
			'time_offset' => false,
			'dst' => false,
			'signup_ip' => false,
			'signup_time' => false,
			'last_ip' => false,
			'last_time' => false,
			'login_attempts' => false,
			'attempt_ip' => false,
			'attempt_time' => false,
			'activation_key' => false,
			'activation_limit' => false,
			'newsletter' => false,
			'confirmed' => false,
			'created' => false,
			'active' => false,
		);


	public function insert($object, $password = false) {
		$fields = array(
				'username' => false, 'password' => $password, 'role_id' => false, 'first_name' => false,
				'last_name' => false, 'email' => false, 'country_key' => false, 'city_id' => false,
				'time_offset' => false, 'dst' => false, 'signup_ip' => false, 'signup_time' => false,
				'newsletter' => false, 'confirmed' => false, 'created' => false, 'active' => false,
			);

		return parent::insert($object, $fields);
	}

	public function update($object, $password = false, $sql_parts = []) {
		$fields = array(
				'username' => false, 'role_id' => false, 'first_name' => false, 'last_name' => false,
				'email' => false, 'country_key' => false, 'city_id' => false, 'last_ip' => false,
				'last_time' => false, 'login_attempts' => false, 'attempt_ip' => false, 'attempt_time' => false,
				'activation_key' => false, 'activation_limit' => false, 'newsletter' => false, 'confirmed' => false, 'created' => false,
				'active' => false,
			);

		if ($password) {
			$fields['password'] = $password;
		}
		return parent::update($object, $fields);
	}



	// Custom

	public function reset_login_attempts($id) {
		$query = "UPDATE `{$this->prefix}{$this->table}`
					SET
						`login_attempts` = 0,
						`attempt_ip` = '',
						`attempt_time` = '',
						`last_ip` = '" . $_SERVER['REMOTE_ADDR'] . "',
						`last_time` = '" . date('Y-m-d H:i:s') . "'
					WHERE `{$this->primary}` = ?";
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($id));
	}

	public function add_login_attempt($username) {
		// if user exist, record failed login attemp
		$query = "UPDATE `{$this->prefix}{$this->table}`
					SET
						`login_attempts` = `login_attempts` + 1,
						`attempt_ip` = '" . $_SERVER['REMOTE_ADDR'] . "',
						`attempt_time` = '" . date('Y-m-d H:i:s') . "'
					WHERE `username` = ?";
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($username));

		// return the new value
		$query = "SELECT `login_attempts`
					FROM `{$this->prefix}{$this->table}`
					WHERE `username` = ?";
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($username));
		$row = $stmt->fetch();
		return $row['login_attempts'];
	}

	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`RL`.`role`,
								`RL`.`permissions`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}role` `RL` USING(`role_id`)
							",
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	public function retrieve_by_activation_key($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}role` `RL` USING(`role_id`)
							",
				'where' => array(
								"`activation_key` = ?",
								"`activation_limit` >= ?",
							),
				);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	function verify($object, $username, $email, $id) {
		$exist = array('username' => false, 'email' => false);

		$sql_parts = array(
				'where' => array(
						"`username` = ?",
						"`user_id` != ?"),
				'values' => array($username, $id),
			);
		if (parent::list_count($object, false, true, $sql_parts)) {
			$exist['username'] = true;
		}

		$sql_parts = array(
				'where' => array(
						"`email` = ?",
						"`user_id` != ?"),
				'values' => array($email, $id),
			);
		if (parent::list_count($object, false, true, $sql_parts)) {
			$exist['email'] = true;
		}

		return $exist;
	}

	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'from' 	=> "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}role` `RL` USING(`role_id`)
							",
				'where' => "`display` = 1",
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`RL`.`role`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}role` `RL` USING(`role_id`)
							",
				'where' => "`display` = 1"
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}


}
?>
