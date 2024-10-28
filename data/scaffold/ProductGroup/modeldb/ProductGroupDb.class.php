<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductGroupDb
 * GENERATION DATE:  2020-01-29
 * -------------------------------------------------------
 *
 */


class ProductGroupDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'product_group';
	protected $primary = 'product_group_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'product_id' => false, 'group_id' => false
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
				'from' => "`{$this->prefix}{$this->table}`",
				'where' => array(),
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*",
				'from' => "`{$this->prefix}{$this->table}`",
				'where' => array(),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}

}
?>
