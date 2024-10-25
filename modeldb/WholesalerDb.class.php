<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        WholesalerDb
 * GENERATION DATE:  05.06.2012
 * -------------------------------------------------------
 *
 */


class WholesalerDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'wholesaler';
	protected $primary = 'wholesaler_id';

	protected $fields = array(
			'user_id' => false, 'customer_type' => false, 'company' => false, 'first_name' => false,
			'last_name' => false, 'website' => false, 'business_type' => false, 'trade_id' => false,
			'how_hear' => false, 'bill_address' => false, 'bill_city' => false, 'bill_state' => false,
			'bill_zip' => false, 'bill_country' => false, 'bill_phone' => false, 'bill_fax' => false,
			'ship_same' => false, 'ship_company' => false, 'ship_first_name' => false, 'ship_last_name' => false,
			'ship_address' => false, 'ship_city' => false, 'ship_state' => false, 'ship_zip' => false,
			'ship_country' => false, 'ship_phone' => false, 'ship_fax' => false, 'language' => false,
			'status' => false, 'discount' => false, 'wholesaler_number' => false, 'wholesaler_image' => false,
			'certificate_image' => false, 'taxable' => false, 'created' => false, 'active' => false
		);


	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`US`.`email`,
								`US`.`username`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}user` US USING(`user_id`)
							",
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	public function retrieve_by($fields, $values, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`US`.`email`,
								`US`.`username`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}user` US USING(`user_id`)
							",
			);
		return parent::retrieve_by($fields, $values, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`US`.`email`,
								`US`.`username`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}user` US USING(`user_id`)
							",
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function retrieve_by_user($values = false, $active_only = false, $hide_deleted = false, $sql_parts = false)
	{
		$sql_parts = array(
			'where' => array("`user_id` = ?"),
		);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

}
?>
