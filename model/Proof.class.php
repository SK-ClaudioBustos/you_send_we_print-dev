<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Proof
 * GENERATION DATE:  13.06.2014
 * -------------------------------------------------------
 *
 */

class Proof extends Base {

	// Protected Vars

	protected $dbClass = 'ProofDb';

	protected $sale_product_id = '';
	protected $image_id = '';
	protected $version = '';
	protected $filename = '';
	protected $newname = '';
	protected $size = '';
	protected $md5 = '';
	protected $description = '';
	protected $response = '';
	protected $status = '';


	// Getters

	public function get_string() { return $this->proof_id; }

	public function get_sale_product_id() { return $this->sale_product_id; }
	public function get_image_id() { return $this->image_id; }
	public function get_version() { return $this->version; }
	public function get_filename() { return $this->filename; }
	public function get_newname() { return $this->newname; }
	public function get_size() { return $this->size; }
	public function get_md5() { return $this->md5; }
	public function get_description() { return $this->description; }
	public function get_response() { return $this->response; }
	public function get_status() { return $this->status; }


	// Setters

	public function set_sale_product_id($val) { $this->sale_product_id = $val; }
	public function set_image_id($val) { $this->image_id = $val; }
	public function set_version($val) { $this->version = $val; }
	public function set_filename($val) { $this->filename = $val; }
	public function set_newname($val) { $this->newname = $val; }
	public function set_size($val) { $this->size = $val; }
	public function set_md5($val) { $this->md5 = $val; }
	public function set_description($val) { $this->description = $val; }
	public function set_response($val) { $this->response = $val; }
	public function set_status($val) { $this->status = $val; }


	// Public Methods

	public function is_ready($image_id) {
		$this->rs = $this->db->retrieve_last(array($image_id));
		$this->load();
//echo $this->get_id() .'['.$this->get_status().']';
		return ($this->get_id() && ($this->get_status() != 'rejected'));
	}

	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->proof_id);

			$this->set_sale_product_id($row->sale_product_id);
			$this->set_image_id($row->image_id);
			$this->set_version($row->version);
			$this->set_filename($row->filename);
			$this->set_newname($row->newname);
			$this->set_size($row->size);
			$this->set_md5($row->md5);
			$this->set_description($row->description);
			$this->set_response($row->response);
			$this->set_status($row->status);
			$this->set_created($row->created);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
