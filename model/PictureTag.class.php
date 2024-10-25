<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        PictureTag
 * GENERATION DATE:  2018-06-20
 * -------------------------------------------------------
 *
 */

class PictureTag extends Base {

	// Protected Vars

	protected $dbClass = 'PictureTagDb';

	protected $picture_tag = '';


	// Getters

	public function get_string() { return $this->picture_tag; }

	public function get_picture_tag() { return $this->picture_tag; }


	// Setters

	public function set_picture_tag($val) { $this->picture_tag = $val; }


	// Public Methods


	// Protected Methods

	protected function load() {
		if ($row = $this->rs->fetchObject()) {
			$this->set_id($row->picture_tag_id);

			$this->set_picture_tag($row->picture_tag);
			$this->set_active($row->active);
		}
		return $this->row = $row;
	}

}
?>
