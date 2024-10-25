<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SaleProduct
 * GENERATION DATE:  09.07.2010
 * -------------------------------------------------------
 *
 */


class SaleProductDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'sale_product';
	protected $primary = 'sale_product_id';

	protected $fields = array(
			'sale_id' => false,
			'job_name' => false,
			'description' => false,
			'comment' => false,
			'product_id' => false,
			'product_key' => false,
			'product' => false,
			'provider_id' => false,
			'provider_info' => false, 
			'measure_unit' => false,
			'width' => false,
			'height' => false,
			'partial_sqft' => false, 
			'partial_perim' => false,
			'quantity' => false,
			'total_sqft' => false,
			'total_perim' => false, 
			'sides' => false,
			'size' => false,
			'orientation' => false,
			'detail' => false, 
			'qty_discount_detail' => false,
			'quantity_discount' => false,
			'product_subtotal' => false,
			'subtotal_discount' => false, 
			'subtotal_discount_real' => false,
			'price_sqft' => false,
			'price_piece' => false,
			'turnaround_detail' => false, 
			'turnaround_cost' => false,
			'packaging' => false,
			'packaging_cost' => false,
			'proof' => false, 
			'proof_cost' => false,
			'shipping_cost' => false,
			'shipping_weight' => false,
			'sale_address_id' => false, 
			'product_total' => false,
			'date_confirm' => false,
			'date_due' => false,
			'status' => false, 
			'reason' => false,
			'status_customer' => false,
			'status_history' => false,
			'created' => false, 
			'active' => false
		);


	// Custom

	public function retrieve_sale_last($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'where' => "`sale_id` = ?",
				'order' => "`sale_product_id` DESC",
				'limit' => "1",
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	public function address_multiple_use($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'where' => "`sale_address_id` = {$object->get_sale_address_id()}",
			);
		$count = parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
		return ($count > 1);
	}


	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
//print_r($this->get_filter($object));
//exit;
		$sql_parts = array(
				'where' => $this->get_filter($object),
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts);
	}
	public function list_count_s($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'where' => $this->get_filter_S($object),
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'where' => $this->get_filter($object),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}
	public function list_paged_s($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'where' => $this->get_filter_s($object),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_stock($object, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`PD`.`title` AS `product`,
								`PD`.`use_stock`,
								`PD`.`stock_min`,
								`ST`.`stock`
							",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
								LEFT OUTER JOIN `{$this->prefix}stock` `ST` USING(`product_id`)
							",
					);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts);
	}


	private function get_filter($object) {
		// TODO: use set_paging filter

		$where = array();
		$where[] = "`sale_id` = '{$object->get_sale_id()}'";

		if ($status = $object->get_status()) {
			if (!is_array($status)) {
				$status = array($status);
			}
			$statuses = '';
			foreach ($status as $val) {
				$statuses .= "`status` = '{$val}' OR ";
			}
			$statuses = '(' . substr($statuses, 0, -4) . ')';
			$where[] = $statuses;
		}

		return $where;
	}
	private function get_filter_s($object) {
		// TODO: use set_paging filter

		$where = array();
		$where[] = "`sale_id` = '{$object->get_sale_id()}'";		

		return $where;
	}



	public function total_weight($object) {
		$where = array("`sale_id` = {$object->get_sale_id()}");
		$where = $this->get_where($object, $where, true, false, true);

		$select = "SELECT SUM(`shipping_weight`) AS `total_weight`
				FROM `{$this->prefix}{$this->table}`";

		$query = "{$select} {$where};";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();
		return $row['total_weight'];
	}

	public function activate($sale_id, $history) {
		// set status and clear temporary date due
		$query = "UPDATE `{$this->prefix}{$this->table}`
					SET `active` = 1,
						`status` = 'st_new',
						`status_customer` = 'st_new',
						`status_history` = ?,
						`date_due` = ''
					WHERE `sale_id` = ?
						AND `status` = 'st_added'";
		$stmt = $this->db->prepare($query);
		return $stmt->execute(array($history, $sale_id));
	}

	public function update_ship_address($sale_id, $sale_ship_address_id) {
		$query = "UPDATE `{$this->prefix}{$this->table}`
					SET `sale_address_id` = ?
					WHERE `sale_id` = ?";
		$stmt = $this->db->prepare($query);
		return $stmt->execute(array($sale_id, $sale_ship_address_id));
	}


}
?>
