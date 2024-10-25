<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Size
 * GENERATION DATE:  08.09.2010
 * -------------------------------------------------------
 *
 */


class SizeDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'size';
	protected $primary = 'size_id';

	protected $fields = array(
			'product_key' => false, 'product_id' => false, 'format' => false, 'width' => false,
			'height' => false, 'price_a' => false, 'price_b' => false, 'price_c' => false,
			'price_d' => false, 'created' => false, 'provider_price' => false, 'provider_weight' => false, 
			'active' => false, 
		);


	// Lists

	public function list_count($object, $active_only = true, $hide_deleted = true, $where = false) {
		if ($object->get_product_key()) {
			$where = array("`product_key` = '{$object->get_product_key()}'");
		}
		return parent::list_count($object, $active_only, $hide_deleted, $where);
	}

	public function list_paged($object, $active_only = true, $hide_deleted = true, $where = false) {
		if ($object->get_product_key()) {
			$where = array("`product_key` = '{$object->get_product_key()}'");
		}
		return parent::list_paged($object, $active_only, $hide_deleted, $where);
	}

}
?>
