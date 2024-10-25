<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Sale
 * GENERATION DATE:  24.06.2010
 * -------------------------------------------------------
 *
 */


class SaleDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'sale';
	protected $primary = 'sale_id';

	protected $fields = array(
			'hash' => false, 'source' => false, 'user_id' => false, 'wholesaler_id' => false,
			'quantity' => false, 'total_weight' => false, 'subtotal' => false, 'coupon' => false,
			'coupon_discount' => false, 'shipping' => false, 'taxes' => false, 'total' => false,
			'date_sold' => false, 'status' => false, 'payment_type' => false, 'name_card' => false,
			'credit_card' => false, 'created' => false, 'active' => false
		);


	// Custom

	public function update_total(&$object) {
		$where = array(
				"`sale_id` = ?",
				"`status` = 'st_added'",
				"`deleted` = 0",
			);
		$where = $this->get_where($object, $where, true, false, false);

		$query = "SELECT COUNT(*) AS `count_items`,
						SUM(`product_total`) AS `sum_product_total`,
						SUM(`shipping_weight`) AS `sum_shipping_weight`,
						SUM(`shipping_cost`) AS `sum_shipping_cost`
					FROM `{$this->prefix}sale_product`
				{$where};";
		$row = $this->fetchObject($query, array($object->get_id()));

		$fields = array(
				'quantity' => $row->count_items,
				'total_weight' => $row->sum_shipping_weight,
				'shipping' => $row->sum_shipping_cost,
				'subtotal' => $row->sum_product_total,
				'taxes' => $object->get_taxes(),
				'total' => $row->sum_product_total + $row->sum_shipping_cost + $object->get_taxes(),
			);
		$this->update($object, $fields);

		// update object
		$object->set_quantity($row->count_items);
		$object->set_total_weight($row->sum_shipping_weight);
		$object->set_shipping($row->sum_shipping_cost);
		$object->set_subtotal($row->sum_product_total);
		$object->set_total($row->sum_product_total + $row->sum_shipping_cost + $object->get_taxes());

		return $row->sum_product_total;
	}


	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = $this->get_filter($object);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = $this->get_filter($object);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	private function get_filter($object) {
		$where = array();
		if ($object->get_user_id()) {
			$where[] = "`user_id` = {$object->get_user_id()}";
		}
		if ($object->get_status()) {
			$where[] = "`status` = '{$object->get_status()}'";
		}
		return array('where' => $where);
	}

}
?>
