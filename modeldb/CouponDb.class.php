<?php

/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        CouponDb
 * GENERATION DATE:  2021-09-10
 * -------------------------------------------------------
 *
 */


class CouponDb extends BaseDb
{

	// Overrided Protected vars

	protected $table = 'coupon';
	protected $primary = 'coupon_id';

	protected $fields = [
		'quantity' => false, 'code' => false, 'discount' => false, 'user_id' => false,
		'valid_products' => false, 'expiration' => false, 'discount_limit' => false, 'use_per_user' => false,
		'created' => false, 'active' => false
	];

	public function check_running_promo ($date) {
		$query = "SELECT COUNT(*) 
		FROM `tbl_coupon` 
		WHERE `created` <= '{$date}' 
		AND `expiration` >= '{$date}' 
		AND `created` != '0000-00-00' 
		AND `expiration` != '0000-00-00'";

		$smtp = $this->db->prepare($query);
		$smtp->execute();
		$rows = $smtp->fetch();
		return $rows[0];
	}

	public function check_user_firt_coupon ($user_id) {
		$query = "SELECT `coupon_id` 
		FROM `tbl_coupon` 
		WHERE `user_id` like {$user_id} 
		AND `created` = '0000-00-00' 
		AND `expiration` = '0000-00-00'";

		$smtp = $this->db->prepare($query);
		$smtp->execute();
		$rows = $smtp->fetch();
		return $rows[0];
	}

	public function check_used_coupons ($user_id, $coupon_id) {
		$query = "SELECT COUNT(*) FROM `tbl_coupon_used` WHERE `user_id` = {$user_id} AND `coupon_id` = {$coupon_id}";

		$smtp = $this->db->prepare($query);
		$smtp->execute();
		$rows = $smtp->fetch();
		return $rows[0];
	}
}
