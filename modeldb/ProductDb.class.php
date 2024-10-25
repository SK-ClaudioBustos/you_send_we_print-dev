<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Product
 * GENERATION DATE:  30.05.2010
 * -------------------------------------------------------
 *
 */


class ProductDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'product';
	protected $primary = 'product_id';

	protected $fields = array(
			'product_code' => false,
			'product_key' => false,
			'product_type' => false,
			'parent_id' => false,
			//'parent_key' => false, 'path' => false,
			'title' => false,
			'form' => false,
			'short_description' => false,
			'description' => false,
			'details' => false,
			'specs' => false,
			'meta_title' => false,
			'meta_description' => false,
			'meta_keywords' => false,
			'product_order' => false,
			'group_home' => false,
			'measure_type' => false,
			'standard_type' => false,
			'base_price' => false,
			'setup_fee' => false,
			'width' => false,
			'height' => false,
			'weight' => false,
			'volume' => false,
			'discounts' => false,
			'turnarounds' => false,
			'attachment' => false,
			'minimum' => false,
			'price_from' => false,
			'use_stock' => false,
			'stock_min' => false,
			'disclaimer_id' => false,
			'provider_id' => false,
			'provider_code' => false,
			'provider_name' => false,
			'provider_url' => false,
			'price_date' => false,
			'created' => false,
			'featured' => false,
			'active' => false
		);


	//Custom

	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`ST`.`stock`,
								`PV`.`provider`,
								`PV`.`provider_city`,
								`PV`.`provider_state`
							",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}stock` `ST` USING(`product_id`)
								LEFT OUTER JOIN `{$this->prefix}provider` `PV` USING(`provider_id`)
							",
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	public function retrieve_by($fields, $values, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`ST`.`stock`,
								`PV`.`provider`,
								`PV`.`provider_city`,
								`PV`.`provider_state`
							",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}stock` `ST` USING(`product_id`)
								LEFT OUTER JOIN `{$this->prefix}provider` `PV` USING(`provider_id`)
							",
			);
		return parent::retrieve_by($fields, $values, $active_only, $hide_deleted, $sql_parts);
	}

	public function update_order($product_id, $order) {
		$query = "UPDATE `{$this->prefix}{$this->table}`
					SET `product_order` = ?
					WHERE `product_id` = ?;";
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($order, $product_id));
		return $stmt;
	}

	public function list_parents($parent_key = '') {
		$where = array("`parent_key` = ?");
		$where = $this->get_where(false, $where, true, false);

		$query = "SELECT `product_key`, `product_id`, `title`
					FROM `{$this->prefix}{$this->table}`
					{$where}
					ORDER BY `product_order` ASC;";
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($parent_key));
		return $stmt;
   	}

	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select_count' => "COUNT(*) AS `record_count`",
				'from' => "`{$this->prefix}{$this->table}`",
				'where' => array(),
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_count_full($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select_count' => "COUNT(*) AS `record_count`",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}product` `PR` ON `{$this->prefix}{$this->table}`.`parent_id` = `PR`.`product_id`
								LEFT OUTER JOIN `{$this->prefix}product_group` `PG` ON `{$this->prefix}{$this->table}`.`product_id` = `PG`.`product_id`
								LEFT OUTER JOIN `{$this->prefix}product` `GP` ON `PG`.`group_id` = `GP`.`product_id`
							",
				'where' => array(),
				'group' => "`{$this->prefix}{$this->table}`.`product_id`",
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_paged_full($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								COALESCE(`PR`.`title`, '') AS `parent`,
								COALESCE(GROUP_CONCAT(`GP`.`title` SEPARATOR ' / '), '') AS `groups`
							",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}product` `PR` ON `{$this->prefix}{$this->table}`.`parent_id` = `PR`.`product_id`
								LEFT OUTER JOIN `{$this->prefix}product_group` `PG` ON `{$this->prefix}{$this->table}`.`product_id` = `PG`.`product_id`
								LEFT OUTER JOIN `{$this->prefix}product` `GP` ON `PG`.`group_id` = `GP`.`product_id`
							",
				'where' => array(),
				'group' => "`{$this->prefix}{$this->table}`.`product_id`",
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_paged_group($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								COALESCE(`PR`.`title`, '') AS `parent`
							",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}product` `PR` ON `{$this->prefix}{$this->table}`.`parent_id` = `PR`.`product_id`
							",
				'where' => array(),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}


	public function has_children($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'where' => array("`parent_id` = '{$object->get_id()}'"),
			);
		/* return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select); */
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_children($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`ST`.`stock`
							",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}stock` `ST` USING(`product_id`)
							",
				'where' => array("`parent_id` = '{$object->get_parent_id()}'"),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

}