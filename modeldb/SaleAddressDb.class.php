<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SaleAddressDb
 * GENERATION DATE:  11.08.2012
 * -------------------------------------------------------
 *
 */


class SaleAddressDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'sale_address';
	protected $primary = 'sale_address_id';

	protected $fields = array(
			'sale_id' => false, 'user_id' => false, 'address_type' => false, 'address_level' => false,
			'address_ws' => false, 'other_address_id' => false, 'same_address' => false, 'company' => false,
			'first_name' => false, 'last_name' => false, 'address' => false, 'city' => false,
			'state' => false, 'zip' => false, 'country' => false, 'phone' => false,
			'fax' => false, 'email' => false, 'latitude' => false, 'longitude' => false,
			'active' => false,
		);


	public function retrieve_by_sale($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'where' => array(
						"`sale_id` = ?",
						"`address_type` = ?",
					),
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_count($object, $active_only = true, $hide_deleted = true, $where = false, $select = false) {
		$where = $this->get_where($active_only, $hide_deleted, $where);
		if (!$select) {
			$select = "SELECT COUNT(*) AS `record_count`
					FROM `{$this->prefix}{$this->table}`";
		}
		$query = "{$select} {$where};";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch();
		return $row['record_count'];
	}

}
?>
