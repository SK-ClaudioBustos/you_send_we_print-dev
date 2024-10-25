<?php
class CartCtrl extends BaseCtrl {

	public function run($args) {
		$action = array_shift($args);

		// TODO: authorize methods?
		switch ($action) {
			case 'remove':				$this->run_remove($args); break;
			case 'checkout':			$this->run_checkout($args); break;
			case 'save':				$this->run_save($args); break;
			case 'done':				$this->run_done($args); break;
			case 'invoice': 			$this->run_invoice($args); break;
			case 'work_order': 			$this->run_work_order($args); break;

			case 'proof':				$this->run_proof($args); break;
			case 'upload': 				$this->run_upload($args); break;
			case 'download': 			$this->run_download($args); break;
			case 'upload_save': 		$this->run_upload_save($args); break;
			case 'upload_big': 			$this->run_upload_big($args); break;

			case 'ajax_approve': 		$this->run_ajax_approve($args); break;
			case 'ajax_confirm':		$this->run_ajax_confirm($args); break;
			case 'ajax_upload':		 	$this->run_ajax_upload($args); break;
			case 'ajax_remove': 		$this->run_ajax_remove($args); break;
			case 'ajax_rates': 			$this->run_ajax_rates($args); break;
			case 'ajax_taxes': 			$this->run_ajax_taxes($args); break;

			case 'paypal_complete':		$this->run_paypal_complete($args); break;
			case 'paypal_cancel': 		$this->run_paypal_cancel($args); break;

			case 'authorize_complete':	$this->run_authorize_complete($args); break;
			case 'authorize_cancel': 	$this->run_authorize_cancel($args); break;

			case 'ajax_confirmed':		$this->run_ajax_confirmed($args);
			case 'ajax_sale_total':		$this->run_ajax_sale_total($args);

			default:
				if ($action) {
					$this->run_not_found($args);
				} else {
					$this->run_default(array());
				}
		}
	}


	protected function run_default($args) {
		$this->run_cart($args);
	}


	protected function run_download($args) {
		// TODO: file_exist
		$section = array_shift($args);
		$folder = array_shift($args);
		$file = array_shift($args);
		$filename = $this->cfg->path->data . '/' . $section . '/' . $folder . '/' . $file;

		echo $this->tpl->get_view('cart/download', array('filename' => $filename));
	}

	protected function run_work_order($args) {
		if ($hash = array_shift($args)) {

			$sale = new Sale();
			$sale->retrieve_by('hash', $hash);

			if ($sale->get_id()) {
				$separate = (array_shift($args) == 'one');

				$sale_products = new SaleProduct();
				$sale_products->set_sale_id($sale->get_id());
				$sale_products->set_status('');
				$sale_products->set_paging(1, 0, '`sale_product_id` ASC');

				$wholesaler = new Wholesaler();
				$wholesaler->retrieve_by(array('user_id'), array($sale->get_user_id()));
				if ($wholesaler->get_id()) {
					// load shipping address for every product
					$sale_products->set_load_address(true);
				}
				$address_info = $this->get_address_info($sale, $wholesaler);

				$product = new Product();
				$item_arr = array();
				$item_array_list = [];

				$items = new Item();
				$items->set_paging(1, 0, '`item_id` ASC');
				while($items->list_paged()) {
					$item_arr[$items->get_id()] = $items->get_title();
					$temp_product_list = new ItemList();
					$temp_product_list->retrieve_by('item_list_key', $items->get_item_list_key());
					$item_array_list[$items->get_item_list_key()] = $temp_product_list->get_description();
				}

				$title = $this->lng->text('cart:work_order');
				$subtitle = $this->lng->text('checkout:done_subtitle');

				$invoice_address = nl2br($this->utl->get_property('invoice-info'));

				$page_args = array(
						'meta_title' => $title,
						'body_id' => 'body_work_order',
						'title' => $title,
						//'text' => $text,
						'invoice_address' => $invoice_address,
						'subtitle' => $subtitle,
						'sale' => $sale,
						'object' => $sale_products,
						'product' => $product,
						'items' => $item_arr,
						'item_array_list' => $item_array_list,
						'address_info' => $address_info,
						'separate' => $separate,
					);

				$page_args = array_merge($page_args, $this->tpl->get_view('cart/work_order', $page_args));
				$this->tpl->page_draw($page_args);

			} else {
				// nothing to do
				$this->app->redirect($this->app->go('Home'));
			}

		} else {
			// nothing to do
			$this->app->redirect($this->app->go('Home'));
		}
	}

	protected function run_invoice($args) {
		if ($hash = array_shift($args)) {

			$sale = new Sale();
			$sale->retrieve_by('hash', $hash);

			if ($sale->get_id()) {
				$sale_products = new SaleProduct();
				$sale_products->set_sale_id($sale->get_id());
				$sale_products->set_status('');
				$sale_products->set_paging(1, 0, '`sale_product_id` ASC');

				$wholesaler = new Wholesaler();
				$wholesaler->retrieve_by(array('user_id'), array($sale->get_user_id()));
				if ($wholesaler->get_id()) {
					// load shipping address for every product
					$sale_products->set_load_address(true);
				}
				$address_info = $this->get_address_info($sale, $wholesaler);

				$product = new Product();
				$item_arr = array();
				$item_array_list = [];

				$items = new Item();
				$items->set_paging(1, 0, '`item_id` ASC');
				while($items->list_paged()) {
					$item_arr[$items->get_id()] = $items->get_title();
					$temp_product_list = new ItemList();
					$temp_product_list->retrieve_by('item_list_key', $items->get_item_list_key());
					$item_array_list[$items->get_item_list_key()] = $temp_product_list->get_description();
				}

				$title = $this->lng->text('cart:invoice');
				$subtitle = $this->lng->text('checkout:done_subtitle');
				$date_sold = $this->utl->date_format($sale->get_date_sold(), $this->app->user->get_time_offset(), $this->app->date_format);

				$invoice_address = nl2br($this->utl->get_property('invoice-info'));

				$page_args = array(
						'meta_title' => $title,
						'body_id' => 'body_invoice',
						'title' => $title,
						'invoice_address' => $invoice_address,
						'subtitle' => $subtitle,
						'sale' => $sale,
						'date_sold' => $date_sold,
						'object' => $sale_products,
						'product' => $product,
						'items' => $item_arr,
						'item_array_list' => $item_array_list,
						'address_info' => $address_info,
					);

				$page_args = array_merge($page_args, $this->tpl->get_view('cart/invoice', $page_args));
				$this->tpl->page_draw($page_args);

			} else {
				// nothing to do
				$this->app->redirect($this->app->go('Home'));
			}

		} else {
			// nothing to do
			$this->app->redirect($this->app->go('Home'));
		}
	}

	protected function run_cart($args) {
		$added_id = false;
		if (isset($_SESSION['added'])) {
			$added_id = $_SESSION['added'];
			unset($_SESSION['added']);
		}

		$sale = new Sale();
		$sale_products = new SaleProduct();
		$items = new Item();
		$product = new Product();
		$item_arr = array();
		$item_array_list = [];
		$address_info = array();

		if ($_SESSION['sale_id']) {
			$sale->retrieve($_SESSION['sale_id'], false);

			$sale_products->set_sale_id($sale->get_id());
			$sale_products->set_status('');
			$sale_products->set_paging(1, 0, '`sale_product_id` ASC', array("`status` = 'st_added'"));

			$user = $this->app->user;
			$wholesaler = new Wholesaler();
			$wholesaler->retrieve_by(array('user_id', 'status'), array($user->get_id(), 'ws_approved'));
			if ($wholesaler->get_id()) {
				$sale_products->set_load_address(true);
			}
			$address_info = $this->get_address_info($sale, $wholesaler);

			$items->set_paging(1, 0, '`item_id` ASC');
			while($items->list_paged()) {
				$item_arr[$items->get_id()] = $items->get_title();
				$temp_product_list = new ItemList();
				$temp_product_list->retrieve_by('item_list_key', $items->get_item_list_key());
				$item_array_list[$items->get_item_list_key()] = $temp_product_list->get_description();
			}
		}

		$title = $this->lng->text('menu:cart');
		$body_id = 'body_cart';

		$page_args = array(
				'meta_title' => $title,
				'body_id' => $body_id,
				'title' => $title,
				'sale' => $sale,
				'object' => $sale_products,
				'product' => $product,
				'items' => $item_arr,
				'item_array_list' => $item_array_list,
				'added_id' => $added_id,
				'address_info' => $address_info,
			);

		$page_args = array_merge($page_args, $this->tpl->get_view('cart/cart', $page_args));
		$this->tpl->page_draw($page_args);
	}

	protected function run_done($args) {
		// show order
		if ($hash = array_shift($args)) {

			$new_sale = false;
			if (isset($_SESSION['new_sale']) && $_SESSION['new_sale'] == $hash) {
				$new_sale = true;
				unset($_SESSION['new_sale']);
			}

			$sale = new Sale();
			$sale->retrieve_by('hash', $hash);

			if ($sale->get_id()) {

//echo $sale->get_id();
//exit;
				$from_account = array_shift($args);

				// TODO: use filter
				$sale_products = new SaleProduct();
				$sale_products->set_sale_id($sale->get_id());
				$sale_products->set_status('');
				$sale_products->set_paging(1, 0, '`sale_product_id` ASC');

				$wholesaler = new Wholesaler();
				$wholesaler->retrieve_by('user_id', $sale->get_user_id());
				if ($wholesaler->get_id()) {
					// load shipping address for every product
					$sale_products->set_load_address(true);
				}
				$address_info = $this->get_address_info($sale, $wholesaler);

				$product = new Product();
				$item_arr = array();
				$item_array_list = [];

				$items = new Item();
				$items->set_paging(1, 0, '`item_id` ASC');
				while($items->list_paged()) {
					$item_arr[$items->get_id()] = $items->get_title();
					$temp_product_list = new ItemList();
					$temp_product_list->retrieve_by('item_list_key', $items->get_item_list_key());
					$item_array_list[$items->get_item_list_key()] = $temp_product_list->get_description();
				}

				if ($new_sale) {
					$title = $this->lng->text('done:new_title');
					$text = $this->lng->text('done:new_text');
				} else {
					$title = $this->lng->text('done:title');
					$text = $this->lng->text('done:text');
				}
//echo '003 >>> ' . $sale->get_date_sold() . ' | ' . $this->app->user->get_time_offset();
//echo date_default_timezone_get();
//echo ($offset = $this->app->user->get_time_offset()) ? $offset : false;
//exit;

				$subtitle = $this->lng->text('checkout:done_subtitle');
				$date_sold = $this->utl->date_format(
						$sale->get_date_sold(),
						($offset = $this->app->user->get_time_offset()) ? $offset : false,
						$this->app->datetime_format
					);

				$page_args = array(
						'meta_title' => $title,
						'body_id' => 'body_done',
						'title' => $title,
						'text' => $text,
						'subtitle' => $subtitle,
						'new_sale' => $new_sale,
						'sale' => $sale,
						'date_sold' => $date_sold,
						'object' => $sale_products,
						'product' => $product,
						'items' => $item_arr,
						'address_info' => $address_info,
						'item_array_list' => $item_array_list,
						//'added_id' => $added_id,
						'added_id' => '',
						'from_account' => $from_account,
					);

				$page_args = array_merge($page_args, $this->tpl->get_view('cart/checkout_done', $page_args));
				$this->tpl->page_draw($page_args);
			
				//destruyo la sesión porque sino al iniciar nueva compra, se engancha
        if (!isset($_SESSION['sale_id']) || $_SESSION['sale_id'] == ""){
    	    //si la sesión no es una compra nueva, no mantengo nada de lo que cargué para mostrar la orden. Sino se cruza con una nueva compra.
    		$hash = "";
            unset($sale);
            $_SESSION = array(array_key_first($_SESSION)=>array_shift($_SESSION)); //mantengo solo la sesión

        }

			} else {
				// nothing to do
				$this->app->redirect($this->app->go('Home'));
			}

		} else {
			// nothing to do
			$this->app->redirect($this->app->go('Home'));
		}
	}

	protected function run_proof($args) {
		if ($hash = array_shift($args)) {

			$sale = new Sale();
			$sale->retrieve_by('hash', $hash);

			if ($sale->get_id()) {
				$sale_product_id = (int)array_shift($args);
				$sale_product = new SaleProduct($sale_product_id);

				$items = new Item();
				$items->set_paging(1, 0, '`item_id` ASC');
				$item_arr = array();
				while($items->list_paged()) {
					$item_arr[$items->get_id()] = $items->get_title();
				}

				$product = new Product($sale_product->get_product_id());
				$title = $this->lng->text('proof:title');
				$date_sold = $this->utl->date_format($sale->get_date_sold(), $this->app->user->get_time_offset(), $this->app->datetime_format);
				$order = sprintf($this->lng->text('done:order_nro'), $sale->get_id(), $date_sold);

				// images
				$images = new Image();
				$images->set_paging(1, 0, '`image_id` ASC', array("`sale_product_id` = {$sale_product_id}"));
				$url_folder = '/image/sale/' . sprintf('%08s', $sale_product->get_sale_id());

				$img_proofs = $this->get_proofs($sale_product_id);

				$page_args = array(
						'meta_title' => $title,
						'title' => $title,
						'body_id' => 'body_upload',
						'order' => $order,
						'object' => $sale_product,
						'product' => $product,
						'items' => $item_arr,
						'images' => $images,
						'url_folder' => $url_folder,
						'sale_hash' => $hash,
						'proofs' => $img_proofs,
					);
				$page_args = array_merge($page_args, $this->tpl->get_view('cart/checkout_proof', $page_args));
				$this->tpl->page_draw($page_args);

			} else {
				// nothing to do
				$this->app->redirect($this->app->go('Home'));
			}

		} else {
			// nothing to do
			$this->app->redirect($this->app->go('Home'));
		}
	}


	protected function run_checkout($args) {
		if (isset($_SESSION['sale_id'])) {

			$tmp_msg = '';
			$tmp_var = 'tmp_' . strtolower($this->app->module_key);
			if (isset($_SESSION[$tmp_var])) {
				$tmp_msg = $_SESSION[$tmp_var . '_msg'];
				unset($_SESSION[$tmp_var . '_msg']);

				$sale = unserialize($_SESSION[$tmp_var]);
				unset($_SESSION[$tmp_var]);
				$error = true;

			} else {
				$sale = new Sale();
				$sale->retrieve($_SESSION['sale_id'], false);
			}

			if (isset($_SESSION['payment_error'])) {
				$tmp_msg = $_SESSION['payment_error'];
				unset($_SESSION['payment_error']);
			}

			$sale_products = new SaleProduct();
			$sale_products->set_sale_id($sale->get_id());
			$sale_products->set_status('');
			$sale_products->set_paging(1, 0, '`sale_product_id` ASC', array("`status` = 'st_added'"));

			if ($sale_products->list_count(false)) {

				$user = $this->app->user;
				$wholesaler = new Wholesaler();
				$wholesaler->retrieve_by(array('user_id', 'status'), array($user->get_id(), 'ws_approved'));
				if ($wholesaler->get_id()) {
					$sale_products->set_load_address(true);
				} else {
					// TODO: if not????
				}

				$address_info = $this->get_address_info($sale, $wholesaler, $error);
				$sale_bill_address = $address_info['sale_bill_address'];
				if ($wholesaler->get_id() && ($wholesaler->get_taxable() == 'tx_yes') && !$sale_bill_address->get_id()) {
					// calc taxes with default address
					$tax = $this->calc_tax($sale, $wholesaler->get_bill_zip());
					$sale->set_taxes($tax);
					$sale->update_total();
				}

				$product = new Product();

				$pp_token = $sale->get_id() . '-' . $this->utl->get_token(32);
				$_SESSION['paypal_token'] = $pp_token;

				$title = $this->lng->text('checkout:title');

				$years = array();
				$from = date('Y');
				for($i = $from; $i < $from + 10; $i++) {
					$years[] = $i;
				}

				// disclaimers
				$disclaimers = array();
				$main_disclaimer = new Document();
				$main_disclaimer->retrieve_by(array('section_key', 'featured'), array('disclaimer', 1));
				$disclaimers[(string)$main_disclaimer->get_id()] = array(
						'title' => $main_disclaimer->get_title(),
						'content' => $main_disclaimer->get_content(),
					);

				while($sale_products->list_paged(false)) {
					$product = new Product($sale_products->get_product_id());
					$disclaimer = new Document($product->get_disclaimer_id());
					$disclaimers[(string)$disclaimer->get_id()] = array(
							'title' => $disclaimer->get_title(),
							'content' => $disclaimer->get_content(),
						);
				}

				$today = date('Y-m-d');
				/*$coupon = new Coupon();
				$show_coupon = $coupon->check_running_promo($today);
				if (!$show_coupon) {
					$user_id = $this->app->user_id;
					$first_coupon_id = $coupon->check_user_firt_coupon($user_id);
					if ($first_coupon_id) {
						$used_first_coupon = $coupon->check_used_coupons($user_id, $first_coupon_id);
						$show_coupon = $used_first_coupon ?: $show_coupon;
					}
				}*/
				$items = new Item();
				$item_arr = [];
				$item_array_list = [];

				$items->set_paging(1, 0, '`item_id` ASC');
				while ($items->list_paged()) {
					$item_arr[$items->get_id()] = $items->get_title();
					$temp_product_list = new ItemList();
					$temp_product_list->retrieve_by('item_list_key', $items->get_item_list_key());
					$item_array_list[$items->get_item_list_key()] = $temp_product_list->get_description();
				}

				$page_args = array(
						'meta_title' => $title,
						'body_id' => 'body_checkout',

						'title' => $title,
						'error_msg' => $tmp_msg,
						'disclaimers' => $disclaimers,
						'sale' => $sale,
						'object' => $sale_products,
						'product' => $product,
						'address_info' => $address_info,
						'pp_token' => $pp_token,
						'item_number' => '10001',
						'item_array_list' => $item_array_list,

						//'show_coupon' => $show_coupon,
						'years' => $years,
						'months' => $this->lng->text('months'),
					);

				$page_args = array_merge($page_args, $this->tpl->get_view('cart/checkout', $page_args));
				$this->tpl->page_draw($page_args);

			} else {
				// no items
				$this->app->redirect($this->app->go('Cart'));

			}

		} else {
			// no sale
			$this->app->redirect($this->app->go('Cart'));

		}
	}

	protected function run_authorize_complete() {
		$authorize = new Authorize();
		$authorize->retrieve_by('sale_id', $_SESSION['sale_id']);

		if ($authorize->get_id()) {
			$this->close_sale();
		} else {
			// TODO: error message?
			$this->app->redirect($this->app->go('Cart/checkout'));
		}
	}

	protected function run_authorize_cancel() {
	}

	protected function run_paypal_complete() {
error_log('Paypal 001 >>> ');
		if ($_SESSION['paypal_token']) {
			$token = $_SESSION['paypal_token'];
error_log('Paypal 002 >>> ' . $token);
			unset($_SESSION['paypal_token']);

			// look for a 'Completed' transaction
			$paypal = new Paypal();
			$paypal->retrieve_completed($token);

			if ($paypal->get_id()) {
error_log('Paypal 003 >>> ');
				// mark as active
				$paypal->update_completed($token);

				$this->close_sale(); // redirect

			} else {
error_log('Paypal 004 >>> ');
				// no token
				// TODO: error message?
				$this->app->redirect($this->app->go('Cart/checkout'));
			}

		} else {
error_log('Paypal 005 >>> ');
			// no paypal transaction
			// TODO: error message?
			$this->app->redirect($this->app->go('Cart/checkout'));
		}

	}

	protected function run_paypal_cancel() {
	}

	protected function run_save($args) {
		// checkout save
		if ($this->get_input('action', '') == 'place_order') {
			$data = array(
					'billing_address'		=> $this->get_input('billing_address', 0),

					'bill_last_name'		=> $this->get_input('bill_last_name', '', true),
					'bill_address'			=> $this->get_input('bill_address', '', true),
					'bill_zip'				=> $this->get_input('bill_zip', '', true),
					'bill_city'				=> $this->get_input('bill_city', '', true),
					'bill_state'			=> $this->get_input('bill_state', '', true),
					'bill_phone'			=> $this->get_input('bill_phone', '', true),
					//'bill_email'			=> $this->get_input('bill_email', '', true),

					'payment_type'			=> $this->get_input('payment_type', 0),

					'name_card'				=> $this->get_input('name_card', '', true),
					'card_number'			=> $this->get_input('card_number', '', true),
					'exp_month'				=> $this->get_input('exp_month', '', true),
					'exp_year'				=> $this->get_input('exp_year', '', true),
					'sec_code'				=> $this->get_input('sec_code', '', true),

					'sale_id'				=> $this->get_input('sale_id', 0),
					'ajax'					=> $this->get_input('ajax', 0),
				);

			$object = new Sale();
			$sale_address = new SaleAddress();
			$error_fields = $error = array();

			if (!$data['ajax']) {
				if ($data['billing_address'] == $sale_address->address_ws_enum('new')) {
					$error_fields = $this->validate_data($data, array(
							'bill_last_name' 	=> array('string', false, 1),
							'bill_address' 		=> array('string', false, 1),
							'bill_zip' 			=> array('string', false, 1),
							'bill_city' 		=> array('string', false, 1),
							'bill_state' 		=> array('string', false, 1),
							//'bill_email' 		=> array('string', false, 1),
						));
				}

				if ($data['payment_type'] == $object->payment_type_enum('ccard')) {
					$error_fields = array_merge($error_fields, $this->validate_data($data, array(
							'name_card' 		=> array('string', false, 1),
							'card_number' 		=> array('string', false, 1),
							'exp_month' 		=> array('string', false, 1),
							'exp_year'	 		=> array('string', false, 1),
							'sec_code' 			=> array('string', false, 1),
						)));
				}

				$error = $this->missing_fields($error_fields);
			}

			$object->retrieve($data['sale_id'], false);
			$object->set_missing_fields($error_fields);

			// fill objects
			$object->set_user_id($this->app->user_id);
			$object->set_payment_type($data['payment_type']);

			$object->set_name_card($data['name_card']);
			$object->set_credit_card(($data['payment_type'] == $object->payment_type_enum('ccard')) ? 'XXXX-XXXX-XXXX-' . substr($data['card_number'], -4) : '');
			$object->set_card_number($data['card_number']);
			$object->set_exp_month($data['exp_month']);
			$object->set_exp_year($data['exp_year']);
			$object->set_sec_code($data['sec_code']);

			// hash for url
			if (!$object->get_hash()) {
				$object->set_hash(md5(uniqid(rand(), 1)));
			}

			$sale_bill_address = new SaleAddress();
			$sale_bill_address->retrieve_by_sale($data['sale_id'], $sale_bill_address->address_type_enum('bill'));

			$sale_bill_address->set_missing_fields($error_fields);

			$sale_bill_address->set_sale_id($data['sale_id']);
			$sale_bill_address->set_address_type($sale_bill_address->address_type_enum('bill'));
			$sale_bill_address->set_address_level($sale_bill_address->address_level_enum('sale'));
			$sale_bill_address->set_address_ws($data['billing_address']);

			// Wholesaler
			$user = $this->app->user;
			$wholesaler = new Wholesaler();
			$wholesaler->retrieve_by(array('user_id', 'status'), array($user->get_id(), 'ws_approved'));

			if ($data['billing_address'] == $sale_address->address_ws_enum('new')) {
				$sale_bill_address->set_last_name($data['bill_last_name']); // contact_name
				$sale_bill_address->set_address($data['bill_address']);
				$sale_bill_address->set_city($data['bill_city']);
				$sale_bill_address->set_state($data['bill_state']);
				$sale_bill_address->set_zip($data['bill_zip']);
				$sale_bill_address->set_phone($data['bill_phone']);
				//$sale_bill_address->set_email($data['bill_email']);
				$sale_bill_address->set_user_id($this->app->user_id);
				$sale_bill_address->set_active(1);

			} else {
				// wholesaler default address
				$sale_bill_address->copy_default_address($wholesaler);
				$sale_bill_address->set_user_id($this->app->user_id);
				$sale_bill_address->set_active(1);
			}

			if (sizeof($error)) {
				// error
				$error_msgs = $this->lng->all();
				$error_msg = preg_replace_callback(
					'#^([A-Z_]+)$#',
					function ($m) use ($error_msgs) {
						return (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];
					},
					$error
				);

				$object->set_bill_address(serialize($sale_bill_address));

				//if ($sale_ship_address) {
				if ($sale_address) {
					//$object->set_ship_address(serialize($sale_ship_address));
					$object->set_ship_address(serialize($sale_address));
					//$object->set_ship_info(serialize($sale_shipping));
					$object->set_ship_info(serialize($sale_address));
				}
				$tmp_var = 'tmp_' . strtolower($this->app->module_key);
				$_SESSION[$tmp_var] = serialize($object);
				$_SESSION[$tmp_var . '_msg'] = (sizeof($error)) ? implode('<br />', $error_msg) : '';

				if ($data['ajax']) {
					//return array('error' => $error, 'sale_bill_address_id' => $sale_bill_address->get_id(), 'sale_ship_address_id' => ($sale_ship_address) ? $sale_ship_address->get_id() : 0);
					return array('error' => $error, 'sale_bill_address_id' => $sale_bill_address->get_id(), 'sale_ship_address_id' => ($sale_address) ? $sale_address->get_id() : 0);

				} else {
					header('Location: ' . $this->app->go('Cart/checkout'));
					exit;
				}

			} else {
				// success
				$object->update();
				$sale_bill_address->update();

				/*if ($sale_ship_address) {
					$sale_ship_address->update();
					// set sale_product ship address
					$object->product_ship_address($sale_ship_address->get_id());

					if ($sale_ship_address->get_same_address() != $sale_ship_address->same_address_enum('local_pickup')) {
						$sale_shipping->update();
					}
				}*/
				if ($sale_address) {
					$sale_address->update();
					// set sale_product ship address
					$object->product_ship_address($sale_address->get_id());

					if ($sale_address->get_same_address() != $sale_address->same_address_enum('local_pickup')) {
						$sale_address->update();
					}
				}

				if ($data['ajax']) {
					//return array('sale_bill_address_id' => $sale_bill_address->get_id(), 'sale_ship_address_id' => ($sale_ship_address) ? $sale_ship_address->get_id() : 0);
					return array('sale_bill_address_id' => $sale_bill_address->get_id(), 'sale_ship_address_id' => ($sale_address) ? $sale_address->get_id() : 0);

				} else {
					header("Content-type: application/json");
					echo json_encode(array('success' => 1));
				}

			}

		} else {
			$this->app->redirect($this->app->go('Home'));

		}
	}


	protected function run_remove($args) {
		// remove job from cart/checkout
		if (isset($_SESSION['sale_id'])) {
			if ($sale_product_id = $this->get_input('id', 0)) {
				$sale_product = new SaleProduct();
				$sale_product->retrieve($sale_product_id, false);

				if ($sale_product->get_status() == 'st_added') {
					$result = $sale_product->delete($sale_product_id);

					$sale = new Sale();
					$sale->retrieve($_SESSION['sale_id'], false);
					$total = $sale->update_total();

					if ($ajax = array_shift($args)) {
						$return = array(
								'result' => $result,
								'items' => (int)$sale->item_count(),
								'subtotal' => ($total == null) ? 0.00 : $total,
								'shipping' => ($sale->get_shipping() == null) ? 0.00 : $sale->get_shipping(),
							);
						header("Content-type: application/json");
						echo json_encode($return);

					} else {
						$this->app->redirect($this->app->go($this->app->module_key));
					}

				} else {
					error_log('Remove from cart - Invalid status: ' . $sale_product->get_status() . ' sale_product_id = ' . $sale_product->get_id());
					if ($ajax = array_shift($args)) {
						echo 0; // TODO: if invalid status, it should return some code
					} else {
						$this->app->redirect($this->app->go($this->app->module_key));
					}
				}
			}

		} else {
			error_log('Remove from cart - No sale_product_id');
			if ($ajax = array_shift($args)) {
				echo 0; // TODO: if not sale_product_id, it should return some code
			} else {
				$this->app->redirect($this->app->go($this->app->module_key));
			}
		}
	}


	// Upload -----------------------------------------------------

	protected function run_upload($args) {
		if ($hash = array_shift($args)) {
			$sale = new Sale();
			$sale->retrieve_by('hash', $hash);

			if ($sale->get_id()) {
				$sale_product_id = (int)array_shift($args);
				$sale_product = new SaleProduct($sale_product_id);

				if ($sale_product->get_id()) {
					if ($sale_product->get_status() == 'st_new') {

						$items = new Item();
						$items->set_paging(1, 0, '`item_id` ASC');

						$item_arr = array();
						$item_array_list = [];

						while($items->list_paged()) {
							$item_arr[$items->get_id()] = $items->get_title();
							$temp_product_list = new ItemList();
							$temp_product_list->retrieve_by('item_list_key', $items->get_item_list_key());
							$item_array_list[$items->get_item_list_key()] = $temp_product_list->get_description();
						}

						$product = new Product($sale_product->get_product_id());
						$title = $this->lng->text('product:upload');
						$date_sold = $this->utl->date_format($sale->get_date_sold(), $this->app->user->get_time_offset());

						// images
						$images = new Image();
						$images->set_paging(1, 0, '`image_id` ASC', array("`sale_product_id` = {$sale_product_id}"));
						$url_folder = '/image/sale/' . sprintf('%08s', $sale_product->get_sale_id());

						$agree = 0;
						if (isset($_SESSION['agree']) || $images->list_count()) {
							$agree = 1;
						}

						$page_args = array(
								'meta_title' => $title,
								'body_id' => 'body_upload',
								'title' => $title,
								'object' => $sale_product,
								'sale' => $sale,
								'date_sold' => $date_sold,
								'product' => $product,
								'items' => $item_arr,
								'item_array_list' => $item_array_list,
								'images' => $images,
								'url_folder' => $url_folder,
								'sale_hash' => $hash,
								'agree' => $agree,
							);

						$page_args = array_merge($page_args, $this->tpl->get_view('cart/upload', $page_args));
						$this->tpl->page_draw($page_args);

					} else {
						// other status, not available for upload
						$this->app->redirect($this->app->go('Cart/done', false, '/' . $hash));
					}

				} else {
					// invalid id
					$this->app->redirect($this->app->go('Cart/done', false, '/' . $hash));
				}

			} else {
				// invalid hash
				$this->app->redirect($this->app->go('Home'));
			}

		} else {
			// no hash
			$this->app->redirect($this->app->go('Home'));
		}
	}

	protected function run_upload_save($args) {
		if ($sale_product_id = (int)array_shift($args) && $this->get_input('action', '') == 'upload') {
			$data = array(
					'sale_hash'		=> $this->get_input('sale_hash', ''),
					'agree'			=> $this->get_input('agree', 0),

					'image_id'		=> $this->get_input('image_id', array( 0 )),
					'quantity'		=> $this->get_input('quantity', array( 0 )),
					'description'	=> $this->get_input('description', array( '' ), true),
					'image_order'	=> $this->get_input('image_order', 0), // TODO:
				);

			if (sizeof($data['image_id'])) {
				for($i = 0; $i < sizeof($data['image_id']); $i++) {
					$image = new Image($data['image_id'][$i]);
					$image->set_quantity($data['quantity'][$i]);
					$image->set_description($data['description'][$i]);
					$image->set_image_order($i);
					$image->update();
				}
			}

			$_SESSION['agree'] = $data['agree'];

			$this->app->redirect($this->app->go('Cart/done', false, '/' . $data['sale_hash']));

		} else {
			// nothing to do
			$this->app->redirect($this->app->go('Home'));
		}
	}

	protected function run_upload_big($args) {
		if ($product_key = array_shift($args)) {
			if (isset($_SESSION[$product_key])) {
				$body = $this->tpl->get_view('cart/upload_big');

				$this->tpl->page_draw(array(
						'meta_title' => $this->lng->text('product:upload_big_title'),
						'body_id' => 'body_upload',
						'body' => $body,
					));
			} else {
				// nothing to do
				$this->app->redirect($this->app->go('Home'));
			}
		} else {
			// nothing to do
			$this->app->redirect($this->app->go('Home'));
		}
	}


	// Ajax -----------------------------------------------------

	protected function run_ajax_confirm($args) {
		// send job to production
		if ($hash = array_shift($args)) {
			$sale = new Sale();
			$sale->retrieve_by('hash', $hash);

			if ($sale->get_id() && $sale_product_id = (int)array_shift($args)) {
					$sale_product = new SaleProduct($sale_product_id);

					// calculate turnaround
					$sale_product->set_date_confirm(date($this->app->db_datetime_format));
					if ($sale_product->get_proof()) {
						$sale_product->set_status('st_wait_proof');
						$sale_product->set_status_customer('st_wait_proof');
						$sale_product->update();

						$this->notify_team('proof_waiting', $sale, $sale_product);

					} else {
						$turnaround = explode('/', $sale_product->get_turnaround_detail());
						$sale_product->set_status('st_confirmed');
						$sale_product->set_status_customer('st_confirmed');
						$date_due = $this->calc_due_date($sale_product->get_date_confirm(), $turnaround[0]);
						$sale_product->set_date_due($date_due);
						$sale_product->update();

						$this->notify_team('work_order', $sale, $sale_product);
					}

					header("Content-type: application/json");
					echo json_encode(array('proof' => (int)$sale_product->get_proof(), 'date_due' => $date_due));

			} else {
				echo 'error';
			}
		} else {
			echo 'error';
		}
	}

	protected function run_ajax_upload($args) {
		$image_upload = new FileUpload();
		$image_upload->set_field('file_data');

		if ($image_upload->is_uploaded()) {
			$sale_id = $this->get_input('sale_id', 0);
			$sale_product_id = $this->get_input('sale_product_id', 0);
			$folder = $this->cfg->path->data . '/sale/' . sprintf('%08d', $sale_id);

			$filename = $image_upload->get_original_name();
			$image_size = $image_upload->get_size();

			$image = new Image();
			$image->set_sale_product_id($sale_product_id);
			$image->set_filename($filename);
			$image->set_size($image_size);
			$image->set_active(1);
			$image->set_quantity(1); // TODO:
			$image_id = $image->update();

			$image_name = sprintf('%08d', $sale_product_id) . '_' . sprintf('%08d', $image_id);

			$image_upload->set_extensions($this->cfg->setting->upl_extensions);
			$image_upload->set_folder($folder);
			$image_upload->set_filename($image_name);

			$filename = (strlen($filename) > 30) ? substr($filename, 0, 28) . '&hellip;' : $filename;

			if (!$image_upload->save(true)) {
				echo $image_upload->get_error(); // << Ver
			} else {
				$image->set_newname($image_name . '.' . $image_upload->get_extension());
				$image->set_md5($image_upload->get_md5());
				$repeated = $image->verify_md5();
				$image->update();

				$url_folder = '/image/sale/' . sprintf('%08s', $sale_id);
				// return the image snippet
				echo $this->tpl->get_view('cart/upload_item', array(
						'image' => $image,
						'url_folder' => $url_folder,
					));
			}
		} else {
			//echo '1'; // << Ver
		}

		unset($image_upload);
	}

	protected function run_ajax_remove($args) {
		if ($image_id = $this->get_input('image_id', 0)) {
			$image =  new Image();
			$image->delete($image_id);
			echo 'ok';
		} else {
			echo 'error';
		}
	}


	protected function run_ajax_approve($args) {
		// proof approve/reject
		if (isset($_POST['approved']) && ($hash = array_shift($args))) {
			$sale = new Sale();
			$sale->retrieve_by('hash', $hash);

			if ($sale->get_id()) {
				$sale_product_id = array_shift($args);

				$approved = $this->get_input('approved', false);
				$response = $this->get_input('response', '', true);

				$proof_id = array_shift($args);
				$proof = new Proof($proof_id);
				$proof->set_status(($approved) ? 'approved' : 'rejected');
				$proof->set_response($response);
				$proof->update();

				if ($approved) {
					$image = new Image($proof->get_image_id());
					$image->set_approved(1);
					$image->update();
				}

				$sale_product = new SaleProduct($sale_product_id);
				if ($sale_product->get_id() && ($sale_product->get_sale_id() == $sale->get_id())) {
					if (!$approved) {
						// update status
						$sale_product->set_status('st_wait_proof');
						$sale_product->set_status_customer('st_wait_proof');
						$status = 'Rejected';

						$sale_product->update();

					} else if ($sale_product->all_proof_approved()) {
						// update status
						$sale_product->set_status('st_confirmed');
						$sale_product->set_status_customer('st_confirmed');
						$sale_product->set_date_confirm(date('Y-m-d H:i:s'));
						$status = 'Approved';

						$turnaround = explode('/', $sale_product->get_turnaround_detail());
						$date_due = $this->calc_due_date($sale_product->get_date_confirm(), $turnaround[0]);
						$sale_product->set_date_due($date_due);

						$sale_product->update();
					}
					$result = array('success' => 1);

					$this->notify_team('proof_approving', $sale, $sale_product, $status);

				} else {
					$result = array('error' => 'Invalid sale_product ' . $sale_product_id);
				}

			} else {
				$result = array('error' => 'Invalid hash');
			}

		} else {
			$result = array('error' => 'No data');
		}

		header("Content-type: application/json");
		echo json_encode($result);
	}

	protected function run_ajax_taxes($args) {
		if (isset($_SESSION['sale_id'])) {
			// save data
			$form_data = json_decode(stripslashes($_REQUEST['form_data']), true);
			unset($_REQUEST['form_data']);
			foreach ($form_data as $field) {
				$_REQUEST[$field['name']] = $field['value'];
			}
			$_REQUEST['ajax'] = 1;
//print_r($_REQUEST);
//exit;

			$data = $this->run_save($args); // return $addresses

			$user = $this->app->user;
			$wholesaler = new Wholesaler();
			$wholesaler->retrieve_by(array('user_id', 'status'), array($user->get_id(), 'ws_approved'));

			$sale = new Sale();
			$sale->retrieve($_SESSION['sale_id'], false);

			if ($wholesaler->get_id() && ($wholesaler->get_taxable() != 'tx_yes')) {
				$tax = 0;
				$sale->set_taxes($tax);
				$sale->set_total($sale->get_subtotal() + $sale->get_shipping() + $tax);
				$sale->update();

				$data['taxes'] = $tax;
				$data['total'] = $sale->get_total();

			} else if ($zip = $this->get_input('zip_code', '')) {
				if(($zip == 'empty') || preg_match('/^\d{5}$/', $zip)) {
					if ($zip == 'empty') {
						$tax = 0;

					} else {
						$tax = $this->calc_tax($sale, $zip);

					}

					$sale->set_taxes($tax);
					$sale->set_total($sale->get_subtotal() + $sale->get_shipping() + $tax);
					$sale->update();

					$data['taxes'] = $tax;
					$data['total'] = $sale->get_total();

				} else {
					$data['error'] = 'Invalid zip';
				}

			} else {
				$data['error'] = 'No zip';
			}


		} else {
			$data = array(
					'error' => 'No sale_id',
				);
		}

		header("Content-type: application/json");
		echo json_encode($data);
	}

	protected function run_ajax_rates($args) {
		if (isset($_SESSION['sale_id'])) {
			// save data
			$form_data = json_decode(stripslashes($_POST['form_data']), true);
			unset($_POST['form_data']);
			foreach ($form_data as $field) {
				$_POST[$field['name']] = $field['value'];
			}
			$_POST['ajax'] = 1;

			$data = $this->run_save($args); // return $addresses

			if (isset($_POST['sel_rate'])) {
				$sel_rate = $this->get_input('sel_rate', '');
				$this->set_rate($sel_rate);

			} else {
				$sale = new Sale();
				$sale->retrieve($_SESSION['sale_id'], false);

				$sale_shipping = new SaleShipping();
				$sale_shipping->retrieve_by('sale_id', $sale->get_id());

				if ($zip_code = $this->get_input('zip_code', '')) {

					// get rates
					$rate = new RocketShipRate('UPS');
					$rate->setParameter('toCode', $zip_code);
					$rate->setParameter('residentialAddressIndicator', '0');

					if ($sale->get_total_weight() <= 150) { // package limit
						$rate->setParameter('weight', $sale->get_total_weight());

					} else {
						// distribute packages
						$pack_150 = (int)($sale->get_total_weight() / 150);
						$pack_last = $sale->get_total_weight() % $pack_150;

						for ($i = 1; $i <= $pack_150; $i++) {
							$package = new RocketShipPackage('UPS');
							$package->setParameter('weight', 150);
							$rate->addPackageToShipment($package);
						}

						if ($pack_last)	{
							$package = new RocketShipPackage('UPS');
							$package->setParameter('weight', $pack_last);
							$rate->addPackageToShipment($package);
						}
					}

					$data = array();

					// local delivery
					if (in_array($zip_code, $this->app->local_zips)) {
						$cost = new Cost();
						$cost->retrieve_by('cost_key', 'local-delivery-cost');
						$data[$this->lng->text('checkout:local_delivery')] = $cost->get_value();
					}

					try {
						$response = $rate->getSimpleRates();
					} catch (\Throwable $th) {
						error_log($th);
						$response['error'] = 'Shipping Service is down';
					}

					if (array_key_exists('error', $response)) {
						$data = array(
								'error' => $response['error'],
								'rates' => false
							);

					} else {
						// convert back to old format
						$response2 = array();
						foreach($response as $key => $item) {
							$response2[$key] = $item['Rate'];
						}
						// --------------------------

						$data = array(
								'error' => false,
								'rates' => array_merge($data, $response2),
							);
					}

					header("Content-type: application/json");
					echo json_encode($data);

				} else {
					$data = array(
							'error' => 'No zip_code',
							'rates' => false,
						);
					header("Content-type: application/json");
					echo json_encode($data);
				}

				// save rate options
				$sale_shipping->set_shipping_types(($data['rates']) ? json_encode($data['rates']) : '{}');
				$sale_shipping->update();

			}

		} else {
			$data = array(
					'error' => 'No sale_id',
					'rates' => false,
				);
			header("Content-type: application/json");
			echo json_encode($data);
		}

	}


	// private methods

	private function close_sale() {
error_log('close_sale sale_id: ' . $_SESSION['sale_id']);
		// success
		$sale = new Sale();
		$sale->retrieve($_SESSION['sale_id'], false);

		$sale->set_active(1); // using active for 'st_new'
		$sale->set_status('st_new');
		$sale->set_date_sold(date('Y-m-d H:i:s'));
		$sale->update();

		// update products
		$sale_products = new SaleProduct();
		$sale_products->activate($sale->get_id(), $sale->get_date_sold());

		// discount stock - TODO: move to function
		$sale_products->set_status('');
		$sale_products->set_paging(1, 0, '`sale_product_id` ASC', array("`sale_id` = {$sale->get_id()}", "`status` = 'st_new'"));

		while($row = $sale_products->list_stock()) {
			if ($row->use_stock) {
				if ($row->stock >= $sale_products->get_quantity()) {
					$stock = $this->update_stock($sale_products, $sale_products->get_quantity(), $row->stock);

					if ($stock <= $row->stock_min) {
						// notify
						$recipient_mail = $this->utl->get_property('stock-mail');
						$recipient_name = $this->utl->get_property('stock-name');

						$views = $this->tpl->get_view('_email/stock_min', array(
								'recipient_name' => $recipient_name,
								'product' => $row->product,
								'stock_min' => $row->stock_min,
								'sale_id' => $sale->get_id(),
								'item_id' => $sale_products->get_id(),
							));
						$body = $this->tpl->get_view('_layouts/email', $views);

						$this->utl->notify(array(
								'to' => array($recipient_mail => $recipient_name),
								'subject' => $views['subject'],
								'body' => $body
							));
					}

				} else {
					// no available stock, discount available and inform
					$stock = $this->update_stock($sale_products, $row->stock, $row->stock);
					$diff = $sale_products->get_quantity() - $row->stock;

					// notify
					$recipient_mail = $this->utl->get_property('stock-mail');
					$recipient_name = $this->utl->get_property('stock-name');

					$views = $this->tpl->get_view('_email/stock_not_enough', array(
							'recipient_name' => $recipient_name,
							'product' => $row->product,
							'diff' => $diff,
							'sale_id' => $sale->get_id(),
							'item_id' => $sale_products->get_id(),
						));
					$body = $this->tpl->get_view('_layouts/email', $views);

					$this->utl->notify(array(
							'to' => array($recipient_mail => $recipient_name),
							'subject' => $views['subject'],
							'body' => $body
						));
				}
			}
		}

		// purchase permalink
		$url = $this->app->go('Cart/done', false, '/' . $sale->get_hash());

		// notify user
		$user = $this->app->user;
		$wholesaler = new Wholesaler();
		$wholesaler->retrieve_by(array('user_id', 'status'), array($user->get_id(), 'ws_approved'));

error_log('close_sale notify ' . $wholesaler->get_email());

		if ($wholesaler->get_id()) {
			$recipient_name = $wholesaler->get_full_name();
			$recipient_email = $wholesaler->get_email();

		} else {
			$sale_bill_address = new SaleAddress();
			$sale_bill_address->retrieve_by_sale($_SESSION['sale_id'], $sale_bill_address->address_type_enum('bill'));
			$recipient_name = $sale_bill_address->get_last_name();
			$recipient_email = $sale_bill_address->get_email();
		}


		$views = $this->tpl->get_view('_email/checkout', array(
				'recipient_name' => $recipient_name,
				'url' => $url,
				'sale_id' => $sale->get_id(),
			));
		$body = $this->tpl->get_view('_layouts/email', $views);

		$this->utl->notify(array(
				'to' => array($recipient_email => $recipient_name),
				'subject' => $views['subject'],
				'body' => $body
			));

		// destroy session sale
		$_SESSION = array(array_key_first($_SESSION)=>array_shift($_SESSION)); //dejo solo el id de sesión para que no se cierre, el resto limpio.
		$hash = "";
        unset($sale);
        $sale = "";
        error_log('close_sale redirect: ' . $url);
		$this->app->redirect($url);
	}

	private function notify_team($view, $sale, $sale_product, $status = '') {
		$job_url = $this->cfg->setting->blixflow . '/sales/edit/' . $sale_product->get_id();
		$wo_url = $this->app->go('Cart/work_order', false, '/' . $sale->get_hash());

		$views = $this->tpl->get_view('_email/' . $view, array(
				'job_url' => $job_url,
				'wo_url' => $wo_url,
				'sale_product_id' => $sale_product->get_id(),
				'sale_id' => $sale->get_id(),
				'status' => $status,
			));
		$body = $this->tpl->get_view('_layouts/email', $views);

		$recipients = $this->utl->get_property('notify-team');
		if (sizeof($recipients)) {
			$this->utl->notify(array(
					'to' => $recipients,
					'subject' => $views['subject'],
					'body' => $body
				));
		}
	}

	private function set_rate($sel_rate) {
		$sel_cost = $this->get_input('sel_cost', '');

		$sale = new Sale();
		$sale->retrieve($_SESSION['sale_id'], false);

		$sale->set_shipping($sel_cost);
		$sale->set_total($sale->get_subtotal() + $sale->get_shipping() + $sale->get_taxes());
		$sale->update();

		header("Content-type: application/json");
		echo json_encode(array('total' => $sale->get_total()));
	}

	private function calc_tax($sale, $zip) {
		$tax_zip = new TaxZip();
		$tax_zip->retrieve_by('zip', $zip);

		if ($tax_zip->get_id()) {
			// FL zip found
			$cost = new Cost();
			$cost->retrieve_by('cost_key', 'florida-tax');

			//Se cambio porque daba más del total permitido (¿?)
			//$tax = $sale->get_subtotal() * ($cost->get_value() + $tax_zip->get_tax()) / 100;
			$tax = $sale->get_subtotal() * ($cost->get_value()) / 100;

		} else {
			// no FL zip, no tax
			$tax = 0;
		}

		return $tax;
	}

	private function update_stock($sale_product, $quantity, $stock) {
		$datetime = date($this->app->db_datetime_format);
		$balance = $stock - $quantity;

		// add move
		$text = sprintf($this->lng->text('sale:stock_text'), $sale_product->get_sale_id(),
				'<a href="/sales/edit/' . $sale_product->get_id() . '">', $sale_product->get_id(), '</a>');
		$stock_move = new StockMove();
		$stock_move->set_user_id($this->app->user->get_id()); // TODO: anonymous
		$stock_move->set_created($datetime);
		$stock_move->set_product_id($sale_product->get_product_id());
		$stock_move->set_concept('other');
		$stock_move->set_concept_other($text);
		$stock_move->set_quantity(-$quantity);
		$stock_move->set_balance($balance);
		$stock_move->update();

		// update stock
		$stock = new Stock();
		$stock->retrieve_by('product_id', $sale_product->get_product_id());
		if ($stock->get_id()) {
			$stock->set_last_update($datetime);
			$stock->set_stock($balance);
			$stock->update();
		} else {
			error_log('Stock for product ' . $sale_product->get_product_id() . ' not available!');
		}
		return $balance;
	}

	private function get_address_info($sale, $wholesaler, $error = false) {
		// Wholesaler
		$user = $this->app->user;

		$other_addresses = new UserAddress();
		$shipping_types = false;
		$rates_url = $this->app->go($this->app->module_key, false, '/ajax_rates');
		$taxes_url = $this->app->go($this->app->module_key, false, '/ajax_taxes');

		$default_bill_address = '';
		if ($wholesaler->get_id()) {
			$other_addresses->set_user_id($user->get_id());
			$default_bill_address = $wholesaler->get_full_name() . ' - '
					. $wholesaler->get_bill_address() . ' - '
					. $wholesaler->get_bill_city() . ', ' . $wholesaler->get_bill_state() . ' ' . $wholesaler->get_bill_zip() . ' - '
					. 'Ph ' . $wholesaler->get_bill_phone();
		}

		if ($error) {
			$sale_bill_address = unserialize($sale->get_bill_address());

			$sale_ship_address = new SaleAddress();
			if (!$wholesaler->get_id()) {
				$sale_ship_address = unserialize($sale->get_ship_address());

				if ($sale_ship_address->get_same_address() != $sale_ship_address->same_address_enum('local_pickup')) {
					$sale_shipping = unserialize($sale->get_ship_info());

					if ($sale_shipping->get_shipping_types()) {
						$shipping_types = stripslashes($sale_shipping->get_shipping_types());
					}
				} else {
					$sale_shipping = new SaleShipping();
					$sale_shipping->retrieve_by('sale_id', $sale->get_id());
				}
			}
		} else {
			$sale_bill_address = new SaleAddress();
			$sale_bill_address->retrieve_by_sale($sale->get_id(), $sale_bill_address->address_type_enum('bill'));
			if (!$sale_bill_address->get_id()) {
				$sale_bill_address->set_address_ws($sale_bill_address->address_ws_enum('default'));
			}

			$sale_ship_address = new SaleAddress();
			$sale_shipping = new SaleShipping();
			if (!$wholesaler->get_id()) {
				// ShipAddress by sale
				$sale_ship_address->retrieve_by_sale($sale->get_id(), $sale_ship_address->address_type_enum('ship'));
				// if it doesn't exist, set it as ship anyway
				if (!$sale_ship_address->get_id()) {
					$sale_ship_address->set_address_type($sale_ship_address->address_type_enum('ship'));
					$sale_ship_address->set_same_address($sale_ship_address->same_address_enum('local_pickup')); // local pickup
				}

				$sale_shipping->retrieve_by('sale_id', $sale->get_id());
				if ($sale_shipping->get_shipping_types()) {
					$shipping_types = stripslashes($sale_shipping->get_shipping_types());
				}

			}
		}

		$address_info = array(
				'wholesaler' => $wholesaler,
				'default_bill_address' => $default_bill_address,
				'other_addresses' => $other_addresses,
				'user' => $user,
				'sale_bill_address' => $sale_bill_address,
				'sale_ship_address' => $sale_ship_address,
				'sale_shipping' => $sale_shipping,
				'shipping_types' => $shipping_types,
				'rates_url' => $rates_url,
				'taxes_url' => $taxes_url,
			);

		return $address_info;
	}

	private function calc_due_date($date, $turnaround) {
		$date_due = $this->utl->date_add_biz_days($date, $turnaround, $this->app->holidays[date('Y')], $this->app->cutoff_time);
		return $date_due;
	}

	private function get_proofs($sale_product_id) {
		$images = new Image();
		$images->set_paging(1, 0, '`image_id` ASC', array("`sale_product_id` = {$sale_product_id}"));

		$img_proofs = array();

		while($images->list_paged()) {
			$img_proofs[(string)$images->get_id()] = array();

			$proofs = new Proof();
			$proofs->set_paging(1, 1,
					array('`proof_id` DESC'),
					array("`image_id` = {$images->get_id()}")
				);

			while($proofs->list_paged()) {
				$img_proofs[(string)$images->get_id()] = $proofs->to_array();
			}
		}

		return $img_proofs;
	}

	protected function run_ajax_confirmed ($args){
		$paypal = new New_paypal();
		$paypal->retrieve_by('sale_id', $_SESSION['sale_id']);
		if ($paypal->get_id()) {
			$this->close_sale();
		} else {
			$this->app->redirect($this->app->go('Cart/checkout'));
		}
	}

	protected function run_ajax_sale_total ($args){
		$sale = new Sale($_SESSION['sale_id']);
		echo $sale->get_total();
	}

}
?>