<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Product
 * GENERATION DATE:  2019-10-25
 * -------------------------------------------------------
 *
 */

class Product extends Base {

	// Protected Vars

	protected $dbClass = 'ProductDb';

	protected $product_code = '';
	protected $product_key = '';
	protected $parent_id = '';
	protected $parent_key = '';
	protected $path = '';
	protected $title = '';
	protected $form = '';
	protected $short_description = '';
	protected $description = '';
	protected $details = '';
	protected $specs = '';
	protected $meta_title = '';
	protected $meta_description = '';
	protected $meta_keywords = '';
	protected $product_order = '';
	protected $measure_type = '';
	protected $standard_type = '';
	protected $base_price = '';
	protected $width = '';
	protected $height = '';
	protected $weight = '';
	protected $volume = '';
	protected $discounts = '';
	protected $turnarounds = '';
	protected $attachment = '';
	protected $minimum = '';
	protected $price_from = '';
	protected $use_stock = '';
	protected $stock_min = '';
	protected $disclaimer_id = '';
	protected $provider_id = '';
	protected $provider_code = '';
	protected $provider_name = '';
	protected $provider_url = '';
	protected $featured = '';

	protected $parent = '';
	protected $disclaimer = '';
	protected $provider = '';


	// Getters

	public function get_string() { return $this->title; }

	public function get_product_code() { return $this->product_code; }
	public function get_product_key() { return $this->product_key; }
	public function get_parent_id() { return $this->parent_id; }
	public function get_parent_key() { return $this->parent_key; }
	public function get_path() { return $this->path; }
	public function get_title() { return $this->title; }
	public function get_form() { return $this->form; }
	public function get_short_description() { return $this->short_description; }
	public function get_description() { return $this->description; }
	public function get_details() { return $this->details; }
	public function get_specs() { return $this->specs; }
	public function get_meta_title() { return $this->meta_title; }
	public function get_meta_description() { return $this->meta_description; }
	public function get_meta_keywords() { return $this->meta_keywords; }
	public function get_product_order() { return $this->product_order; }
	public function get_measure_type() { return $this->measure_type; }
	public function get_standard_type() { return $this->standard_type; }
	public function get_base_price() { return $this->base_price; }
	public function get_width() { return $this->width; }
	public function get_height() { return $this->height; }
	public function get_weight() { return $this->weight; }
	public function get_volume() { return $this->volume; }
	public function get_discounts() { return $this->discounts; }
	public function get_turnarounds() { return $this->turnarounds; }
	public function get_attachment() { return $this->attachment; }
	public function get_minimum() { return $this->minimum; }
	public function get_price_from() { return $this->price_from; }
	public function get_use_stock() { return $this->use_stock; }
	public function get_stock_min() { return $this->stock_min; }
	public function get_disclaimer_id() { return $this->disclaimer_id; }
	public function get_provider_id() { return $this->provider_id; }
	public function get_provider_code() { return $this->provider_code; }
	public function get_provider_name() { return $this->provider_name; }
	public function get_provider_url() { return $this->provider_url; }
	public function get_featured() { return $this->featured; }

	public function get_parent() { return $this->parent; }
	public function get_disclaimer() { return $this->disclaimer; }
	public function get_provider() { return $this->provider; }


	// Setters

	public function set_product_code($val) { $this->product_code = $val; }
	public function set_product_key($val) { $this->product_key = $val; }
	public function set_parent_id($val) { $this->parent_id = $val; }
	public function set_parent_key($val) { $this->parent_key = $val; }
	public function set_path($val) { $this->path = $val; }
	public function set_title($val) { $this->title = $val; }
	public function set_form($val) { $this->form = $val; }
	public function set_short_description($val) { $this->short_description = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_details($val) { $this->details = $val; }
	public function set_specs($val) { $this->specs = $val; }
	public function set_meta_title($val) { $this->meta_title = $val; }
	public function set_meta_description($val) { $this->meta_description = $val; }
	public function set_meta_keywords($val) { $this->meta_keywords = $val; }
	public function set_product_order($val) { $this->product_order = $val; }
	public function set_measure_type($val) { $this->measure_type = $val; }
	public function set_standard_type($val) { $this->standard_type = $val; }
	public function set_base_price($val) { $this->base_price = $val; }
	public function set_width($val) { $this->width = $val; }
	public function set_height($val) { $this->height = $val; }
	public function set_weight($val) { $this->weight = $val; }
	public function set_volume($val) { $this->volume = $val; }
	public function set_discounts($val) { $this->discounts = $val; }
	public function set_turnarounds($val) { $this->turnarounds = $val; }
	public function set_attachment($val) { $this->attachment = $val; }
	public function set_minimum($val) { $this->minimum = $val; }
	public function set_price_from($val) { $this->price_from = $val; }
	public function set_use_stock($val) { $this->use_stock = $val; }
	public function set_stock_min($val) { $this->stock_min = $val; }
	public function set_disclaimer_id($val) { $this->disclaimer_id = $val; }
	public function set_provider_id($val) { $this->provider_id = $val; }
	public function set_provider_code($val) { $this->provider_code = $val; }
	public function set_provider_name($val) { $this->provider_name = $val; }
	public function set_provider_url($val) { $this->provider_url = $val; }
	public function set_featured($val) { $this->featured = $val; }

	public function set_parent($val) { $this->parent = $val; }
	public function set_disclaimer($val) { $this->disclaimer = $val; }
	public function set_provider($val) { $this->provider = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->product_id);

			$this->set_product_code($row->product_code);
			$this->set_product_key($row->product_key);
			$this->set_parent_id($row->parent_id);
			$this->set_parent_key($row->parent_key);
			$this->set_path($row->path);
			$this->set_title($row->title);
			$this->set_form($row->form);
			$this->set_short_description($row->short_description);
			$this->set_description($row->description);
			$this->set_details($row->details);
			$this->set_specs($row->specs);
			$this->set_meta_title($row->meta_title);
			$this->set_meta_description($row->meta_description);
			$this->set_meta_keywords($row->meta_keywords);
			$this->set_product_order($row->product_order);
			$this->set_measure_type($row->measure_type);
			$this->set_standard_type($row->standard_type);
			$this->set_base_price($row->base_price);
			$this->set_width($row->width);
			$this->set_height($row->height);
			$this->set_weight($row->weight);
			$this->set_volume($row->volume);
			$this->set_discounts($row->discounts);
			$this->set_turnarounds($row->turnarounds);
			$this->set_attachment($row->attachment);
			$this->set_minimum($row->minimum);
			$this->set_price_from($row->price_from);
			$this->set_use_stock($row->use_stock);
			$this->set_stock_min($row->stock_min);
			$this->set_disclaimer_id($row->disclaimer_id);
			$this->set_provider_id($row->provider_id);
			$this->set_provider_code($row->provider_code);
			$this->set_provider_name($row->provider_name);
			$this->set_provider_url($row->provider_url);
			$this->set_featured($row->featured);
			$this->set_created($row->created);
			$this->set_active($row->active);

			$this->set_parent($row->parent);
			$this->set_disclaimer($row->disclaimer);
			$this->set_provider($row->provider);
		}
		return $this->row = $row;
	}

}
?>
