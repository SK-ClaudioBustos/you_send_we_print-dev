<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        SessionDb
 * GENERATION DATE:  02.10.2013
 * -------------------------------------------------------
 *
 */


class SessionDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'session';
	protected $primary = 'session_id';

	protected $has_active = false;
	protected $has_deleted = false;

	protected $fields = array(
			'session_key' => false, 'user_id' => false, 'time_limit' => false,
		);


}
?>
