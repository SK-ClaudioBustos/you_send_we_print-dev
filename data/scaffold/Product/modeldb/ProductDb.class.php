<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductDb
 * GENERATION DATE:  2019-10-25
 * -------------------------------------------------------
 *
 */


class ProductDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'product';
	protected $primary = 'product_id';

	protected $fields = array(
			'product_code' => false, 'product_key' => false, 'parent_id' => false, 'parent_key' => false, 
			'path' => false, 'title' => false, 'form' => false, 'short_description' => false, 
			'description' => false, 'details' => false, 'specs' => false, 'meta_title' => false, 
			'meta_description' => false, 'meta_keywords' => false, 'product_order' => false, 'measure_type' => false, 
			'standard_type' => false, 'base_price' => false, 'width' => false, 'height' => false, 
			'weight' => false, 'volume' => false, 'discounts' => false, 'turnarounds' => false, 
			'attachment' => false, 'minimum' => false, 'price_from' => false, 'use_stock' => false, 
			'stock_min' => false, 'disclaimer_id' => false, 'provider_id' => false, 'provider_code' => false, 
			'provider_name' => false, 'provider_url' => false, 'featured' => false, 'created' => false, 
			'active' => false
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
