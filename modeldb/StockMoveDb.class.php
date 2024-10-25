<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        StockMoveDb
 * GENERATION DATE:  2016-02-01
 * -------------------------------------------------------
 *
 */


class StockMoveDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'stock_move';
	protected $primary = 'stock_move_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'user_id' => false, 'product_id' => false, 'concept' => false, 'concept_other' => false,
			'quantity' => false, 'balance' => false, 'created' => false
		);


	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
							`PD`.`title`,
							`US`.`username`
						",
				'from' => "`{$this->prefix}{$this->table}`
							INNER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
							LEFT OUTER JOIN `{$this->prefix}user` `US` USING(`user_id`)
						",
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'from' => "`{$this->prefix}{$this->table}`
							INNER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
							LEFT OUTER JOIN `{$this->prefix}user` `US` USING(`user_id`)
						",
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
							`PD`.`title`,
							`US`.`username`
						",
				'from' => "`{$this->prefix}{$this->table}`
							INNER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
							LEFT OUTER JOIN `{$this->prefix}user` `US` USING(`user_id`)
						",
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

}
?>
