<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ProofDb
 * GENERATION DATE:  13.06.2014
 * -------------------------------------------------------
 *
 */


class ProofDb extends BaseDb {

	// Overrided Protected vars
	protected $table = 'proof';
	protected $primary = 'proof_id';

	protected $fields = array(
			'sale_product_id' => false, 'image_id' => false, 'version' => false, 'filename' => false,
			'newname' => false, 'size' => false, 'md5' => false, 'description' => false,
			'response' => false, 'status' => false, 'created' => false, 'active' => false,
		);


	public function retrieve_last($values = false, $active_only = true, $hide_deleted = true, $sql_parts = false) {
		$query = "SELECT *
					FROM `{$this->prefix}{$this->table}`
					WHERE `image_id` = ?
					ORDER BY `proof_id` DESC
					LIMIT 1;
				";
error_log($query);
//echo $query; //exit;
		$stmt = $this->db->prepare($query);
		$stmt->execute($values);
		return $stmt;
	}

}
?>
