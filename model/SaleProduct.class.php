<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SaleProduct
 * GENERATION DATE:  24.06.2010
 * -------------------------------------------------------
 *
 */

class SaleProduct extends Base {

	// Protected Vars

	protected $dbClass = 'SaleProductDb';

	protected $sale_id = '';
	protected $job_name = '';

	protected $description = '';
	protected $comment = '';
	protected $detail_text = '';

	protected $product_id = '';
	protected $product_key = '';
	protected $product = '';
	protected $provider_id = 0;
	protected $provider_info = array();

	protected $measure_unit = 'std'; // standard/custom
	protected $width = '';
	protected $height = '';
	protected $partial_sqft = 0;
	protected $partial_perim = 0;
	protected $quantity = 1;
	protected $total_sqft = 0;
	protected $total_perim = 0;

	protected $size = '';
	protected $sides = 0;
	protected $orientation = '';

	protected $detail = array();

	protected $qty_discount_detail = '';
	protected $quantity_discount = 0;

	protected $product_subtotal = 0;
	protected $subtotal_discount = 0;
	protected $subtotal_discount_real = 0;

	protected $price_sqft = 0;
	protected $price_piece = 0;

	protected $turnaround_detail = '';
	protected $turnaround_cost = 0;

	protected $packaging = '';
	protected $packaging_cost = 0;

	protected $proof = '';
	protected $proof_cost = 0;

	protected $sale_address_id = 0;
	protected $load_address = false; // for showing in cart
	protected $sale_address;

	protected $product_total = 0;

	protected $created;
	protected $date_confirm;
	protected $date_due;

	protected $status = 'st_saved';
	protected $reason = '';

	protected $status_customer = '';
	protected $status_history = array();

	// redundant with sale_shipping
	protected $shipping_cost = 0;
	protected $shipping_weight = 0;

	// only for carrying
	protected $shipping_zip = '';
	protected $shipping_types = '';
	protected $shipping_type = '';
	protected $shipping_change = false;

	// for list
	protected $date_sold = '';
	protected $last_name = '';
	protected $username = '';
	protected $company = '';


	// Getters

	public function get_sale_id() { return $this->sale_id; }
	public function get_job_name() { return $this->job_name; }

	public function get_description() { return $this->description; }
	public function get_comment() { return $this->comment; }
	public function get_detail_text() { return $this->detail_text; }

	public function get_product_id() { return $this->product_id; }
	public function get_product_key() { return $this->product_key; }
	public function get_product() { return $this->product; }
	public function get_provider_id() { return $this->provider_id; }
	public function get_provider_info() { return $this->provider_info; }

	public function get_measure_unit() { return $this->measure_unit; }
	public function get_width() { return $this->width; }
	public function get_height() { return $this->height; }

	public function get_partial_sqft() { return $this->partial_sqft; }
	public function get_partial_perim() { return $this->partial_perim; }
	public function get_quantity() { return $this->quantity; }
	public function get_total_sqft() { return $this->total_sqft; }
	public function get_total_perim() { return $this->total_perim; }

	public function get_sides() { return $this->sides; }
	public function get_size() { return $this->size; }
	public function get_orientation() { return $this->orientation; }

	public function get_detail() { return $this->detail; }

	public function get_qty_discount_detail() { return $this->qty_discount_detail; }
	public function get_quantity_discount() { return $this->quantity_discount; }

	public function get_product_subtotal() { return $this->product_subtotal; }
	public function get_subtotal_discount() { return $this->subtotal_discount; }
	public function get_subtotal_discount_real() { return $this->subtotal_discount_real; }

	public function get_price_sqft() { return $this->price_sqft; }
	public function get_price_piece() { return $this->price_piece; }

	public function get_turnaround_detail() { return $this->turnaround_detail; }
	public function get_turnaround_cost() { return $this->turnaround_cost; }
	public function get_packaging() { return $this->packaging; }
	public function get_packaging_cost() { return $this->packaging_cost; }

	public function get_proof() { return $this->proof; }
	public function get_proof_cost() { return $this->proof_cost; }

	public function get_sale_address_id() { return $this->sale_address_id; }
	public function get_shipping_weight() { return $this->shipping_weight; }
	public function get_shipping_cost() { return $this->shipping_cost; }

	public function get_product_total() { return $this->product_total; }

	public function get_date_confirm() { return $this->date_confirm; }
	public function get_date_due() { return $this->date_due; }

	public function get_status() { return $this->status; }
	public function get_reason() { return $this->reason; }
	public function get_status_customer() { return $this->status_customer; }
	public function get_status_history() {
		return json_encode($this->status_history);
	}

	public function get_shipping_zip() { return $this->shipping_zip; }
	public function get_shipping_types() { return $this->shipping_types; }
	public function get_shipping_type() { return $this->shipping_type; }
	public function get_shipping_change() { return $this->shipping_change; }

	public function get_load_address() { return $this->load_address; }
	public function get_sale_address() { return $this->sale_address; }


	// Setters

	public function set_sale_id($val) { $this->sale_id = $val; }
	public function set_job_name($val) { $this->job_name = $val; }

	public function set_description($val) { $this->description = $val; }
	public function set_comment($val) { $this->comment = $val; }
	public function set_detail_text($val) { $this->detail_text = $val; }

	public function set_product_id($val) { $this->product_id = $val; }
	public function set_product_key($val) { $this->product_key = $val; }
	public function set_product($val) { $this->product = $val; }
	public function set_provider_id($val) { $this->provider_id = $val; }
	public function set_provider_info($val) { $this->provider_info = $val; }

	public function set_measure_unit($val) { $this->measure_unit = $val; }
	public function set_width($val) { $this->width = $val; }
	public function set_height($val) { $this->height = $val; }

	public function set_partial_sqft($val) { $this->partial_sqft = $val; }
	public function set_partial_perim($val) { $this->partial_perim = $val; }
	public function set_quantity($val) { $this->quantity = $val; }
	public function set_total_sqft($val) { $this->total_sqft = $val; }
	public function set_total_perim($val) { $this->total_perim = $val; }

	public function set_sides($val) { $this->sides = $val; }
	public function set_size($val) { $this->size = $val; }
	public function set_orientation($val) { $this->orientation = $val; }

	public function set_detail($val) { $this->detail = $val; }

	public function set_qty_discount_detail($val) { $this->qty_discount_detail = $val; }
	public function set_quantity_discount($val) { $this->quantity_discount = $val; }

	public function set_product_subtotal($val) { $this->product_subtotal = $val; }
	public function set_subtotal_discount($val) { $this->subtotal_discount = $val; }
	public function set_subtotal_discount_real($val) { $this->subtotal_discount_real = $val; }

	public function set_price_sqft($val) { $this->price_sqft = $val; }
	public function set_price_piece($val) { $this->price_piece = $val; }

	public function set_turnaround_detail($val) { $this->turnaround_detail = $val; }
	public function set_turnaround_cost($val) { $this->turnaround_cost = $val; }
	public function set_packaging($val) { $this->packaging = $val; }
	public function set_packaging_cost($val) { $this->packaging_cost = $val; }

	public function set_proof($val) { $this->proof = $val; }
	public function set_proof_cost($val) { $this->proof_cost = $val; }

	public function set_shipping_cost($val) { $this->shipping_cost = $val; }
	public function set_shipping_weight($val) { $this->shipping_weight = $val; }
	public function set_sale_address_id($val) { $this->sale_address_id = $val; }

	public function set_product_total($val) { $this->product_total = $val; }

	public function set_date_confirm($val) { $this->date_confirm = $val; }
	public function set_date_due($val) { $this->date_due = $val; }

	public function set_status($val) {
		$this->status = $val;

		if ($val != 'st_added') {
			$this->status_history[] = array(
					'date' => date('Y-m-d H:i:s'),
					'status' => $val,
					'user' => '[client]'
				);
		}
	}

	public function set_reason($val) { $this->reason = $val; }
	public function set_status_customer($val) { $this->status_customer = $val; }

	public function set_status_history($val) { $this->status_history = $val; }

	public function set_shipping_zip($val) { $this->shipping_zip = $val; }
	public function set_shipping_types($val) { $this->shipping_types = $val; }
	public function set_shipping_type($val) { $this->shipping_type = $val; }
	public function set_shipping_change($val) { $this->shipping_change = $val; }

	public function set_load_address($val) { $this->load_address = $val; }


	// Public Methods

	public function retrieve_sale_last($sale_id) {
		$this->rs = $this->db->retrieve_sale_last($sale_id);
		$this->load();
	}

	public function update($convert_arrays = true, $format_json = false) {
		// pretify detail & provider
		$detail = $this->detail;
		$this->detail = $this->utl->json_pretty_print(json_encode($detail));
		$provider_info = $this->provider_info;
		$this->provider_info = $this->utl->json_pretty_print(json_encode($provider_info));

		if ($this->get_id()) {
			$this->db->update($this);
		} else {
			$this->id = $this->db->insert($this);
		}

		// restore detail & provider
		$this->detail = $detail;
		$this->provider_info = $provider_info;
		return $this->id;
	}

	public function update_status($status) {
		$this->set_status($status);
		$this->db->update($this);
	}

	public function update_ship_address($sale_id, $sale_ship_address_id) {
		$this->db->update_ship_address($sale_id, $sale_ship_address_id);
	}

	public function address_multiple_use() {
		return $this->db->address_multiple_use($this);
	}

	public function files_count() {
		$images = new Image();
		$images->set_sale_product_id($this->get_id());

		return $images->list_count();
	}

	public function total_weight() {
		return $this->db->total_weight($this);
	}

	public function activate($sale_id, $date_sold) {
		$history = json_encode(array(array(
					'date' => $date_sold,
					'status' => 'st_new',
					'user' => '[client]'
				)));

		return $this->db->activate($sale_id, $history);
	}

	public function list_paged($only_actives = true, $hide_deleted = true, $sql_parts = [], $values = []) {
		if ($this->row == null) {
			$this->rs = $this->db->list_paged($this, $only_actives, $hide_deleted);
		}
		$load = $this->load();
		if ($this->get_load_address()) {
			$this->sale_address = new SaleAddress($this->get_sale_address_id());
		}
		return $load;
	}
	public function list_paged_s($only_actives = true, $hide_deleted = true) {
		if ($this->row == null) {
			$this->rs = $this->db->list_paged_s($this, $only_actives, $hide_deleted);
		}
		$load = $this->load();
		if ($this->get_load_address()) {
			$this->sale_address = new SaleAddress($this->get_sale_address_id());
		}
		return $load;
	}

	public function list_count_s()
	{
		return $this->db->list_count_s($this, true, true);
	}

	public function all_proof_approved() {
		$images = new Image();
		$images->set_paging(1, 0, '`image_id` ASC', array("`sale_product_id` = {$this->get_id()}"));

		$all_approved = true;
		while($images->list_paged()) {
			$result = $images->get_approved();
			$all_approved = ($all_approved && $result);
		}
		return $all_approved;
	}

	public function list_stock($only_actives = true, $hide_deleted = true) {
		if ($this->row == null) {
			$this->rs = $this->db->list_stock($this, $only_actives, $hide_deleted);
		}
		return $this->load();
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->sale_product_id);

			$this->set_sale_id($row->sale_id);
			$this->set_job_name($row->job_name);

			$this->set_description($row->description);
			$this->set_comment($row->comment);
			$this->set_detail_text($row->detail_text);

			$this->set_product_id($row->product_id);
			$this->set_product_key($row->product_key);
			$this->set_product($row->product);
			$this->set_provider_id($row->provider_id);
			$this->set_provider_info(json_decode($row->provider_info, true)); // <<<

			$this->set_measure_unit($row->measure_unit);
			$this->set_width($row->width);
			$this->set_height($row->height);

			$this->set_partial_sqft($row->partial_sqft);
			$this->set_partial_perim($row->partial_perim);

			$this->set_quantity($row->quantity);
			$this->set_total_sqft($row->total_sqft);
			$this->set_total_perim($row->total_perim);

			$this->set_sides($row->sides);
			$this->set_size($row->size);
			$this->set_orientation($row->orientation);

			$this->set_detail(json_decode($row->detail, true)); // <<<

			$this->set_qty_discount_detail($row->qty_discount_detail);
			$this->set_quantity_discount($row->quantity_discount);
			$this->set_product_subtotal($row->product_subtotal);
			$this->set_subtotal_discount($row->subtotal_discount);
			$this->set_subtotal_discount_real($row->subtotal_discount_real);

			$this->set_price_sqft($row->price_sqft);
			$this->set_price_piece($row->price_piece);

			$this->set_turnaround_detail($row->turnaround_detail);
			$this->set_turnaround_cost($row->turnaround_cost);
			$this->set_packaging($row->packaging);
			$this->set_packaging_cost($row->packaging_cost);
			$this->set_proof($row->proof);
			$this->set_proof_cost($row->proof_cost);

			$this->set_shipping_cost($row->shipping_cost);
			$this->set_shipping_weight($row->shipping_weight);
			$this->set_sale_address_id($row->sale_address_id);

			$this->set_product_total($row->product_total);

			$this->set_created($row->created);
			$this->set_date_confirm($row->date_confirm);
			$this->set_date_due($row->date_due);
			$this->set_status($row->status);
			$this->set_reason($row->reason);
			$this->set_status_customer($row->status_customer);

			$this->status_history = ($row->status_history) ? json_decode($row->status_history, true) : array();

			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
