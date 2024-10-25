<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        CouponCtrl
 * GENERATION DATE:  2021-02-09
 * -------------------------------------------------------
  *
 */

class CouponCtrl extends CustomCtrl {
	protected $mod = 'Coupon';
	protected $class = 'Coupon';


	protected function run_default($args, $action) {
		switch ($action) {
			case 'ajax_apply':	$this->run_ajax_apply($args);
		}
	}
	
	protected function run_ajax_apply ($args = []) {
		$data =  [
			'code' => $this->get_input('coupon', ''),
			'sale_id' => $this->get_input('sale_id', '')
		];

		$today = date('Y-m-d');
		$user_id = $this->app->user_id;

		$coupon = new Coupon();
		$coupon->retrieve_by('code', $data['code']);

		$sale = new Sale();
		$sale->retrieve($data['sale_id'], false);

		$response = [
			"valid" => 0,
			"msg" => $this->lng->text('coupon:invalid'),
			"discount" => 0
		];

	 	if ($coupon->get_id() &&
			$today > $coupon->get_created() && 
			$today < $coupon->get_expiration()) {
				$valid_p = json_decode($coupon->get_valid_products());
				$valid_u = json_decode($coupon->get_user_id());

				if (in_array($user_id, $valid_u) ||
				$valid_u == []) {
					$discount = 0;
					$product_ids = [];

					$sale_product = new SaleProduct();
					$sale_product->set_paging(1, 0, 0, "`sale_id` = {$data['sale_id']}");

					while ($sale_product->list_paged(false)) {
						$product_ids[] = $sale_product->get_id();

						if ((!$valid_p == [] && 
						in_array($sale_product->get_id(), $valid_p)) ||
						$valid_p == [] ) {
							$discount += ($sale_product->get_subtotal_discount() * $coupon->get_discount()) / 100;
						} 
					}
					
					if (!$valid_p == [] &&
					!in_array($sale_product->get_id(), $valid_p)) {
						# code...
					}

					$response['msg'] = $this->lng->text('coupon:valid');
					$response['valid'] = 1;
				}
		} else {
			$response['msg'] = $this->lng->text('coupon:expired');
		}
		echo json_encode($response);
	}
}
?>
