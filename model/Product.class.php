<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Product
 * GENERATION DATE:  03.06.2010
 * -------------------------------------------------------
 *
 */

class Product extends Base {

	// Protected Vars

	protected $dbClass = 'ProductDb';

	protected $sort_field = 'product_order';
	protected $sort_order = 'ASC';

	protected $product_code = '';
	protected $product_key = '';
	protected $product_type = '';
	protected $parent_id = 0;
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
	protected $product_order = 0;
	protected $group_home = 0;

	protected $measure_type = '';
	protected $standard_type = '';

	protected $base_price = 0.00;
	protected $setup_fee = 0.00;
	protected $width = 0.00;
	protected $height = 0.00;
	protected $weight = 0.00;
	protected $volume = 0.00;

	protected $discounts = '';
	protected $turnarounds = '';
	protected $attachment = '';

	protected $minimum = 0.00;
	protected $price_from = 0.00;
	protected $use_stock = false;
	protected $stock_min = 0;
	protected $disclaimer_id = 0;

	protected $provider_id = 0;
	protected $provider_code = '';
	protected $provider_name = '';
	protected $provider_url = '';

	protected $featured = '';

	protected $parent_path = '';
	protected $current_title = '';

	protected $stock = 0;
	protected $provider = '';
	protected $provider_city = '';
	protected $provider_state = '';

	protected $parent = '';
	protected $groups = '';

	protected $price_date = '';

	// Getters

	public function get_string() { return $this->title; }

	public function get_parent_path() { return $this->parent_path; }

	public function get_product_code() { return $this->product_code; }
	public function get_product_key() { return $this->product_key; }
	public function get_product_type() { return $this->product_type; }
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
	public function get_group_home() { return $this->group_home; }

	public function get_measure_type() { return $this->measure_type; }
	public function get_standard_type() { return $this->standard_type; }

	public function get_base_price() { return $this->base_price; }
	public function get_setup_fee() { return $this->setup_fee; }
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

	public function get_stock() { return $this->stock; }
	public function get_provider() { return $this->provider; }
	public function get_provider_city() { return $this->provider_city; }
	public function get_provider_state() { return $this->provider_state; }

	public function get_parent() { return $this->parent; }
	public function get_groups() { return $this->groups; }

	public function get_price_date() { return $this->price_date; }

	// Setters

	public function set_parent_path($val) { $this->parent_path = $val; }

	public function set_product_code($val) { $this->product_code = $val; }
	public function set_product_key($val) { $this->product_key = $val; }
	public function set_product_type($val) { $this->product_type = $val; }
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
	public function set_group_home($val) { $this->group_home = $val; }

	public function set_measure_type($val) { $this->measure_type = $val; }
	public function set_standard_type($val) { $this->standard_type = $val; }

	public function set_base_price($val) { $this->base_price = $val; }
	public function set_setup_fee($val) { $this->setup_fee = $val; }
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

	public function set_stock($val) { $this->stock = $val; }
	public function set_provider($val) { $this->provider = $val; }
	public function set_provider_city($val) { $this->provider_city = $val; }
	public function set_provider_state($val) { $this->provider_state = $val; }

	public function set_parent($val) { $this->parent = $val; }
	public function set_groups($val) { $this->groups = $val; }

	public function set_price_date($val) { $this->price_date = $val; }

	// Public Methods

	public function update($convert_arrays = true, $format_json = false) {
		if (in_array($this->product_type, array('product-single', 'product-multiple', 'subproduct'))
				|| $this->title != $this->current_title) {
			//$this->set_new_key();
			$this->product_key = $this->get_new_key('product_key', $this->product_key, $this->title, true);
		}

		parent::update($convert_arrays, $format_json);
	}

	public function update_order($product_id, $order) {
		return $this->db->update_order($product_id, $order);
	}

	public function set_new_key() {
		// if no slug, create a new slug or, key can be changed on last level products
		//if (!$this->product_key || ((substr_count($this->get_path(), '/') >= 3) && ($this->title != $this->current_title))) {
		if (in_array($this->product_type, array('product-single', 'product-multiple', 'subproduct'))
				|| $this->title != $this->current_title) {
			$product_key = $this->utl->get_rewrite_string($this->get_title());

			if (!$this->product_key || $this->product_key != $product_key) {
				// title could change but key could keep the same
				$existing = $this->db->check_existing_key('product_key', $product_key);

				if ($existing){
					$last_number = (int)substr($existing, strripos($existing, ".") + 1);

					if (is_numeric($last_number) && $last_number > 0) {
						$last_number++;
						$product_key .= "." . sprintf("%02d", $last_number);
					} else {
						$product_key .= ".01";
					}
				}
				$this->set_product_key($product_key);
			}
		}

		//$this->set_path($this->get_parent_path() . '/' . $this->product_key);
	}

	public function list_parents($list = Array(), $parent_key = '', $parent_title = '', $path = '/') {
		$rs = $this->db->list_parents($parent_key);

		while ($row = $rs->fetchObject()) {
			if ($row->product_key) {
				$list[$path . $row->product_key] = $parent_title . $row->title;
				$list = $this->list_parents($list, $row->product_key, $parent_title . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $path . $row->product_key . '/');
			}
		}
		return $list;
	}

	public function list_parents_id($list = Array(), $parent_key = '', $parent_title = '', $path = '/') {
		$rs = $this->db->list_parents($parent_key);

		while ($row = $rs->fetchObject()) {
			if ($row->product_key) {
				$list[$row->product_id] = $parent_title . $row->title;
				$list = $this->list_parents_id($list, $row->product_key, $parent_title . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $path . $row->product_key . '/');
			}
		}
		return $list;
	}

	public function has_children($active_only = false, $hide_deleted = true) {
		return $this->db->has_children($this, $active_only = false, $hide_deleted = true);
	}

	public function list_children($active_only = true, $hide_deleted = true) {
		$this->set_paging(1, 0, '`product_order` ASC');
		if ($this->row == null) $this->rs = $this->db->list_children($this, $active_only, $hide_deleted);
		return $this->load();
	}

	public function list_paged_group($active_only = true, $hide_deleted = true) {
		if ($this->row == null) $this->rs = $this->db->list_paged_group($this, $active_only, $hide_deleted);
		return $this->load();
	}


	public function list_count_full($active_only = true, $hide_deleted = true) {
		$this->record_count = $this->db->list_count_full($this, $active_only, $hide_deleted);
		return $this->record_count;
	}

	public function list_paged_full($active_only = true, $hide_deleted = true) {
		if ($this->row == null) $this->rs = $this->db->list_paged_full($this, $active_only, $hide_deleted);
		return $this->load();
	}


	// Protected Methods

	protected function assing_parent_path() {
		$pos = strrpos($this->get_path(), '/');
		$this->parent_path = substr($this->get_path(), 0, $pos);
	}

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->product_id);

			$this->set_product_code($row->product_code);
			$this->set_product_key($row->product_key);
			$this->set_product_type($row->product_type);
			$this->set_parent_id($row->parent_id);

			//$this->set_parent_key($row->parent_key);
			//$this->set_path($row->path);
			//$this->assing_parent_path();

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
			$this->set_group_home($row->group_home);

			$this->set_measure_type($row->measure_type);
			$this->set_standard_type($row->standard_type);

			$this->set_base_price($row->base_price);
			$this->set_setup_fee($row->setup_fee);
			$this->set_width($row->width);
			$this->set_height($row->height);
			$this->set_weight($row->weight);
			$this->set_volume($row->volume);

			$this->set_discounts($row->discounts);
			$this->set_turnarounds($row->turnarounds);
			$this->set_attachment($row->attachment); //json_decode($row->attachment, true)); // <<<

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
			$this->current_title = $row->title;

			$this->set_stock((int)$row->stock);
			$this->set_provider($row->provider);
			$this->set_provider_city($row->provider_city);
			$this->set_provider_state($row->provider_state);

			$this->set_parent($row->parent);
			$this->set_groups($row->groups);

			$this->set_price_date($row->price_date);
		}
		return $this->row = $row;
	}

}
?>
