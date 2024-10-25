<?php
class SMvcDatabase {
	private $instance = NULL;
	private $prefix = '';
	private $database = '';


	// Getters

	public function get_prefix() { return $this->prefix; }
	public function get_instance() { return $this->instance; }
	public function get_database() { return $this->database; }


	public function connect($database, $user, $password, $host = 'localhost', $prefix = '') {
		try {
			$this->database = $database;
			$this->instance = new PDO(
					"mysql:host=" . $host . ";dbname=" . $database,
					$user,
					$password,
					array(
							PDO::ATTR_EMULATE_PREPARES, false,
							PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						)
				);
			$this->prefix = $prefix;
			return $this->instance;

		} catch (PDOException $e) {
			print "Error: " . $e->getMessage() . "<br/>";
			die();
		}
	}

	private function __clone(){
	}
}
?>