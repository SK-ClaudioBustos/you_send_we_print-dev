<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductList
 * GENERATION DATE:  23.06.2010
 * -------------------------------------------------------
 *
 */


class ProductListDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'product_list';
	protected $primary = 'product_list_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'product_id' => false,
			'item_list_key' => false);


	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`PD`.`title` AS `product`,
								`IL`.`title` AS `item_list`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
								INNER JOIN `{$this->prefix}item_list` `IL` USING(`item_list_key`)
							",
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}


	public function list_count($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
								INNER JOIN `{$this->prefix}item_list` `IL` USING(`item_list_key`)
							",
				'where' => array(
								"`PD`.`deleted` = 0",
								"`IL`.`deleted` = 0",
							),
			);
		return parent::list_count($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`PD`.`title` AS `product`,
								`IL`.`title` AS `item_list`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}product` `PD` USING(`product_id`)
								INNER JOIN `{$this->prefix}item_list` `IL` USING(`item_list_key`)
							",
				'where' => array(
								"`PD`.`deleted` = 0",
								"`IL`.`deleted` = 0",
							),
			);
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

}
?>
