<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ScaffoldDb
 * GENERATION DATE:  11.11.2013
 * -------------------------------------------------------
 *
 */


class ScaffoldDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'scaffold';
	protected $primary = 'scaffold_id';

	protected $fields = array(
			'table_prefix' => false, 'table_name' => false, 'controller' => false, 'class_name' => false,
			'plural' => false, 'primary' => false, 'to_string' => false, 'grid_activation' => false,
			'fields_grid' => false, 'fields_form' => false, 'override' => false, 'active' => false
		);


	public function list_tables($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$query = "SELECT TABLE_NAME
					FROM information_schema.TABLES
					WHERE TABLE_TYPE = 'BASE TABLE'
						AND TABLE_SCHEMA = '{$this->database}'
						AND TABLE_NAME NOT IN ('{$this->prefix}user', '{$this->prefix}role', '{$this->prefix}session', '{$this->prefix}scaffold')
					ORDER BY TABLE_NAME;";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function list_fields($table) {
		$query = "SHOW COLUMNS FROM {$table}";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function get_primary($table) {
		$query = "SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();
		return $row['Column_name'];
	}

	public function get_table_arr() {
		$query = "SELECT TABLE_NAME
					FROM information_schema.TABLES
					WHERE TABLE_TYPE = 'BASE TABLE'
						AND TABLE_SCHEMA = '{$this->database}'
					ORDER BY TABLE_NAME;";
		$rs = $this->db->query($query);
		$tables = array();
		while ($row = $rs->fetchObject()) {
			$tables[] = $row->TABLE_NAME;
		}
		return $tables;
	}

	public function get_field_arr($table) {
		$query = "SELECT * FROM {$table} LIMIT 0";
		$rs = $this->db->query($query);
		$columns = array();
		for ($i = 0; $i < $rs->columnCount(); $i++) {
		    $col = $rs->getColumnMeta($i);
		    $columns[] = $col['name'];
		}
		return $columns;
	}



	// test --------------------------------------------------------------------------

	public function get_field_info($table) {
		$fields = array();
		$field_meta = array();
		$primary_key = false;

		$query = "SHOW COLUMNS FROM `{$table}`";
		$columns = $this->db->query($query, PDO::FETCH_ASSOC);
		foreach($columns as $key => $col) {
			// insert into fields array
			$colname = $col['Field'];
			$fields[$colname] = $col;

			if ($col['Key'] == "PRI" && !$primary_key) {
				$primary_key = $colname;
			}

			// set field types
			$col_type = $this->parse_column_type($col['Type']);
			$field_meta[$colname] = $col_type;

			$field_meta[$colname]['index'] = $col['Key'];
		}
//echo $primary_key;
//print_r($fields);
//print_r($field_meta);
//exit;
		return true;
	}


	protected function parse_column_type($col_type) {
		$col_info = array();
		$col_parts = explode(" ", $col_type);

		if($fparen = strpos($col_parts[0], "(")) {
			$col_info['type'] = substr($col_parts[0], 0, $fparen);
			$col_info['pdo_type'] = '';
			$col_info['length']  = str_replace(")", "", substr($col_parts[0], $fparen+1));
			$col_info['attributes'] = isset($col_parts[1]) ? $col_parts[1] : NULL;
		} else {
			$col_info['type'] = $col_parts[0];
		}

		$pdo_bind_types = array(
				'char' => PDO::PARAM_STR,
				'int' => PDO::PARAM_INT,
				'bool' => PDO::PARAM_BOOL,
				'date' => PDO::PARAM_STR,
				'time' => PDO::PARAM_INT,
				'text' => PDO::PARAM_STR,
				'blob' => PDO::PARAM_LOB,
				'binary' => PDO::PARAM_LOB
			);

		// PDO Bind types
		foreach($pdo_bind_types as $key => $type) {
			if(strpos(' ' . strtolower($col_info['type']) . ' ', $key)) {
				$col_info['pdo_type'] = $type;
				break;
			} else {
				$col_info['pdo_type'] = PDO::PARAM_STR;
			}
		}

		return $col_info;
	}

}
?>
