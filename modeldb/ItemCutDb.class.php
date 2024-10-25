<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ItemCutDb
 * GENERATION DATE:  2019-02-12
 * -------------------------------------------------------
 *
 */


class ItemCutDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'item_cut';
	protected $primary = 'item_cut_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'item_id' => false, 'cut_id' => false
		);


	// Overrided Protected methods

	public function list_count_info($object, $only_actives = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'from' => "`{$this->prefix}{$this->table}`
									INNER JOIN `{$this->prefix}item` `IT` ON `{$this->prefix}{$this->table}`.`cut_id` = `IT`.`item_id`
								",
			);
		return parent::list_count($object, $only_actives, $hide_deleted, $sql_parts, $old_select);
	}

	public function list_paged_info($object, $only_actives = true, $hide_deleted = true, $sql_parts = false, $old_select = false) {
		$sql_parts = array(
				'select' => "`{$this->prefix}{$this->table}`.*,
									`IT`.`item_code`,
									`IT`.`title` AS `item`,
									`IT`.`description`
								",
				'from' => "`{$this->prefix}{$this->table}`
									INNER JOIN `{$this->prefix}item` `IT` ON `{$this->prefix}{$this->table}`.`cut_id` = `IT`.`item_id`
								",
				'where' => array(),
			);
		return parent::list_paged($object, $only_actives, $hide_deleted, $sql_parts, $old_select);
	}

}
?>
