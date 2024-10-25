<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Image
 * GENERATION DATE:  17.09.2010
 * -------------------------------------------------------
 *
 */


class ImageDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'image';
	protected $primary = 'image_id';

	protected $fields = array(
			'sale_product_id' => false, 'image_order' => false, 'filename' => false, 'newname' => false,
			'size' => false, 'md5' => false, 'quantity' => false, 'description' => false,
			'repeated' => false, 'approved' => false, 'active' => false);


	public function verify_md5($object) {
		$where = array();
		$where[] = "`sale_product_id` = '{$object->get_sale_product_id()}'";
		$where[] = "`md5` = '{$object->get_md5()}'";
		$where[] = "`image_id` != '{$object->get_id()}'";
		return parent::list_count($object, true, true, $where);
	}

}
?>
