<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        StockDb
 * GENERATION DATE:  01.02.2016
 * -------------------------------------------------------
 *
 */


class StockDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'stock';
	protected $primary = 'stock_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'product_id' => false, 'stock' => false, 'last_update' => false
		);


	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'from' => "`{$this->prefix}{$this->table}`
							INNER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
						",
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
							`PD`.`title`,
							`PD`.`stock_min`
						",
				'from' => "`{$this->prefix}{$this->table}`
							INNER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
						",
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

}
?>
