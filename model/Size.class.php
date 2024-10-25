<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Size
 * GENERATION DATE:  09.09.2010
 * -------------------------------------------------------
 *
 */

class Size extends Base {

	// Protected Vars

	protected $dbClass = 'SizeDb';

	protected $product_key = '';
	protected $product_id = '';
	protected $format = 's';
	protected $width = 0;
	protected $height = 0;

	protected $price_a = 0;
	protected $price_b = 0;
	protected $price_c = 0;
	protected $price_d = 0;

	protected $provider_price = 0;
	protected $provider_weight = 0;

	protected $active = 1;

	protected $sort_field = 'format`, `width`, `height';
	protected $sort_order = '';
	protected $records_page = 0;

	// Getters

	public function get_product_key() { return $this->product_key; }
	public function get_product_id() { return $this->product_id; }
	public function get_format() { return $this->format; }
	public function get_width() { return $this->width; }
	public function get_height() { return $this->height; }

	public function get_price_a() { return $this->price_a; }
	public function get_price_b() { return $this->price_b; }
	public function get_price_c() { return $this->price_c; }
	public function get_price_d() { return $this->price_d; }

	public function get_provider_price() { return $this->provider_price; }
	public function get_provider_weight() { return $this->provider_weight; }

	public function get_active() { return $this->active; }


	// Setters

	public function set_product_id($val) { $this->product_id = $val; }
	public function set_product_key($val) { $this->product_key = $val; }
	public function set_format($val) { $this->format = $val; }
	public function set_width($val) { $this->width = $val; }
	public function set_height($val) { $this->height = $val; }

	public function set_price_a($val) { $this->price_a = $val; }
	public function set_price_b($val) { $this->price_b = $val; }
	public function set_price_c($val) { $this->price_c = $val; }
	public function set_price_d($val) { $this->price_d = $val; }

	public function set_provider_price($val) { $this->provider_price = $val; }
	public function set_provider_weight($val) { $this->provider_weight = $val; }

	public function set_active($val) { $this->active = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->size_id);

			$this->set_product_key($row->product_key);
			$this->set_product_id($row->product_id);
			$this->set_format($row->format);
			$this->set_width($row->width);
			$this->set_height($row->height);

			$this->set_price_a($row->price_a);
			$this->set_price_b($row->price_b);
			$this->set_price_c($row->price_c);
			$this->set_price_d($row->price_d);

			$this->set_provider_price($row->provider_price);
			$this->set_provider_weight($row->provider_weight);

			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
