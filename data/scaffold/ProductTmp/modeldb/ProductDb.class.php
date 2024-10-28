<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProductDb
 * GENERATION DATE:  2020-02-05
 * -------------------------------------------------------
 *
 */


class ProductDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'product';
	protected $primary = 'product_id';

	protected $fields = array(
			'product_code' => false, 'product_key' => false, 'product_type' => false, 'parent_id' => false, 
			'parent_key' => false, 'path' => false, 'title' => false, 'form' => false, 
			'short_description' => false, 'description' => false, 'details' => false, 'specs' => false, 
			'meta_title' => false, 'meta_description' => false, 'meta_keywords' => false, 'product_order' => false, 
			'measure_type' => false, 'standard_type' => false, 'base_price' => false, 'width' => false, 
			'height' => false, 'weight' => false, 'volume' => false, 'discounts' => false, 
			'turnarounds' => false, 'attachment' => false, 'minimum' => false, 'price_from' => false, 
			'use_stock' => false, 'stock_min' => false, 'disclaimer_id' => false, 'provider_id' => false, 
			'provider_code' => false, 'provider_name' => false, 'provider_url' => false, 'featured' => false, 
			'created' => false, 'active' => false
		);
	
}
?>
