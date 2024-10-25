<?php
class SMvcPropertyBag {
	private $vars = array();


	public function __set($index, $value) {
		$this->vars[$index] = $value;
	}

	public function __get($index) {
		if (array_key_exists($index, $this->vars)) {
			return $this->vars[$index];
		} else {
			return null;
		}
	}
}
?>
