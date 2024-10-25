<?phpphp
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        EventReport
 * GENERATION DATE:  2017-01-13
 * -------------------------------------------------------
 *
 */

class Report extends Base {

	// Protected Vars

	protected $dbClass = 'ReportDb';


	// Getters


	// Setters


	// Public Methods


	public function list_header($level, $parent_id, $ancestor_id) {
		if ($this->row == null) {
			$this->rs = $this->db->list_header($this, $level, $parent_id, $ancestor_id);
		}
		return $this->load_empty();
	}


	// items -------------------------------------------------------------------------

	// total
	public function list_transactions($level, $reference_id, $ancestor_id, $filter) {
		if ($this->row == null) {
			$this->rs = $this->db->list_transactions($this, $level, $reference_id, $ancestor_id, $filter);
		}
		return $this->load_empty();
	}


	// Protected Methods

	protected function load_empty() {
		return $this->row = $this->rs->fetchObject();
	}

}
?>
