<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SaleShippingDb
 * GENERATION DATE:  05.03.2013
 * -------------------------------------------------------
 *
 */


class SaleShippingDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'sale_shipping';
	protected $primary = 'sale_shipping_id';

	protected $fields = array(
			'sale_id' => false, 'sale_product_id' => false, 'shipping_level' => false, 'shipping_zip' => false,
			'shipping_weight' => false, 'shipping_types' => false, 'shipping_type' => false, 'shipping_cost' => false,
			'active' => false);

}
?>
