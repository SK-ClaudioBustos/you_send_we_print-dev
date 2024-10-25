<?php
abstract class BaseDb {
	protected $cfg;
	protected $utl;
	protected $app;

	protected $db;
	protected $prefix = false;

	protected $database;
	protected $table;
	protected $primary;
	protected $fields;

	protected $has_active = true;
	protected $has_deleted = true;
	protected $has_created = true;

	protected $defaults2 = array();


	public function __construct() {
		$this->cfg = &CustomApp::$config;
		$this->app = $this->cfg->app;
		$this->utl = $this->cfg->util;

		$this->db = CustomApp::$db->get_instance();
		$this->database = CustomApp::$db->get_database();

		$this->prefix = ($this->prefix !== false) ? $this->prefix : CustomApp::$db->get_prefix();

		$this->defaults2 = array(
				'retrieve' => array(
						'select' 		=> "*",
						'from'			=> "`{$this->prefix}{$this->table}`",
						'where'			=> array("`{$this->prefix}{$this->table}`.`{$this->primary}` = ?"),
						'order'			=> array("`{$this->prefix}{$this->table}`.`{$this->primary}` DESC"),
						'limit'			=> "1",
					),
				'retrieve_by' => array(
						'select' 		=> "*",
						'from'			=> "`{$this->prefix}{$this->table}`",
						'where'			=> array(),
						'order'			=> array("`{$this->prefix}{$this->table}`.`{$this->primary}` DESC"),
						'limit'			=> "1",
					),
				'update' => array(
						'from'			=> "`{$this->prefix}{$this->table}`",
						'where'			=> array("`{$this->prefix}{$this->table}`.`{$this->primary}` = ?"),
					),
				'delete' => array(
						'from'			=> "`{$this->prefix}{$this->table}`",
						'where'			=> array("`{$this->prefix}{$this->table}`.`{$this->primary}` = ?"),
					),
				'delete_by' => array(
						'from'			=> "`{$this->prefix}{$this->table}`",
						'where'			=> array(),
					),
				'list_count' => array(
						'select_count'	=> "COUNT(*) AS `record_count`",
						'from'			=> "`{$this->prefix}{$this->table}`",
					),
				'list_paged' => array(
						'select' 		=> "*",
						'from'			=> "`{$this->prefix}{$this->table}`",
						'order'			=> array("`{$this->prefix}{$this->table}`.`{$this->primary}` DESC"),
					),
			);
	}

	public function __sleep() {
		unset($this->db);
	}

	public function __destruct() {
		unset($this->db);
	}


	public function insert($object, $fields = false) {
		$fields = $this->get_fields($object, $fields);

		$field_insert = '`' . implode('`, `', array_keys($fields)) . '`';
		$field_values = substr(str_repeat(', ?', sizeof($fields)), 2);

		$query = "INSERT INTO `{$this->prefix}{$this->table}` ({$field_insert})
					VALUES ({$field_values});";
		$stmt = $this->db->prepare($query);
		$values = array_values($fields);

		$this->debug('insert', $query, $values);

		$stmt->execute($values);
		return $this->db->lastInsertId();
	}

	public function update($object, $fields = false, $sql_parts = array()) {
		// override defaults
		$sql_parts = array_merge($this->defaults2['update'], $sql_parts);
		$where = $this->get_where(false, $sql_parts['where'], false);

		$fields = $this->get_fields($object, $fields);

		$field_value = array();
		foreach($fields as $field => $value) {
			$field_value[] = "`{$field}` = ?";
		}
		$field_str = implode(', ', $field_value);

		$query = "UPDATE {$sql_parts['from']}
					SET {$field_str}
					{$where};";

		$stmt = $this->db->prepare($query);
		$values = array_values($fields);

		if ($sql_parts['values']) {
			$where_values = $sql_parts['values'];
			if (!is_array($where_values)) {
				$where_values = array($where_values);
			}
			$values = array_merge($values, $where_values);
		} else {
			$values[] = $object->get_id();
		}

		$this->debug('update', $query, $values);

		return $stmt->execute($values);
	}

	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = array()) {
		if (isset($sql_parts['query'])) {
			// full query is provided
			$query = $sql_parts['query'];

		} else {
			// override defaults
			$sql_parts = array_merge($this->defaults2['retrieve'], $sql_parts);

			// create query
			$where = $this->get_where(false, $sql_parts['where'], true, $active_only, $hide_deleted);
			$order = $this->get_order(false, $sql_parts['order'], true);

			$query = "SELECT {$sql_parts['select']} FROM {$sql_parts['from']} {$where} {$order} LIMIT {$sql_parts['limit']};";
		}

		if ($values === false) {
			$values = array();
		} else if (!is_array($values)) {
			$values = array($values);
		}

		$this->debug('retrieve', $query, $values);

		$stmt = $this->db->prepare($query);
		$stmt->execute($values);

		return $stmt;
	}

	public function retrieve_by($fields, $values, $active_only = true, $hide_deleted = true, $sql_parts = array()) {
		// override defaults
		$sql_parts = array_merge($this->defaults2['retrieve_by'], $sql_parts);

		// create query
		$order = $this->get_order(false, $sql_parts['order'], true);

		if (!is_array($fields)) {
			$fields = array($fields);
		}
		if (!is_array($values)) {
			$values = array($values);
		}

		$size = sizeof($fields);
		$fields_where = array();
		for ($i = 0; $i < $size; $i++) {
			$fields_where[] = "{$fields[$i]} = ?";
		}
		$where = array_merge($sql_parts['where'], $fields_where);
		$where = $this->get_where(false, $where, true, $active_only, $hide_deleted);

		$query = "SELECT {$sql_parts['select']} FROM {$sql_parts['from']} {$where} {$order} LIMIT {$sql_parts['limit']};";

		$this->debug('retrieve_by', $query, $values);

		$stmt = $this->db->prepare($query);
		$stmt->execute($values);
		return $stmt;
	}

	public function delete_by($fields, $values, $hard_delete = false, $sql_parts = array()) {
		if (!is_array($fields)) {
			$fields = array($fields);
		}
		if (!is_array($values)) {
			$values = array($values);
		}

		// override defaults
		$sql_parts = array_merge($this->defaults2['delete_by'], $sql_parts);

		$size = sizeof($fields);
		$fields_where = array();
		for ($i = 0; $i < $size; $i++) {
			$fields_where[] = "{$fields[$i]} = ?";
		}
		$where = array_merge($sql_parts['where'], $fields_where);
		$where = $this->get_where(false, $where, false);

		if ($this->has_deleted && !$hard_delete) {
			// mark as deleted
			$query = "UPDATE {$sql_parts['from']}
						SET `deleted` = 1
						{$where};";
		} else {
			// delete record
			$query = "DELETE FROM {$sql_parts['from']}
						{$where};";
		}

		$this->debug('delete_by', $query, $values);

		$stmt = $this->db->prepare($query);
		return $stmt->execute($values);
	}

	public function delete($values = false, $hard_delete = false, $sql_parts = array()) {
		if (isset($sql_parts['query'])) {
			// full query is provided
			$query = $sql_parts['query'];

		} else {
			// override defaults
			$sql_parts = array_merge($this->defaults2['delete'], $sql_parts);

			$where = $this->get_where(false, $sql_parts['where'], false);

			if ($this->has_deleted && !$hard_delete) {
				// mark as deleted
				$query = "UPDATE {$sql_parts['from']}
							SET `deleted` = 1, `active` = 0
							{$where};";
			} else {
				// delete record
				$query = "DELETE FROM {$sql_parts['from']}
							{$where};";
			}
		}

		if ($values === false) {
			$values = array();
		} else if (!is_array($values)) {
			$values = array($values);
		}

		$this->debug('delete', $query, $values);

		$stmt = $this->db->prepare($query);
		return $stmt->execute($values);
	}


	// Lists

	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = array()) {
		if (isset($sql_parts['query'])) {
			// full query is provided
			$query = $sql_parts['query'];

		} else {
			// override defaults
			$sql_parts = array_merge($this->defaults2['list_count'], $sql_parts);

			// create query
			$where = $this->get_where($object, $sql_parts['where'], true, $active_only, $hide_deleted);

			$query = "SELECT {$sql_parts['select_count']} FROM {$sql_parts['from']} {$where};";
		}

		$values = $this->get_values($object, $sql_parts['values']);
		$return = (isset($sql_parts['return'])) ? $sql_parts['return'] : 'record_count';

		$this->debug('list_count', $query, $values);

		$stmt = $this->db->prepare($query);
		$stmt->execute($values);
		$row = $stmt->fetch();

		if (is_array($return)) {
			// return an array
			$rows = array();
			foreach($return as $field) {
				$rows[$field] = $row[$field];
			}
			return $rows;

		} else {
			// return a single value
			return $row[$return];
		}
	}

	public function list_count_array($object, $active_only = true, $hide_deleted = true, $sql_parts = array()) {
		if (isset($sql_parts['query'])) {
			// full query is provided
			$query = $sql_parts['query'];

		} else {
			// override defaults
			$sql_parts = array_merge($this->defaults2['list_paged'], $sql_parts);

			// create query
			$where = $this->get_where($object, $sql_parts['where'], true, $active_only, $hide_deleted);
			$order = $this->get_order($object, $sql_parts['order']);
			$group = $this->get_group($object, $sql_parts['group']);
			$limit = $this->get_limit($object);

			$query = "SELECT {$sql_parts['select']} FROM {$sql_parts['from']} {$where} {$group} {$order} {$limit};";
		}

		$values = $this->get_values($object, $sql_parts['values']);

		$this->debug('list_count_array', $query, $values);

		$stmt = $this->db->prepare($query);
		$stmt->execute($values);
		return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
	}


	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = array()) {
//print_r($sql_parts);
//esit;
		if (isset($sql_parts['query'])) {
			// full query is provided
			$query = $sql_parts['query'];

		} else {
			// override defaults
			$sql_parts = array_merge($this->defaults2['list_paged'], $sql_parts);

			// create query
			$where = $this->get_where($object, $sql_parts['where'], true, $active_only, $hide_deleted);
			$order = $this->get_order($object, $sql_parts['order']);
			$group = $this->get_group($object, $sql_parts['group']);
			$limit = $this->get_limit($object);

			$query = "SELECT {$sql_parts['select']} FROM {$sql_parts['from']} {$where} {$group} {$order} {$limit};";
		}

		$values = $this->get_values($object, $sql_parts['values']);

		$this->debug('list_paged', $query, $values);

		$this->db->query("SET group_concat_max_len = 24000"); // default 1024
		//error_log($query);
		$stmt = $this->db->prepare($query);
		$stmt->execute($values);
		return $stmt;
	}

	public function list_paged_array($object, $active_only = true, $hide_deleted = true, $sql_parts = array()) {
		if (isset($sql_parts['query'])) {
			// full query is provided
			$query = $sql_parts['query'];

		} else {
			// override defaults
			$sql_parts = array_merge($this->defaults2['list_paged'], $sql_parts);

			// create query
			$where = $this->get_where($object, $sql_parts['where'], true, $active_only, $hide_deleted);
			$order = $this->get_order($object, $sql_parts['order']);
			$group = $this->get_group($object, $sql_parts['group']);
			$limit = $this->get_limit($object);

			$query = "SELECT {$sql_parts['select']} FROM {$sql_parts['from']} {$where} {$group} {$order} {$limit};";
		}

		$values = $this->get_values($object, $sql_parts['values']);

		$this->debug('list_paged_array', $query, $values);

		$this->db->query("SET group_concat_max_len = 24000"); // default 1024

		$stmt = $this->db->prepare($query);
		$stmt->execute($values);

		// TODO: $sql_parts['options']?
		return $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC); //PDO::FETCH_KEY_PAIR);
	}

	public function check_existing_key($key_field = 'key', $key) {
		$query = "SELECT `{$key_field}`
					FROM `{$this->prefix}{$this->table}`
					WHERE (`{$key_field}` = '{$key}' OR `{$key_field}` LIKE '{$key}.%')
						AND `deleted` = 0
					ORDER BY `{$key_field}` DESC LIMIT 1;";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchColumn();
	}


	// protected --------------------------------------------------------------

	protected function debug($method, $query, $values, $fields = false) {
		if (is_array($this->app->debug_sql) && ($this->app->debug_sql[$method] || $this->app->debug_sql['all'])) {
			error_log('DB ' . $method . ': ' . $query . ((sizeof($values)) ? ' | ' . json_encode($values) : ''));
		}
	}

	protected function extend($array1, $array2) {
		// merge array recursively (for extending $sql_parts)

		if (is_array($array2)) {
			foreach($array2 as $key => $value) {
				if (is_numeric($key)) {
					$array1[] = $value;

				} else if (array_key_exists($key, $array1) && is_array($value)) {
					//$array1[$key] = $this->extend($array1[$key], $array2[$key]);
					$array1[$key] = array_merge($array1[$key], $array2[$key]);

				} else {
					$array1[$key] = $value;
				}
			}
		}

		return $array1;
	}

	protected function fetchObject($query, $args = array()) {
		$stmt = $this->db->prepare($query);
		$stmt->execute($args);
		return $stmt->fetchObject();
	}

	// Aux

	protected function get_group($object, $group) {
		$group_str = '';
		if ($group) {
			if (is_array($group) && sizeof($group)) {
				$group_str = "GROUP BY " . implode(', ', $group);
			} else {
				$group_str = "GROUP BY {$group}";
			}
		}

		return $group_str;
	}

	protected function get_values($object, $values) {
		$values = (isset($values)) ? $values : array();

		$obj_values = $object->get_values();
		if (!$obj_values) {
			$obj_values = array();
		} else if (!is_array($obj_values)) {
			$obj_values = array($obj_values);
		}

		return array_merge($values, $obj_values);
	}

	protected function get_order($object, $order, $ignore_object = false) {
		// Priority: $object->order / $order / $defaults

		if (!$ignore_object) {
			if ($object->get_order()) {
				$order = $object->get_order();
			} else if ($order !== false) {
				// nothing
			}
		}

		if ($order) {
			if (!is_array($order)) {
				$order = array($order);
			}

			$order = "ORDER BY " . implode(', ', $order);
		}
		return $order;
	}

	protected function get_limit($object) {
		$limit = '';
		if ($object->get_limit()) {
			$limit = "LIMIT " . $object->get_limit() * ($object->get_page() - 1) . ", " . $object->get_limit();
		}
		return $limit;
	}

	protected function get_where($object, $where = false, $use_flags = false, $active_only = true, $hide_deleted = true) {
		if (!$where) {
			$where = array();
		} else if (!is_array($where)) {
			$where = array($where);
		}
		// $object->filter doesn't replace $where, it's added. Only for lists
		if ($object && $filter = $object->get_filter()) {
			if (!is_array($filter)) {
				$filter = array($filter);
			}
			$where = array_merge($where, $filter);
		}

		if ($use_flags) {
			if ($this->has_active && $active_only) {
				$where[] = "`{$this->prefix}{$this->table}`.`active` = 1";
			}
			if ($this->has_deleted && $hide_deleted) {
				$where[] = "`{$this->prefix}{$this->table}`.`deleted` = 0";
			}
		}

		$where_str = '';
		if (sizeof($where)) {
			$where_str = "WHERE " . implode(' AND ', $where);
		}

		return $where_str;
	}

	protected function get_fields($object, $fields) {
		if ($fields === false) {
			$fields = $this->fields;
		}

		$values = array();
		foreach($fields as $field => &$value) {
			if ($value === false) {
				$value = stripslashes($object->{'get_' . $field}());
			}
		}
		return $fields;
	}

}
?>