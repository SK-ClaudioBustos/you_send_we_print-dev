<?phpphp
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        ReportDb
 * GENERATION DATE:  2017-01-13
 * -------------------------------------------------------
 *
 */


class ReportDb extends BaseDb {

	// Overrided Protected vars

	protected $table = 'transaction';
	protected $has_active = false;
	protected $has_deleted = true;


	// Public Methods

	// headers -----------------------------------------------------------------------

	public function list_header($object, $level, $reference_id, $ancestor_id) {
		$from = "`tbl_transaction`
					INNER JOIN `tbl_point` `PT` USING(`point_id`)
					INNER JOIN `tbl_chain` `CH` USING(`chain_id`)
					INNER JOIN `tbl_state` `ST` USING(`state_id`)
					INNER JOIN `tbl_region` `RG` USING(`region_id`)
				";

		switch($level) {
			case 4: // point
				$sql_parts = array(
						'select' => "DISTINCT `PT`.`point_id` AS `id`,
										`PT`.`point` AS `label`
									",
						'from' => $from,
						'where' => array(
										"`chain_id` = {$reference_id}",
										"`state_id` = {$ancestor_id}"
									),
					);
				break;

			case 3: // chain
				$sql_parts = array(
						'select' => "DISTINCT `CH`.`chain_id` AS `id`,
										`CH`.`chain` AS `label`
									",
						'from' => $from,
						'where' => array("`state_id` = {$reference_id}"),
					);
				break;

			case 2: // state
				$sql_parts = array(
						'select' => "DISTINCT `ST`.`state_id` AS `id`,
										`ST`.`state` AS `label`
									",
						'from' => $from,
						'where' => array("`region_id` = {$reference_id}"),
					);
				break;

			case 1: // region
				$sql_parts = array(
						'select' => "DISTINCT `RG`.`region_id` AS `id`,
										`RG`.`region` AS `label`
									",
						'from' => $from,
						'where' => array(),
					);
				break;

			default: // total, never here
		}

		return parent::list_paged($object, true, true, $sql_parts);
	}


	// -------------------------------------------------------------------------

	// total
	public function list_transactions($object, $level, $reference_id, $ancestor_id, $filter) {
		$sum = "SUM(`quantity_a`) AS `quantity_a`,
					SUM(`quantity_b`) AS `quantity_b`,
					SUM(`ytdate_a`) AS `ytdate_a`,
					SUM(`ytdate_b`) AS `ytdate_b`
				";
		$from = "`tbl_transaction`
					INNER JOIN `tbl_point` `PT` USING(`point_id`)
					INNER JOIN `tbl_chain` `CH` USING(`chain_id`)
					INNER JOIN `tbl_state` `ST` USING(`state_id`)
					INNER JOIN `tbl_region` `RG` USING(`region_id`)

					LEFT OUTER JOIN (
							SELECT `point_id`,
									`quantity_a` AS `ytdate_a`,
									`quantity_b` AS `ytdate_b`
							FROM `tbl_transaction`
							WHERE {$filter}
						) `YT` USING(`point_id`)
				";


		switch($level) {
			case 4: // point
				$sql_parts = array(
						'select' => "`PT`.`point_id` AS `id`, {$sum}",
						'from' => $from,
						'group' => "`PT`.`point`",
						'where' => array(
										"`chain_id` = {$reference_id}",
										"`state_id` = {$ancestor_id}"
									),
					);
				break;

			case 3: // chain
				$sql_parts = array(
						'select' => "`CH`.`chain_id` AS `id`, {$sum}",
						'from' => $from,
						'group' => "`CH`.`chain_id`",
						'where' => array("`state_id` = {$reference_id}"),
					);
				break;

			case 2: // state
				$sql_parts = array(
						'select' => "`ST`.`state_id` AS `id`, {$sum}",
						'from' => $from,
						'group' => "`ST`.`state_id`",
						'where' => array("`region_id` = {$reference_id}"),
					);
				break;

			case 1: // region
				$sql_parts = array(
						'select' => "`RG`.`region_id` AS `id`, {$sum}",
						'from' => $from,
						'group' => "`RG`.`region_id`",
						'where' => array(),
					);
				break;

			default: // total
				$sql_parts = array(
						'select' => "0 AS `id`, {$sum}",
						'from' => $from,
						'where' => array(),
					);
		}

		return parent::list_paged($object, true, true, $sql_parts);
	}

}
?>
