<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Item
 * GENERATION DATE:  19.06.2010
 * -------------------------------------------------------
 *
 */


class ItemDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'item';
	protected $primary = 'item_id';

	protected $fields = array(
			'item_code' => false, 'item_list_key' => false, 'title' => false, 'description' => false,
			'price' => false, 'order' => false, 'max_width' => false, 'max_length' => false,
			'max_absolute' => false, 'calc_by' => false, 'weight' => false,'filter_word' => false,
			'price_date' => false,'active' => false);


	public function retrieve($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`IL`.`calc_by` AS `list_calc_by`
							",
				'from' => "`{$this->prefix}{$this->table}`
								INNER JOIN `{$this->prefix}item_list` `IL` USING(`item_list_key`)
							",
			);
		return parent::retrieve($values, $active_only, $hide_deleted, $sql_parts);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
								`IL`.`title` AS `item_list`,
								`IL`.`calc_by` AS `list_calc_by`
							",
				'from' => "`{$this->prefix}{$this->table}`
								LEFT OUTER JOIN `{$this->prefix}item_list` `IL` USING(`item_list_key`)
							",
			);
		if ($object->get_item_list_key()) {
			$sql_parts['where'] = array("`item_list_key` = '{$object->get_item_list_key()}'");
		}
		return parent::list_paged($object, $active_only, $hide_deleted, $sql_parts, $old_select);
	}

}
?>
