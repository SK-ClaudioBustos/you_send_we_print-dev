<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        Session
 * GENERATION DATE:  02.10.2013
 * -------------------------------------------------------
 *
 */

class Session extends Base {

	// Protected Vars

	protected $dbClass = 'SessionDb';

	protected $session_key = '';
	protected $user_id = '';
	protected $time_limit = '';


	// Getters

	public function get_session_key() { return $this->session_key; }
	public function get_user_id() { return $this->user_id; }
	public function get_time_limit() { return $this->time_limit; }


	// Setters

	public function set_session_key($val) { $this->session_key = $val; }
	public function set_user_id($val) { $this->user_id = $val; }
	public function set_time_limit($val) { $this->time_limit = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->session_id);

			$this->set_session_key($row->session_key);
			$this->set_user_id($row->user_id);
			$this->set_time_limit($row->time_limit);
		}
		return $this->row = $row;
	}

}
?>
