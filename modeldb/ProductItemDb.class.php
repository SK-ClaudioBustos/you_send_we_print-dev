<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductItem
 * GENERATION DATE:  23.06.2010
 * -------------------------------------------------------
 *
 */


class ProductItemDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'product_item';
	protected $primary = 'product_item_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'product_id' => false, 'product_key' => false, 'item_list_key' => false, 'item_id' => false,
//			'item_key' => false,
			'order' => false, 'default' => false);


	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$where  = array();
		if ($active_only) {
			$where[] = "`IT`.`active` = 1";
		}
		if ($hide_deleted) {
			$where[] = "`IT`.`deleted` = 0";
		}
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`IT`.`title` AS `item`,
								`IT`.`item_code`,
								`IT`.`description`,
								`IT`.`max_width`,
								`IT`.`max_length`,
								`IT`.`max_absolute`,
								`IT`.`calc_by`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}item` `IT` USING(`item_id`)",
				'where' => $where,
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}



	public function list_pagedK($object, $active_only = true, $hide_deleted = true, $where = false) {
		$where  = array();
		$where[] = "`product_id` = ?";
		$where[] = "PI.`item_list_key` = ?";
		if ($active_only) {
			$where[] = "I.`active` = 1";
		}
		if ($hide_deleted) {
			$where[] = "I.`deleted` = 0";
		}
		$where = $this->get_where($object, $where, true, $active_only, $hide_deleted);

		$select = "SELECT PI.*, I.`title` AS `item`, I.`item_code`, I.`description`, I.`max_width`, I.`max_length`, I.`max_absolute`, I.`calc_by`
					FROM `{$this->prefix}{$this->table}` PI
						INNER JOIN `{$this->prefix}item` I USING(`item_id`)";
		$order = "ORDER BY `order` ASC";
		$query = "{$select} {$where} {$order};";
//echo $query; exit;
		$stmt = $this->db->prepare($query);
		$stmt->execute(array($object->get_product_id(), $object->get_item_list_key()));
		return $stmt;
	}

	public function update_order($item_list_key, $product_id, $item_id, $order) {
		$query = "UPDATE `{$this->prefix}{$this->table}`
					SET `order` = '{$order}'
					WHERE `item_list_key` = '{$item_list_key}'
						AND `product_id` = '{$product_id}'
						AND `item_id` = '{$item_id}';";
		return $this->db->exec($query);
	}

}
?>
