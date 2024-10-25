<?php
/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        CouponCtrl
 * GENERATION DATE:  2021-09-10
 * -------------------------------------------------------
  *
 */

class CouponCtrl extends CustomCtrl {
	protected $mod = 'Coupon';
	protected $class = 'Coupon';


	protected function run_default($args, $action) {
		switch ($action) {
			default:	$this->authorize('run_multiple', $args, "perm:{$this->mod_key}");
		}
	}

	protected function get_row($objects, $db_row, $arg1 = []) {
		return array(
				'',
				$objects->get_active(),

				$objects->get_code(),
				$objects->get_quantity(),
				$objects->get_discount(),
				$objects->get_user(),
				$objects->get_valid_products(),
				$objects->get_created(),
				$objects->get_expiration(),
				$objects->get_discount_limit(),
				$objects->get_use_per_user(),
				$objects->get_active(),
			);
	}

	protected function run_ajax_jqgrid($args = array(), $objects = false, $arg1 = [], $arg2 = []) {
		$args['searchfields'] = 'code';

		parent::run_ajax_jqgrid($args, $objects);
	}

	protected function run_single($object, $args = array()) {
		// temp
		$page_args = $users = array();

		/*
		$users = new User();
		$users->set_paging(1, 0, "`user` ASC");

		*/

		$page_args = array(
				'users' => $users,
			);

		$page_args = array_merge($args, $page_args);
		parent::run_single($object, $page_args);
	}

	protected function run_save($args = []) {
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
					'quantity' => $this->get_input('quantity', 0),
					'code' => $this->get_input('code', '', true),
					'discount' => $this->get_input('discount', 0),
					'user_id' => $this->get_input('user_id', 0),
					'valid_products' => $this->get_input('valid_products', '', true),
					'expiration' => $this->get_input('expiration', ''),
					'discount_limit' => $this->get_input('discount_limit', 0),
					'use_per_user' => $this->get_input('use_per_user', 0),
					'created' => $this->get_input('created', ''),
					'active' => $this->get_input('active', 0),
					'id' => $this->get_input('id', 0),
				);

			// validate required
			$error_fields = $this->validate_data($data, array(
					//'some_string' => array('string', false, 1),
					//'some_number' => array('num', false, 1),
				));

			$error = $this->missing_fields($error_fields);
			// $this->validate_email($data['email'], $error_fields, $error);

			$object = new $this->class($data['id']);
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_quantity($data['quantity']);
			$object->set_code($data['code']);
			$object->set_discount($data['discount']);
			$object->set_user_id($data['user_id']);
			$object->set_valid_products($data['valid_products']);
			$object->set_expiration($this->utl->date_format($data['expiration'], false, $this->app->db_date_format, $this->app->date_format));
			$object->set_discount_limit($data['discount_limit']);
			$object->set_use_per_user($data['use_per_user']);
			$object->set_created($this->utl->date_format($data['created'], false, $this->app->db_date_format, $this->app->date_format));
			$object->set_active($data['active']);

			$this->save($object, $error);

		} else {
			header('Location: ' . $this->app->go($this->app->module_key));
			exit;
		}
	}

	protected function run_export($args = []) {
		$version = array_shift($args);

		$objects = new $this->class();
		$filter = [];
		$objects->set_paging(1, 0, "`code` ASC", $filter);

		$header = array(
				$this->lng->text('coupon:quantity'),
				$this->lng->text('coupon:code'),
				$this->lng->text('coupon:discount'),
				$this->lng->text('coupon:user_id'),
				$this->lng->text('coupon:valid_products'),
				$this->lng->text('coupon:expiration'),
				$this->lng->text('coupon:discount_limit'),
				$this->lng->text('coupon:use_per_user'),
			);
		$headers = array($header);

		$rows = array();
		while($objects->list_paged()) {
			$row = array(
					$objects->get_quantity(),
					$objects->get_code(),
					$objects->get_discount(),
					$objects->get_user(),
					$objects->get_valid_products(),
					$objects->get_expiration(),
					$objects->get_discount_limit(),
					$objects->get_use_per_user(),
				);
	  		$rows[] = $row;
		}

		$objPHPExcel = $this->get_export_excel($this->lng->text('object:multiple'), $headers, $rows, array());
		$this->export_excel($objPHPExcel, strtolower($this->lng->text('object:multiple')), $this->lng->text('object:multiple'), $version);
	}

}
?>
