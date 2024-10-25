<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        StateDb
 * GENERATION DATE:  2018-01-20
 * -------------------------------------------------------
 *
 */


class StateDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'state';
	protected $primary = 'state_id';

	protected $fields = array(
			'state' => false, 'region_id' => false, 'created' => false, 'active' => false
		);


	// Overrided Protected methods

	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*",
				'from' => "`{$this->prefix}{$this->table}`",
				'where' => array("`{$this->primary}` = ?"),
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	public function retrieve_by($fields, $values, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*",
				'from' => "`{$this->prefix}{$this->table}`",
			);
		return parent::retrieve_by($fields, $values, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select_count' => "COUNT(*) AS `record_count`",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}region` `RG` USING(`region_id`)
							",
				'where' => array(),
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`RG`.`region`
							",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}region` `RG` USING(`region_id`)
							",
				'where' => array(),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}
}
?>
