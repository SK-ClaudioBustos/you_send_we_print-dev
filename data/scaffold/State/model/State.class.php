<?
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        State
 * GENERATION DATE:  2018-01-23
 * -------------------------------------------------------
 *
 */

class State extends Base {

	// Protected Vars

	protected $dbClass = 'StateDb';

	protected $state = '';
	protected $region_id = '';

	protected $region = '';


	// Getters

	public function get_string() { return $this->state; }

	public function get_state() { return $this->state; }
	public function get_region_id() { return $this->region_id; }

	public function get_region() { return $this->region; }


	// Setters

	public function set_state($val) { $this->state = $val; }
	public function set_region_id($val) { $this->region_id = $val; }

	public function set_region($val) { $this->region = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->state_id);

			$this->set_state($row->state);
			$this->set_region_id($row->region_id);
			$this->set_created($row->created);
			$this->set_active($row->active);

			$this->set_region($row->region);
		}
		return $this->row = $row;
	}

}
?>
