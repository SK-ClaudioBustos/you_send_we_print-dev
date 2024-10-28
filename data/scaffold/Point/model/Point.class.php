<?
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Point
 * GENERATION DATE:  2018-01-23
 * -------------------------------------------------------
 *
 */

class Point extends Base {

	// Protected Vars

	protected $dbClass = 'PointDb';

	protected $point = '';
	protected $chain_id = '';
	protected $manager_id = '';
	protected $leader_id = '';
	protected $state_id = '';

	protected $chain = '';
	protected $manager = '';
	protected $leader = '';
	protected $state = '';


	// Getters

	public function get_string() { return $this->point; }

	public function get_point() { return $this->point; }
	public function get_chain_id() { return $this->chain_id; }
	public function get_manager_id() { return $this->manager_id; }
	public function get_leader_id() { return $this->leader_id; }
	public function get_state_id() { return $this->state_id; }

	public function get_chain() { return $this->chain; }
	public function get_manager() { return $this->manager; }
	public function get_leader() { return $this->leader; }
	public function get_state() { return $this->state; }


	// Setters

	public function set_point($val) { $this->point = $val; }
	public function set_chain_id($val) { $this->chain_id = $val; }
	public function set_manager_id($val) { $this->manager_id = $val; }
	public function set_leader_id($val) { $this->leader_id = $val; }
	public function set_state_id($val) { $this->state_id = $val; }

	public function set_chain($val) { $this->chain = $val; }
	public function set_manager($val) { $this->manager = $val; }
	public function set_leader($val) { $this->leader = $val; }
	public function set_state($val) { $this->state = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->point_id);

			$this->set_point($row->point);
			$this->set_chain_id($row->chain_id);
			$this->set_manager_id($row->manager_id);
			$this->set_leader_id($row->leader_id);
			$this->set_state_id($row->state_id);
			$this->set_created($row->created);
			$this->set_active($row->active);

			$this->set_chain($row->chain);
			$this->set_manager($row->manager);
			$this->set_leader($row->leader);
			$this->set_state($row->state);
		}
		return $this->row = $row;
	}

}
?>
