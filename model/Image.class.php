<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Image
 * GENERATION DATE:  17.09.2010
 * -------------------------------------------------------
 *
 */

class Image extends Base {

	// Protected Vars

	protected $dbClass = 'ImageDb';

	protected $sale_product_id = '';
	protected $image_order = '';
	protected $filename = '';
	protected $newname = '';
	protected $size = '';
	protected $md5 = '';
	protected $quantity = '';
	protected $description = '';
	protected $repeated = '';
	protected $approved = '';


	// Getters

	public function get_sale_product_id() { return $this->sale_product_id; }
	public function get_image_order() { return $this->image_order; }
	public function get_filename() { return $this->filename; }
	public function get_newname() { return $this->newname; }
	public function get_size() { return $this->size; }
	public function get_md5() { return $this->md5; }
	public function get_quantity() { return $this->quantity; }
	public function get_description() { return $this->description; }
	public function get_repeated() { return $this->repeated; }
	public function get_approved() { return $this->approved; }


	// Setters

	public function set_sale_product_id($val) { $this->sale_product_id = $val; }
	public function set_image_order($val) { $this->image_order = $val; }
	public function set_filename($val) { $this->filename = $val; }
	public function set_newname($val) { $this->newname = $val; }
	public function set_size($val) { $this->size = $val; }
	public function set_md5($val) { $this->md5 = $val; }
	public function set_quantity($val) { $this->quantity = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_repeated($val) { $this->repeated = $val; }
	public function set_approved($val) { $this->approved = $val; }


	// Public Methods

	public function verify_md5() {
		return $this->db->verify_md5($this);
	}

	public function list_by_sale_product($sale_product_id) {
		if ($this->row == null) $this->rs = $this->db->list_by_sale_product($this, $sale_product_id);
		return $this->load();
	}


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->image_id);

			$this->set_sale_product_id($row->sale_product_id);
			$this->set_image_order($row->image_order);
			$this->set_filename($row->filename);
			$this->set_newname($row->newname);
			$this->set_size($row->size);
			$this->set_md5($row->md5);
			$this->set_quantity($row->quantity);
			$this->set_description($row->description);
			$this->set_repeated($row->repeated);
			$this->set_approved($row->approved);

			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
