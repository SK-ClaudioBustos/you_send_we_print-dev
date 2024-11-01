<?php
class ProductCtrl extends CustomCtrl
{

	public function run($args = [])
	{
		$action = explode('?', $args[0])[0];
		switch ($action) {
			case 'save':
				$this->run_save($args);
				break;

			case 'ajax_totals':
				$this->run_ajax_totals($args);
				break;
			case 'ajax_rates':
				$this->run_ajax_rates($args);
				break;
			case 'ajax_update':
				$this->run_ajax_update($args);
				break;
			case 'ajax_list':
				$this->run_ajax_list();
				break;
			case 'ajax_search':
				$this->run_ajax_search();
				break;
			case 'group':
				$this->run_group($args);
				break;

			default:
				$this->run_default($args);
		}
	}



	protected function run_ajax_update($args = array())
	{
		// keeps session alive
		echo 1;
	}

	protected function run_group($args)
	{
		$product_key = $args[1];
		$product_key = explode('?', $product_key)[0];

		if (is_numeric($product_key)) {
			//$product_key is ID
			$product = new Product((int) $product_key);
			$this->app->redirect($this->app->go('Product/group', 'en', '/' . $product->get_product_key()));
		} else {
			$product = new Product();
			$product->retrieve_by('product_key', $product_key);
		}

		$this->run_default([
			0			=> $product->get_product_key(),
			"group"		=> true,
			"id"		=> $product->get_id()
		]);
	}

	protected function run_default($args = [], $action = [])
	{
		$product_key = array_shift($args);
		$product_key = explode('?', $product_key)[0];

		$group = false;
		$group_id = 0;
		if (isset($args['group'])) {
			$group = array_shift($args);
			$group_id = array_shift($args);
		}

		$country = new Country();
		$country->set_paging(1, 0, "`country` ASC");
		$countries = [];
		$countries['44'] = 'United States of America';
		while ($country->list_paged()) {
			$countries[$country->get_id()] = $country->get_string();
		}

		$product = new Product();
		$product->retrieve_by('product_key', $product_key);

		if (!$product->get_id()) {
			// product doesn't exist or it's disabled - TODO: not found
			$this->app->redirect($this->app->go('Home'));
		} else {
			$product->set_base_price($product->get_base_price() + $product->get_setup_fee());
			$parent = new Product($product->get_parent_id());

			$this->app->group = $parent->get_title();
			$this->app->current = $product_key;

			// Sale in process?
			$sale_id = 0;
			$sale_product_id = 0;
			if ($child_key = explode('?', array_shift($args))[0]) {
				$session_key = $child_key;
			} else {
				$session_key = $product_key;
			}
			if (isset($_SESSION[$session_key])) {
				$sale_product_id = $_SESSION[$session_key];
			}
			if (isset($_SESSION['sale_id'])) {
				$sale_id = $_SESSION['sale_id'];
			}

			if ($child_key != 'intro') {
				$info = $this->get_product_info();
			}

			$sale_product = new SaleProduct($sale_product_id);

			// detail
			$detail = array();
			if ($sale_product->get_detail()) {
				$detail = $sale_product->get_detail();
			}

			// Wholesaler
			$ws_info = $this->get_ws_info($sale_product);

			// minimum
			$minimum = new Cost();
			$minimum->retrieve_by('cost_key', 'minimum');
			$min_total = (float)$minimum->get_value();
			//$this->app->minimum = $min_total; // TODO: set as body var
			$this->app->minimum = number_format($min_total, 2); // TODO: set as body var
			if (!$sale_product_id) {
				$sale_product->set_subtotal_discount($min_total);
			}

			// quantity discounts
			$discounts = array();
			if ($product->get_discounts()) {
				$discounts = explode("\n", $product->get_discounts()); // 1/n/5
			}
			$info['discounts']['discounts'] = $discounts;

			// turnaround
			// 1-10/5,4,3
			// array('min' => 1, 'max' => 10, array(5 => 0, 4 => +10, 3 => +25 ));
			$turnaround_lines = array();
			$turnarounds = array();
			if ($product->get_turnarounds()) {
				$turnaround_lines = explode("\n", $product->get_turnarounds());

				foreach ($turnaround_lines as $line) {
					list($range, $days) = explode('/', $line);

					$range = explode('-', $range);
					$days = explode(',', $days);

					$turnarounds[] = array('min' => $range[0], 'max' => $range[1], 'days' => $days);
				}
			}
			$info['turnaround']['turnarounds'] = $turnarounds;
			$info['discounts']['closed'] = false;

			$std_types = array('standard', 'std-ctm', 'shirts');

			if ($product->get_standard_type() == 'unit') {
				$info['discounts']['closed'] = true;
			}

			if ($product->get_product_type() == 'product-multiple' || 				$product->get_product_type() == 'group') {
				if ($child_key) {
					// subproduct
					$child = new Product();
					$child->retrieve_by('product_key', $child_key);

					if ($child->get_id()) {
						if ($child->get_minimum() > 0) {
							$min_total = (float)$child->get_minimum();
							$this->app->minimum = $min_total; // TODO: set as body var
							if (!$sale_product_id) {
								$sale_product->set_subtotal_discount($min_total);
							}
						}

						$title = $product->get_title();
						$subtitle = $child->get_title();
						$meta_title = $child->get_meta_title() ?: $subtitle;
						$parent_url = $this->app->go($this->app->module_key, false, '/' . $product->get_product_key());

						$gallery = $this->get_gallery($child->get_id(), $product->get_id());

						$attach = $child->get_attachment();
						$attach_path = $this->cfg->url->data . '/artspec/' . sprintf('%06d', $child->get_id()) . '/';

						$info['discounts']['closed'] = true;

						if (in_array($product->get_measure_type(), array('standard', 'fixd-fixd', 'ctm-fixd'))) { // << 'std-ctm', 'std-fixd' not?
							// use discounts for fixed quantities, override parent discounts
							$discounts = array();
							if ($child->get_discounts()) {
								$discounts = explode("\n", $child->get_discounts()); // 1/n/5
							}
							$info['discounts']['discounts'] = $discounts;
						}
						$sizes_arr = false;
						if (in_array($product->get_measure_type(), $std_types)) {
							// uses parent measure_type
							if ($product->get_measure_type() == 'shirts')
								$sizes_arr = $this->load_sizes($child->get_id(), true);
							else
								$sizes_arr = $this->load_sizes($child->get_id());
						}

						$item_lists = new ItemList();
						$item_lists->set_paging(1, 0, '`item_list_key` ASC');
						$item_lists = $item_lists->list_paged_array();

						$lists = $this->get_lists($product->get_id());
						$item_cuts = $this->get_cutting_list($product->get_form(), $lists);

						$form = $this->get_form($product, array(
							'detail' => $detail,
							'lists' => $lists,
							'item_lists' => $item_lists,
							'item_cuts' => $item_cuts,
							'info' => $info,
							'object' => $sale_product,
							'product' => $child,
							'parent' => $product,
							'measure_type' => $product->get_measure_type(),
							'sizes' => $sizes_arr,
							'wholesaler' => $ws_info,
							'countries' => $countries,
						));

						$page_args = array(
							//'meta_title' => $subtitle,
							'meta_title' => $meta_title,
							'meta_description' => $child->get_meta_description(),
							'meta_keywords' => $child->get_meta_keywords(),
							'body_id' => 'body_product',

							'title' => $title,
							'subtitle' => $subtitle,
							'parent_url' => $parent_url,

							'object' => $sale_product,
							'product' => $child,
							'parent' => $product,

							'gallery' => $gallery,
							'attach' => $attach,
							'attach_path' => $attach_path,

							'sale_id' => $sale_id,
							'sale_product_id' => $sale_product_id,
							'minimum' => $minimum,

							'item_lists' => $item_lists,
							'item_cuts' => $item_cuts,	// << move to form

							'form' => $form,
						);

						$views = $this->tpl->get_view('product/product', $page_args);
						$page_args = array_merge($page_args, $views);
						$this->tpl->page_draw($page_args);
					} else {
						// subproduct doesn't exist
						$this->run_not_found();
						exit;
					}
				} else {
					// product-multiple ie Retractable Displays
					$children = new Product();
					$group_url = "";
					if (!$group) {
						$children->set_parent_id($product->get_id());
					} else {
						$product_group = new ProductGroup();
						$product_group->set_paging(1, false, false, ["`group_id` = {$group_id}"]);
						$ids = [];
						while ($product_group->list_paged()) {
							$ids[] = $product_group->get_product_id();
						}
						$sql_filter = "`product_id` in (";
						foreach ($ids as $id) {
							$sql_filter .= "{$id},";
						}
						$sql_filter = substr($sql_filter, 0, -1);
						$sql_filter .= ") and `active`= 1 and `deleted`=0";
						$children->set_paging(1, false, '`product_order` ASC', [$sql_filter]);

						$user_type = 'visitor';
						if ($this->app->wholesaler_ok) {
							$user_type = 'wholesaler';
						}
						$slides = [];
						$tmp = strtolower($product->get_title());
						$tmp = str_replace(" ", "_", $tmp);
						$base_url = $this->cfg->url->data . '/subhome/' . $tmp;
						$base_dir = $_SERVER['DOCUMENT_ROOT'] . '/data/subhome/' . $tmp;
						try {
							$tmp_slides = scandir($base_dir);
						} catch (\Throwable $th) {
							$tmp_slides = false;
							error_log($th);
						}

						$tmp_url = $this->utl->get_property('group_url', array());

						$group_url = isset($tmp_url[$tmp]) ? $tmp_url[$tmp] : "";

						if ($tmp_slides) {
							foreach ($tmp_slides as $file) {
								if ($file == "." || $file == ".." || $file == "subpromos")
									continue;

								$slides[] = $base_url . '/' . $file;
							}
						}

						$slide_speed = $this->utl->get_property('home_slideshow_speed', 6000);
					}



					$title = $product->get_title();

					$page_args = array(
						'meta_title' => $title,
						'meta_description' => $product->get_meta_description(),
						'meta_keywords' => $product->get_meta_keywords(),
						'body_id' => 'body_product',

						'title' => $title, 'subtitle' => false,
						'object' => $product,
						'children' => $children,
					);

					$group ? $page_args['group'] = true : '';
					$group ? $page_args['group_url'] = $group_url : '';
					$group ? $page_args['slides'] = $slides : '';
					$group ? $page_args['slide_speed'] = $slide_speed : '';

					$views = $this->tpl->get_view('product/products', $page_args);
					$page_args = array_merge($page_args, $views);
					$this->tpl->page_draw($page_args);
				}
			} else {
				// product-single ie Outdoor Vinyl Banners
				if ($child_key == 'intro') {
					if ($product_key == 'compare-all') {
						// Compare All
						$this->product_compare($product);
					} else {
						// Intermediate page
						$this->product_intro($product);
					}
				} else {
					$title = $product->get_title();
					$gallery = $this->get_gallery($product->get_id());

					if ($product->get_minimum() > 0) {
						$min_total = (float)$product->get_minimum();
						$this->app->minimum = $min_total; // TODO: set as body var
						if (!$sale_product_id) {
							$sale_product->set_subtotal_discount($min_total);
						}
					}

					$attach = $product->get_attachment();
					$attach_path = $this->cfg->url->data . '/artspec/' . sprintf('%06d', $product->get_id()) . '/';

					$sizes_arr = array();
					if (in_array($product->get_measure_type(), $std_types)) { // 'fixed',
						if ($product->get_measure_type() == 'shirts')
							$sizes_arr = $this->load_sizes($product->get_id(), true);
						else
							$sizes_arr = $this->load_sizes($product->get_id());
					}

					$packaging = array(
						'' => $this->lng->text('product:pack_choose'),
						'price_0' => $this->lng->text('product:price_0'),
						'price_b' => $this->lng->text('product:price_b'),
						'price_c' => $this->lng->text('product:price_c'),
					);

					$item_lists = new ItemList();
					$item_lists->set_paging(1, 0, '`item_list_key` ASC');
					$item_lists = $item_lists->list_paged_array();

					$lists = $this->get_lists($product->get_id());
					$item_cuts = $this->get_cutting_list($product->get_form(), $lists);
					$form = $this->get_form($product, array(
						'detail' => $detail,
						'lists' => $lists,
						'item_lists' => $item_lists,
						'item_cuts' => $item_cuts,
						'info' => $info,
						'object' => $sale_product,
						'product' => $product,
						'measure_type' => $product->get_measure_type(),
						'sizes' => $sizes_arr,
						'packaging' => $packaging,
						'wholesaler' => $ws_info,
						'countries' => $countries,
					));

					$page_args = array(
						'meta_title' => $title,
						'meta_description' => $product->get_meta_description(),
						'meta_keywords' => $product->get_meta_keywords(),
						'body_id' => 'body_product',

						'title' => $title,
						'subtitle' => false,

						'object' => $sale_product,
						'product' => $product,

						'gallery' => $gallery,
						'attach' => $attach,
						'attach_path' => $attach_path,

						'sale_id' => $sale_id,
						'sale_product_id' => $sale_product_id,
						'minimum' => $minimum,
						'wholesaler' => $ws_info,

						'item_lists' => $item_lists,
						'item_cuts' => $item_cuts,	// << move to form

						'form' => $form,
					);

					$views = $this->tpl->get_view('product/product', $page_args);
					$page_args = array_merge($page_args, $views);
					$this->tpl->page_draw($page_args);
				}
			}
		}
	}


	protected function run_save($args = [])
	{
		if ($this->get_input('action', '') == 'edit') {
			$data = array(
				'product_key'		=> $this->get_input('product_key', '', true),
				'product_id'		=> $this->get_input('product_id', 0),
				'parent_id'			=> $this->get_input('parent_id', 0),
				'closed'			=> $this->get_input('closed', 0),

				'quantity'			=> $this->get_input('quantity', 1),
				'measure_unit'		=> $this->get_input('measure_unit', 'ctm'), // used for std/ctm
				'measure_type'		=> $this->get_input('measure_type', ''), // used for std/ctm
				// if 'size' is provided, width and height are taken from size object
				'width'				=> $this->get_input('width', 0.00),
				'height'			=> $this->get_input('height', 0.00),

				// cutting
				'cutting'			=> $this->get_input('cutting', 0),

				'shape'				=> $this->get_input('shape', ''),
				'size'				=> $this->get_input('size', 0),
				'shape_front'				=> $this->get_input('shape_front', ''),
				'size_front'				=> $this->get_input('size_front', 0),
				'shape_back'				=> $this->get_input('shape_back', ''),
				'size_back'				=> $this->get_input('size_back', 0),

				'sides'				=> $this->get_input('sides', 0),
				'orientation'		=> $this->get_input('orientation', ''),

				// accesories
				'accesory1'			=> $this->get_input('accesory1', 0),
				'accesory1_qty'		=> $this->get_input('accesory1_qty', 0),
				'accesory2'			=> $this->get_input('accesory2', 0),
				'accesory2_qty'		=> $this->get_input('accesory2_qty', 0),
				'accesory3'			=> $this->get_input('accesory3', 0),
				'accesory3_qty'		=> $this->get_input('accesory3_qty', 0),

				'turnaround'		=> $this->get_input('turnaround', 0),
				'turnaround_calc'	=> $this->get_input('turnaround_calc', 0),
				'turnaround_days'	=> $this->get_input('turnaround_days', 0),

				'packaging'			=> $this->get_input('packaging', ''),
				'proof'				=> $this->get_input('proof', 0),

				// shipping wholesaler
				'shipping_address'	=> $this->get_input('shipping_address', 0),
				'sale_address_id'	=> $this->get_input('sale_address_id', 0),
				'ship_other'		=> $this->get_input('ship_other', 0),

				'ship_last_name'	=> $this->get_input('ship_last_name', '', true),
				'ship_address'		=> $this->get_input('ship_address', '', true),
				'ship_zip'			=> $this->get_input('ship_zip', ''),
				'ship_city'			=> $this->get_input('ship_city', '', true),
				'ship_state'		=> $this->get_input('ship_state', '', true),
				'ship_phone'		=> $this->get_input('ship_phone', '', true),

				'zip_code'			=> $this->get_input('zip_code', ''),
				'shipping_type'		=> $this->get_input('shipping_type', '', true),
				//

				'job_name'			=> $this->get_input('job_name', '', true),

				'path'				=> $this->get_input('path', '', true),
				'id'				=> $this->get_input('id', 0),
				'sale_id'			=> $this->get_input('sale_id', 0),
				'ajax'				=> $this->get_input('ajax', 0),

				'isBillable'		=> $this->get_input('isBillable', 0),
				'bill_last_name'	=> $this->get_input('bill_last_name', '', true),
				'bill_address'		=> $this->get_input('bill_address', '', true),
				'bill_country'		=> $this->get_input('bill_country', '', true),
				'bill_zip'			=> $this->get_input('bill_zip', '', true),
				'bill_city'			=> $this->get_input('bill_city', '', true),
				'bill_state'		=> $this->get_input('bill_state', '', true),

			);
			//print_r($data);
			//exit;

			if ($data['measure_unit'] == 'std') {
				$error_fields = $this->validate_data($data, array(
					'quantity' 		=> array('num', false, 1),
				));
			} else {
				$error_fields = $this->validate_data($data, array(
					'quantity' 		=> array('num', false, 1),
					'width' 		=> array('num', false, 1),
					'height' 		=> array('num', false, 1),
				));
			}

			if (!$data['isBillable']) {
				$error_bill_fields = $this->validate_data($data, array(
					'bill_last_name' 	=> array('string', false, 1),
					'bill_address' 		=> array('string', false, 1),
					'bill_country' 		=> array('string', false, 1),
					'bill_zip' 			=> array('string', false, 1),
					'bill_city' 		=> array('string', false, 1),
					'bill_state' 		=> array('string', false, 1),
				));
			}

			if (isset($error_fields) && isset($error_bill_fields)) {
				$error_fields = array_merge($error_fields, $error_bill_fields);
			} else if (isset($error_bill_fields)) {
				$error_fields = $error_bill_fields;
			}

			$user = $this->app->user;
			$product = new Product($data['product_id']);

			$wholesaler = new Wholesaler();
			//$wholesaler->retrieve_by(array('user_id', 'status'), array($user->get_id(), 'ws_approved'));
			$wholesaler->retrieve_by(array('user_id'), array($user->get_id()));

			if (!$data['isBillable']) {
				$wholesaler->set_last_name($data['bill_last_name']);
				$wholesaler->set_bill_address($data['bill_address']);
				$wholesaler->set_bill_country($data['bill_country']);
				$wholesaler->set_bill_zip($data['bill_zip']);
				$wholesaler->set_bill_city($data['bill_city']);
				$wholesaler->set_bill_state($data['bill_state']);
				$wholesaler->update();
			}

			if (isset($_SESSION[$data['product_key']])) {
				$sale_product_id = $_SESSION[$data['product_key']];
				$sale_product = new SaleProduct();
				$sale_product->retrieve($sale_product_id, false);

				// TODO: sale_id from the form?
				$sale_id = $sale_product->get_sale_id();
				$sale = new Sale();
				$sale->retrieve($sale_id, false);
			} else {
				if (isset($_SESSION['sale_id'])) {
					$sale = new Sale();
					$sale->retrieve($_SESSION['sale_id'], false);
				} else {
					$sale = new Sale();
					$sale->set_user_id($user->get_id());
					$sale->set_wholesaler_id($wholesaler->get_id());
					$sale->set_source('yswp');

					$sale->update();
				}
				$sale_product = new SaleProduct();
				$sale_product->set_sale_id($sale->get_id());
			}

			$sale_address = false;
			$sale_shipping = new SaleShipping();

			$sale_address = new SaleAddress($data['sale_address_id']);
			$sale_product->set_sale_address_id($data['sale_address_id']);

			if ($data['shipping_address'] == $sale_address->address_ws_enum('new')) {
				$error_address = $this->validate_data($data, array(
					'ship_last_name' 	=> array('string', false, 1),
					'ship_address' 		=> array('string', false, 1),
					'ship_zip' 			=> array('string', false, 1),
					'ship_city' 		=> array('string', false, 1),
					'ship_state' 		=> array('string', false, 1),
				));

				if (!$data['ajax']) {
					$error_fields = array_merge($error_fields, $error_address);
				}
			}

			$error = $this->missing_fields($error_fields);

			$sale_product->set_missing_fields($error_fields);

			// fill the object
			$sale_product->set_product_id($data['product_id']);
			$sale_product->set_product_key($data['product_key']);
			$sale_product->set_product($product->get_title());
			$this->get_product_price($data, $product, $sale_product, $wholesaler, $sale_shipping);

			$this->save($sale_product, $sale, $error, $data, $wholesaler, $sale_address, $sale_shipping, $product->get_stock());
		} else {
			header('Location: /');
			exit;
		}
	}



	// Ajax -----------------------------------------------------

	protected function run_ajax_totals($args)
	{
		// TODO: verify expired session
		if ($this->app->user_id) {
			$form_data = json_decode(stripslashes($_POST['form_data']), true);
			if (!is_array($form_data)) {
				echo 0;
				die;
			}
			unset($_REQUEST['form_data']);
			foreach ($form_data as $field) {
				$_REQUEST[$field['name']] = $field['value'];
			}
			$_REQUEST['ajax'] = 1;
			$this->run_save($args);
		}
	}


	protected function run_ajax_rates($args)
	{
		if ($this->app->user_id && isset($_SESSION['sale_id'])) {
			if ($zip_code = array_shift($args)) {

				$sale = new Sale($_SESSION['sale_id']);

				// save data
				$form_data = json_decode(stripslashes($_POST['form_data']), true);
				unset($_POST['form_data']);
				foreach ($form_data as $field) {
					$_POST[$field['name']] = $field['value'];
				}
				$_POST['ajax'] = 1;

				$this->run_save($args);

				// get rates
				$response = [];
				try {
					$rate = new RocketShipRate('UPS');

					$rate->setParameter('toCode', $zip_code);
					$rate->setParameter('weight', $sale->get_total_weight());
					$rate->setParameter('residentialAddressIndicator', '0');
					$response = $rate->getSimpleRates();
				} catch (\Throwable $th) {
					error_log('API Problem');
					error_log($th);
					$response['error'] = 'API Problem';
				}

				$rates = array();

				// local delivery
				if (in_array($zip_code, $this->app->local_zips)) {
					$cost = new Cost();
					$cost->retrieve_by('cost_key', 'local-delivery-cost');
					$rates[$this->lng->text('checkout:local_delivery')] = $cost->get_value();
				}


				if (array_key_exists('error', $response)) {
					$rates = array(
						'error' => $response['error'],
						'rates' => false
					);
				} else {
					// convert back to old format
					$response2 = array();
					foreach ($response as $key => $item) {
						$response2[$key] = $item['Rate'];
					}
					// --------------------------

					$rates = array(
						'error' => false,
						'rates' => array_merge($rates, $response2),
					);
				}
			} else {
				$rates = array(
					'error' => 'No zip_code',
					'rates' => false,
				);
			}
		} else {
			$rates = array(
				'error' => 'No user_id or sale_id',
				'rates' => false,
			);
		}

		echo json_encode($rates);
	}



	// private functions ---------------------------------------------

	private function load_sizes($product_id, $no_sort = false)
	{
		$sizes_arr = array();
		$sizes = new Size();
		if ($no_sort) {
			$sizes->set_paging(1, 0, "`format` ASC", array("`product_id` = {$product_id}"));
		} else {
			$sizes->set_paging(1, 0, "`format` ASC, `width` ASC, `height` ASC", array("`product_id` = {$product_id}"));
		}

		$sizes_arr = array();
		$format = '';
		while ($sizes->list_paged()) {
			if ($format != $sizes->get_format()) {
				$format = $sizes->get_format();
				$sizes_arr[$format] = array();
			}
			$sizes_arr[$format][] = $sizes->to_array();
		}

		return $sizes_arr;
	}

	private function get_form(Product $product, $form_info)
	{
		$form = '';
		$form_info['dinamyc_title'] = '';
		$features = array();

		$views = json_decode($product->get_form(), true);
		//print_r($lists);
		//exit;
		$form .= $this->tpl->get_view('product/field3/header', $form_info);

		if (is_array($views) && sizeof($views)) {
			foreach ($views as $view) {
				if ($view['field'] == 'features') {
					$features = $view['options'];
				} else {
					$view_info = array_merge($form_info, $view);
					$field = explode('-', $view['field']);
					$field = $field[0]; // remove idx if exists

					if ($field == 'product_list') {
						$temp_product_list = new ItemList();
						$temp_product_list->retrieve_by('item_list_key', $view_info['option']);
						$view_info['dinamyc_title'] = $temp_product_list->get_description();
					}

					$form .= $this->tpl->get_view('product/field3/field_' . $field, $view_info);
				}
			}
		}

		$form .= $this->tpl->get_view('product/field3/footer', array_merge($form_info, array('features' => $features)));

		return $form;
	}

	private function get_cutting_list($product_form, $lists)
	{
		$views = json_decode($product_form, true);

		$has_cut = $first_list = false;
		$item_cuts = array();

		if (is_array($views) && sizeof($views)) {
			foreach ($views as $view) {
				$field = explode('-', $view['field']);
				$field = $field[0]; // remove idx if exists

				if ($field == 'cutting') {
					$has_cut = true;
				} else if (!$first_list && $field == 'product_list') {
					$first_list = $view['option'];
				}
			}
		}

		if ($has_cut) {
			// get cut options for every item
			if ($first_list && $lists[$first_list]) {
				if ($items_id = implode(', ', array_keys($lists[$first_list]))) {

					$item_cut = new ItemCut();
					$item_cut->set_paging(1, 0, "`item_id` ASC", array("`tbl_item_cut`.`item_id` IN ({$items_id})"));

					$item_id = 0;
					while ($item_cut->list_paged_info()) {
						if ($item_id != $item_cut->get_item_id()) {
							$item_id = $item_cut->get_item_id();
							$item_cuts[(string)$item_id] = array();
						}
						$item_cuts[(string)$item_id][(string)$item_cut->get_cut_id()] = array(
							'item' => $item_cut->get_item(),
							'info' => html_entity_decode($item_cut->get_description())
						);
					}
				}
			}
		}
		//print_r($item_cuts);
		//exit;
		return $item_cuts;
	}

	private function product_compare($product)
	{
		$title = $product->get_title();

		$body = $this->tpl->get_view('product/product_compare', array(
			'title' => $title,
			'subtitle' => false,
		));

		$this->tpl->page_draw(array(
			'meta_title' => $title,
			'meta_description' => $product->get_meta_description(),
			'meta_keywords' => $product->get_meta_keywords(),
			'body_id' => 'body_product',
			'body' => $body,
		));
	}

	private function product_intro($product)
	{
		$image_path = '/image' . $this->get_image_path();
		$form_url = $this->app->go($this->app->page_key, false, '/' . $product->get_product_key());
		$title = $product->get_title();

		$page_args = array(
			'meta_title' => $title,
			'meta_description' => $product->get_meta_description(),
			'meta_keywords' => $product->get_meta_keywords(),
			'body_id' => 'body_intro',

			'title' => $title,
			'subtitle' => false,
			'object' => $product,
			'form_url' => $form_url,
			'image_path' => $image_path,
		);

		$views = $this->tpl->get_view('product/product_intro', $page_args);
		$page_args = array_merge($page_args, $views);
		$this->tpl->page_draw($page_args);
	}

	protected function save(&$sale_product, $sale, $error = [], &$data = [], &$wholesaler = [], &$sale_address = [], &$sale_shipping = [], &$stock = [])
	{
		if (sizeof($error)) {
			// error, save the record anyway
			$sale_product->update();
			$error_msgs = $this->lng->all();

			$this->save_address($sale_product, $wholesaler, $data, $sale_shipping);

			//$error_msg = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$err_messages['\\1'])) ? \$err_messages['\\1'] : '\\1'", $error);

			$error_msg = preg_replace_callback('#^([A-Z_]+)$#', function ($m) use ($error_msgs) {
				return (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];
			}, $error);

			if ($data['ajax']) {
				// ajax return totals
				$data = $sale_product->to_array();
				$data['stock'] = $stock;
				$data['error'] = $error;

				header("Content-type: application/json");
				echo json_encode($data); //json_encode(array('error' => $error, 'required' => $sale_product->get_missing_fields()));

			} else {
				// TODO: never reach here?
				$_SESSION['tmp_sale_product'] = serialize($sale_product); // TODO: never checked later
				$_SESSION['error_msg'] = implode('<br />', $error_msg);

				$path = explode('/', $data['path']);
				unset($path[0]);
				$section = array_shift($path);
				$go_error = $this->app->go($this->app->module_key . '/' . $section, false, '/' . implode('/', $path));

				header('Location: ' . $go_error);
				exit;
			}
		} else {
			// success, save the record
			if ($data['ajax']) {
				// updating product price
				$sale_product->update();

				$this->save_address($sale_product, $wholesaler, $data, $sale_shipping);

				$_SESSION[$sale_product->get_product_key()] = $sale_product->get_id();
				$_SESSION['sale_id'] = $sale_product->get_sale_id();

				// ajax return totals
				$data = $sale_product->to_array();
				$data['stock'] = $stock;

				header("Content-type: application/json");
				echo json_encode($data); //$sale_product->to_json();

			} else {
				// product added to cart
				$sale_product->set_status('st_added');
				$sale_product->update();

				$this->save_address($sale_product, $wholesaler, $data, $sale_shipping);

				$sale->update_total();

				unset($_SESSION[$sale_product->get_product_key()]);
				unset($_SESSION['sale_product_id']);

				// navigate to cart
				header('Location: ' . $this->app->go('Cart'));
				exit;
			}
		}
	}


	private function update_address(&$sale_address, $md5)
	{
		if ($md5 && $md5 !== $sale_address->calculate_hash()) {
			// creates a new record
			$sale_address->set_id(0);
		}
		$sale_address->set_active(1); // TODO: still not sold should be 0?
		$sale_address->update();
	}

	private function save_address(&$sale_product, $wholesaler, $data, &$sale_shipping)
	{
		if ($wholesaler->get_id()) {

			$sale_shipping->set_sale_id($sale_product->get_sale_id());
			$sale_shipping->set_sale_product_id($sale_product->get_id());
			$sale_shipping->set_active(1);
			$sale_shipping->update();

			$sale_address = new SaleAddress($sale_product->get_sale_address_id());

			$md5 = '';
			if ($sale_address->get_id() && $sale_product->address_multiple_use()) {
				$md5 = $sale_address->calculate_hash();
			}

			$sale_address->set_user_id($wholesaler->get_user_id()); 		// idem
			$sale_address->set_sale_id($sale_product->get_sale_id()); 		// idem

			$sale_address->set_address_type($sale_address->address_type_enum('ship'));
			$sale_address->set_address_level($sale_address->address_level_enum('product'));
			$sale_address->set_address_ws($data['shipping_address']);

			switch ($data['shipping_address']) {
				case $sale_address->address_ws_enum('default'):
					//echo '001 >>>';
					if (!$data['ajax']) {
						$sale_address->copy_default_address($wholesaler);
						$this->update_address($sale_address, $md5);
					}
					break;

				case $sale_address->address_ws_enum('other'):
					//echo '002 >>>';
					$sale_address->set_other_address_id($data['ship_other']);

					if (!$data['ajax']) {
						$user_address = new UserAddress($data['ship_other']);
						$sale_address->copy_other_address($user_address);
						$this->update_address($sale_address, $md5);
					}
					break;

				case $sale_address->address_ws_enum('new'):
					//echo '003 >>>';
					// save new address
					$sale_address->set_last_name($data['ship_last_name']);
					$sale_address->set_address($data['ship_address']);
					$sale_address->set_zip($data['ship_zip']);
					$sale_address->set_city($data['ship_city']);
					$sale_address->set_state($data['ship_state']);
					$sale_address->set_phone($data['ship_phone']);

					$this->update_address($sale_address, $md5);
					$sale_product->set_sale_address_id($sale_address->get_id());

					if (!$data['ajax']) {
						// copy sale address to user address
						$user_address = new UserAddress();
						$user_address->set_user_id($wholesaler->get_user_id());
						$user_address->set_active(1);
						$user_address->copy_new_address($sale_address);
						$user_address->update();
					}
					break;

				default:
					//echo '004 >>>';
					// local pickup
					if (!$data['ajax']) {
						$this->update_address($sale_address, $md5);
					}
			}

			$sale_product->set_sale_address_id($sale_address->get_id());
			$sale_product->update();
		}
		//exit;
	}


	private function get_image_path()
	{
		$image_path = explode('/', $this->app->page);

		array_shift($image_path);
		array_shift($image_path);
		array_pop($image_path);

		$image_path = '/product' . ((sizeof($image_path)) ? '/' . implode('/', $image_path) : '');
		return $image_path;
	}

	private function get_product_price(&$data, Product &$product, SaleProduct &$sale_product, Wholesaler &$wholesaler, SaleShipping &$sale_shipping)
	{
		$detail = $economic = array();

		$parent = false;
		$comment = "";
		if ($data['parent_id']) {
			$parent = new Product($data['parent_id']);
		}
		$product_ref = ($parent) ? $parent : $product;

		$sale_product->set_job_name($data['job_name']);

		// base price
		$price = round($product->get_base_price() * $data['quantity'], 2);
		$weight = 0;
		$size_price = 0;

		if (in_array($product_ref->get_measure_type(), array('fixed', 'fixd-fixd')) && $product_ref->get_standard_type() == 'fixed') {
			$size_info = array(
				'measure' => 'fixed',
				'width' => $data['width'],
				'height' => $data['height'],

				'unit' => $price,
				'price' => round($price * $data['quantity'], 2),
			);
		} else if ($data['measure_unit'] == 'std') {
			if ($data['measure_type'] == 'shirts') {
				// standard / standar
				$size_front = new Size($data['size_front']);
				$size_back = new Size($data['size_back']);
				$width = round($size_front->get_width(), 2) + round($size_back->get_width(), 2);
				$height = round($size_front->get_height(), 2) + round($size_back->get_height(), 2);
				$descr = $width . ' x ' . $height . '"';
				$comment = "Front: " . $size_front->get_width() . "\" * " . $size_front->get_height() . "\"  -  Back: " . $size_back->get_width() . "\" * " . $size_back->get_height() . '"';
			} else {
				// standard
				$size = new Size($data['size']);
				$width = round($size->get_width(), 2);
				$height = round($size->get_height(), 2);
				$descr = $width . ' x ' . $height . '"';
			}

			if ($product->get_standard_type() == 'fixed' || $product->get_provider_id()) {
				if ($data['measure_type'] == 'shirts') {
					// standard_type == 'fixed' - Shirts
					$size_unit = $size_front->get_price_a() + $size_back->get_price_a();
					$size_price = round($size_unit * $data['quantity'], 2);
					$price += $size_price;
					$ref_size = [
						$size_front->to_array(),
						$size_back->to_array()
					];

					$size_info = array(
						'measure' => 'standard',
						'shape' => $data['shape_front'],
						'shape_back' => $data['shape_back'],
						'width' => $width,
						'height' => $height,
						'type' => 'list',
						'id' => $size_front->get_id(),
						'id_back' => $size_back->get_id(),
						'descr' => htmlspecialchars($descr),

						'unit' => $size_unit,
						'price' => $size_price,
					);
				} else {
					// standard_type == 'fixed'
					$size_unit = $size->get_price_a();
					$size_price = round($size_unit * $data['quantity'], 2);
					$price += $size_price;
					$ref_size = $size->to_array();

					$size_info = array(
						'measure' => 'standard',
						'shape' => $data['shape'],
						'width' => $width,
						'height' => $height,
						'type' => 'list',
						'id' => $size->get_id(),
						'descr' => htmlspecialchars($descr),

						'unit' => $size_unit,
						'price' => $size_price,
					);
				}
			} else {
				// standard_type == 'by-sqft'
				$size_info = array(
					'measure' => 'standard',
					'shape' => $data['shape'],
					'width' => $width,
					'height' => $height,
					'type' => 'list',
					'id' => $size->get_id(),
					'descr' => htmlspecialchars($descr),
				);
			}

			if ($product->get_provider_id()) {
				$provider_unit = $size->get_provider_price();
				$provider_price = round($provider_unit * $data['quantity'], 2);
				$provider_weight = $size->get_provider_weight();
				$weight += round($provider_weight * $data['quantity'], 2);

				$size_info['provider_unit'] = $provider_unit;
				$size_info['provider_price'] = $provider_price;
				$size_info['weight_unit'] = $provider_weight;
				$size_info['weight'] = $weight;
			}
		} else {
			// partial calcs
			$width = round($data['width'], 2);
			$height = round($data['height'], 2);

			if ($product->get_standard_type() == 'fixed') {
				$partial_sqft = round($width * $height / 144, 2);

				// look for the closest std size
				$sizes_arr = $this->load_sizes($product->get_id());
				$ref_size = '';
				$ref_sqft = '';

				$shape = ($width == $height) ? 's' : 'r';
				$sizes = $sizes_arr[$shape];
				$ref_descr = '';

				foreach ($sizes as $size) {
					$sqft = round($size['width'] * $size['height'] / 144, 2);
					if ($sqft >= $partial_sqft) {
						$size_price = round($size['price_a'] * $data['quantity'], 2);
						$ref_size = $size;
						$ref_descr = '[' . $shape . '] ' . $size['width'] . ' x ' . $size['height'] . '"';
						$ref_sqft = $sqft;
						break;
					}
				}

				if ($size_price) {
					$pp_increase = 0;
					$cost = new Cost();
					$cost->retrieve_by('cost_key', 'pp-increase');
					if ($cost->get_id()) {
						$pp_increase = $cost->get_value();
					}
					$price += $size_price * (1 + ((float)$pp_increase / 100));
				} else {
					// error, too big?
					error_log('standard_type = fixed / sqft too big, no price ' . $partial_sqft);
				}

				$size_info = array(
					'measure' => 'custom',
					'width' => $width,
					'height' => $height,
					'ref_descr' => htmlspecialchars($ref_descr),
					'ref_sqft' => $ref_sqft,
				);
			} else {
				// standard_type = by-sqft
				$size_info = array(
					'measure' => 'custom',
					'width' => $width,
					'height' => $height,
				);
			}
		}

		$partial_sqft = round($width * $height / 144, 2);
		$total_sqft = round($partial_sqft * $data['quantity'], 2);
		$partial_perim = ($width + $height) * 2;
		$partial_perim_ft = (($width + $height) * 2) / 12;
		$total_perim = round($partial_perim * $data['quantity'], 2);

		$sale_product->set_orientation($data['orientation']);

		$size_info = array_merge($size_info, array(
			'quantity' => $data['quantity'],
			'partial_sqft' => $partial_sqft,
			'total_sqft' => $total_sqft,
			'partial_perim' => $partial_perim,
			'total_perim' => $total_perim,
		));

		$sale_product->set_measure_unit($data['measure_unit']);
		$sale_product->set_width($width);
		$sale_product->set_height($height);
		$sale_product->set_partial_sqft($partial_sqft);
		$sale_product->set_partial_perim($partial_perim);
		$sale_product->set_quantity($data['quantity']);
		$sale_product->set_total_sqft($total_sqft);
		$sale_product->set_total_perim($total_perim);
		$sale_product->set_comment($comment);


		if (!$product->get_provider_id()) {
			// detail --------------------------------------------------------------------------

			// lists prices
			$item_lists = new ItemList();
			$item_lists->set_paging(1, 0, false, array(
				"`calc_by` IN ('area', 'perimeter', 'variable', 'none')"
			));

			$items_weight = 0;
			while ($item_lists->list_paged()) {
				$item_list_key = $item_lists->get_item_list_key();
				$data[$item_list_key] = $this->get_input($item_list_key, 0);

				if ($item_id = $data[$item_list_key]) {
					$item = new Item($item_id);
					switch ($item_lists->get_calc_by()) {
						case 'area':
							$item_price = round($item->get_price() * $total_sqft, 2);
							$item_weight = $total_sqft * $item->get_weight();
							break;

						case 'perimeter':
							$item_price = round($item->get_price() * $total_perim, 2);
							$item_weight = $total_perim * $item->get_weight();
							break;

						case 'unit':
							$item_price = round($item->get_price() * $data['quantity'], 2);
							$item_weight = $item->get_weight() * $data['quantity'];
							break;

						case 'none':
							// no price add but include in detail
							$item_price = 0;
							$item_weight = 0;
							break;

						case 'variable':
							switch ($item->get_calc_by()) {
								case 'area':
									$item_price = round($item->get_price() * $total_sqft, 2);
									$item_weight = $total_sqft * $item->get_weight();
									break;
								case 'perimeter':
									$item_price = round($item->get_price() * $total_perim, 2);
									$item_weight = $total_perim * $item->get_weight();
									break;
								case 'top_bottom':
									$item_price = round($item->get_price() * $width * 2, 2);
									$item_weight = round($item->get_weight() * $width * 2, 2);
									break;
								case 'top':
									$item_price = round($item->get_price() * $width, 2);
									$item_weight = round($item->get_weight() * $width, 2);
									break;
								case 'bottom':
									$item_price = round($item->get_price() * $width, 2);
									$item_weight = round($item->get_weight() * $width, 2);
									break;
								case 'unit':
									//$item_price = round($item->get_price(), 2);
									//$item_weight = $item->get_weight();
									$item_price = round($item->get_price() * $data['quantity'], 2);
									$item_weight = $item->get_weight() * $data['quantity'];
									break;

								default:
									error_log('Invalid item calc_by: ' . $item->get_calc_by() . ' / ' . $item->get_calc_by());
							}
							break;

						default:
							error_log('Invalid list calc_by: ' . $item_lists->get_calc_by());
					}

					if (!(in_array($product_ref->get_measure_type(), array('fixed', 'fixd-fixd')) && $product_ref->get_standard_type() == 'fixed')) {
						$price += $item_price;
						//echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><<<<<<<>>>>> $total_sqft: ' . $total_sqft;
					}

					$items_weight += $item_weight;

					$item_detail = array(
						'type' => 'list',
						'calc_by' => $item_lists->get_calc_by(),
						'item_calc_by' => $item->get_calc_by(),
						'id' => $item->get_id(),
						'descr' => (($code = $item->get_item_code()) ? '[' . $code . '] ' : '') . htmlentities($item->get_title(), ENT_COMPAT, 'UTF-8'),
						'unit' => $item->get_price(),
						'price' => $item_price,
						'weight' => $item_weight,
					);
					$detail[$item_lists->get_item_list_key()] = $item_detail;
				}
			}

			// sides
			$sale_product->set_sides($data['sides']);
			if ($data['sides'] == 2) {
				$cost = new Cost();
				$cost->retrieve_by('cost_key', 'double-side-coeff');
				if ($cost->get_id()) {
					$sides_price = round($price * $cost->get_value() / 100, 2);
					$price += $sides_price;

					$detail['sides'] = array(
						'type' => 'num',
						'val' => 2,
						'descr' => 2,
						'calc_by' => 'perc',
						'unit' => $cost->get_value() . '%',
						'price' => $sides_price,
					);
				}
				$size_info['sides'] = 2;
			} else {
				$size_info['sides'] = 1;
			}

			// optional element details and prices

			// cutting
			if ($data['cutting']) {
				$item = new Item($data['cutting']);
				$title = $product->get_title();

				if ($title == "Paper Roll Labels" || $title == "BOPP Roll Labels") {
					$trim_price = round($item->get_price() * $total_perim, 2);
				} else {

					$trim_price = round($item->get_price() * $partial_perim_ft * $data['quantity'], 2);
				}
				$detail['cutting'] = array(
					'type' => 'list',
					'val' => 'custom',
					'calc_by' => 'perimeter',
					'descr' => htmlspecialchars($item->get_title()),
					'unit' => $item->get_price(),
					'price' => $trim_price,
				);

				$price += $trim_price;
			}
		}


		// accessories
		if ($data['accesory1'] || $data['accesory2'] || $data['accesory3'] ) {
			if ($data['accesory1'] && $data['accesory1_qty']) {
				
				/* switch ($item_lists->get_calc_by()) {
						case 'area':
							$item_price = round($item->get_price() * $total_sqft, 2);
							$item_weight = $total_sqft * $item->get_weight();
							break;

						case 'perimeter':
							$item_price = round($item->get_price() * $total_perim, 2);
							$item_weight = $total_perim * $item->get_weight();
							break;

						case 'unit':
							$item_price = round($item->get_price() * $data['quantity'], 2);
							$item_weight = $item->get_weight() * $data['quantity'];
							break;

						case 'none':
							// no price add but include in detail
							$item_price = 0;
							$item_weight = 0;
							break;
				*/		
				$item = new Item($data['accesory1']);

				$item_price = round($item->get_price() * $data['accesory1_qty'], 2);
				$price += $item_price;

				$item_weight = $item->get_weight() * $data['accesory1_qty'];
				$items_weight += $item_weight;

				$detail['accesory1'] = array(
					'calc_by' => 'unit',
					'item_calc_by' => 'unit',
					'id' => $item->get_id(),
					'descr' => (($code = $item->get_item_code()) ? '[' . $code . '] ' : '') . htmlentities($item->get_title(), ENT_COMPAT, 'UTF-8'),
					'unit' => $item->get_price(),
					'quantity' => $data['accesory1_qty'],
					'price' => $item_price,
					'weight' => $item_weight,
				);
			}

			if ($data['accesory2'] && $data['accesory2_qty']) {
				$item = new Item($data['accesory2']);

				$item_price = round($item->get_price() * $data['accesory2_qty'], 2);
				$price += $item_price;

				$item_weight = $item->get_weight() * $data['accesory2_qty'];
				$items_weight += $item_weight;

				$detail['accesory2'] = array(
					'calc_by' => 'unit',
					'item_calc_by' => 'unit',
					'id' => $item->get_id(),
					'descr' => (($code = $item->get_item_code()) ? '[' . $code . '] ' : '') . htmlentities($item->get_title(), ENT_COMPAT, 'UTF-8'),
					'unit' => $item->get_price(),
					'quantity' => $data['accesory2_qty'],
					'price' => $item_price,
					'weight' => $item_weight,
				);
			}
			
			if ($data['accesory3'] && $data['accesory3_qty']) {
				$item = new Item($data['accesory3']);

				$item_price = round($item->get_price() * $data['accesory3_qty'], 2);
				$price += $item_price;

				$item_weight = $item->get_weight() * $data['accesory3_qty'];
				$items_weight += $item_weight;

				$detail['accesory3'] = array(
					'calc_by' => 'unit',
					'item_calc_by' => 'unit',
					'id' => $item->get_id(),
					'descr' => (($code = $item->get_item_code()) ? '[' . $code . '] ' : '') . htmlentities($item->get_title(), ENT_COMPAT, 'UTF-8'),
					'unit' => $item->get_price(),
					'quantity' => $data['accesory3_qty'],
					'price' => $item_price,
					'weight' => $item_weight,
				);
			}
		}

		// increases and discounts ------------------------------------------------

		// discount ws
		$disc_user = $disc_standard = 0;
		$disc_user = round($price * (float)$wholesaler->get_discount() / 100, 2);
		$price -= $disc_user;
		$ws_price = $price;
		$economic['base_price'] = array(
			'val' => $ws_price,
		);


		//Remove user discount from price calculation
		/*$economic['disc_user'] = array(
			'perc' => -(float)$wholesaler->get_discount(),
			'val' => -$disc_user,
		);*/

		// discount standard
		//if ($data['standard_type'] == 'by-sqft' && $data['measure_unit'] == 'std' && !$product->get_provider_id()) {
		if ($product->get_standard_type() == 'by-sqft' && $data['measure_unit'] == 'std' && !$product->get_provider_id()) {
			$cost = new Cost();
			$cost->retrieve_by('cost_key', 'std-discount');
			$disc_standard = round($price * (float)$cost->get_value() / 100, 2);
			$economic['disc_standard'] = array(
				'perc' => -(float)$cost->get_value(),
				'val' => -$disc_standard,
			);
		}

		// discount quantity (unit/sqft)
		$disc_quantity = 0;

		$obj_discounts = $product_ref->get_discounts();

		if ($product_ref->get_discounts() && $data['quantity']) {
			$qty_discounts = explode("\n", $obj_discounts); // 1/n/5
			foreach ($qty_discounts as $row) {
				$discount = explode('/', $row);
				list($min, $max, $perc) = $discount;

				if (in_array($product_ref->get_measure_type(), array('fixed', 'fixd-fixd')) || $product_ref->get_standard_type() == 'unit') {
					// discount by quantity
					if ($data['quantity'] >= $min && ($max == 'n' || $data['quantity'] <= $max)) {
						$disc_quantity = round($price * $perc / 100, 2);
						$economic['disc_quantity'] = array(
							'perc' => -$perc,
							'val' => -$disc_quantity,
							'range' => $min . '-' . $max,
						);
						break;
					}
				} else {
					// discount by sqft
					if ($total_sqft >= $min && ($max == 'n' || $total_sqft <= $max)) {
						$disc_quantity = round($price * $perc / 100, 2);
						$economic['disc_quantity'] = array(
							'perc' => -$perc,
							'val' => -$disc_quantity,
							'range' => $min . '-' . $max,
						);
						break;
					}
				}
			}
		}

		// ---------------------------------------------------------------------------------------
		//User discount removed from the discount price calculation
		//$discounts = $disc_user + $disc_standard + $disc_quantity;
		$discounts = $disc_standard + $disc_quantity;
		$price += $product->get_setup_fee();
		$subtotal = $price - $discounts;
		// ---------------------------------------------------------------------------------------

		// minimum
		if ($product_ref->get_measure_type() == 'fixed' && $product_ref->get_standard_type() == 'fixed') {
			$min_total = (float)$product->get_base_price();
		} else if ($product->get_minimum() > 0) {
			$min_total = (float)$product->get_minimum();
		} else {
			$minimum = new Cost();
			$minimum->retrieve_by('cost_key', 'minimum');
			$min_total = (float)$minimum->get_value();
		}

		// turnaround
		$turnaround_cost = 0;
		if ($data['turnaround']) {
			$cost = new Cost();
			$cost->retrieve_by('cost_key', 'turnaround-' . $data['turnaround']);
			$turnaround_cost = round(($subtotal) * $cost->get_value() / 100, 2);
			$economic['turnaround'] = array(
				'perc' => (float)$cost->get_value(),
				'val' => $turnaround_cost,
				'default' => $data['turnaround_calc'],
				'select' => $data['turnaround_days'],
			);
		}

		// calc date
		$date_due = $this->calc_due_date(date($this->app->db_datetime_format), $data['turnaround_days']);
		$sale_product->set_date_due($date_due); // must be cleared when order is posted

		// reinforced packaging
		$reinf_packaging_cost = 0;
		if ($data['packaging'] && $data['quantity']) {
			//var_dump($ref_size[$data['packaging']] * $data['quantity']);
			$cost = new Cost();
			$cost->retrieve_by('cost_key', 'packagingy-' . $data['packaging']);
			//$reinf_packaging_cost = ($data['packaging'] == 'price_0') ? 0 : $ref_size[$data['packaging']] * $data['quantity']; // price_b/_c
			$reinf_packaging_cost = ($data['packaging'] == 'price_0') ? 0 : $subtotal * $cost->get_value() / 100; // price_b/_c

			$detail['reinf_packaging'] = array(
				'key' => $data['packaging'],
				'descr' => $this->lng->text('product:' . $data['packaging']),
				'unit' => $ref_size[$data['packaging']],
				'price' => $reinf_packaging_cost,
			);
			$economic['reinf_packaging'] = array(
				'unit' => $ref_size[$data['packaging']],
				'total' => $reinf_packaging_cost,
			);
		}
		$sale_product->set_packaging($data['packaging']);
		$sale_product->set_packaging_cost($reinf_packaging_cost);


		// proof
		$proof_cost = 0;
		if ($data['proof']) {
			$cost = new Cost();
			$cost->retrieve_by('cost_key', 'proof-cost');
			$proof_cost = (float)$cost->get_value();
			$economic['proof'] = array(
				'val' => $proof_cost,
			);
		}
		$sale_product->set_proof($data['proof']);
		$sale_product->set_proof_cost($proof_cost);

		// shipping was here ------------

		// totals -----------------------------------------------------------------------

		$sale_product->set_product_subtotal($price);

		// TODO: store product turnaround info as JSON
		$sale_product->set_turnaround_detail($data['turnaround_days'] . '/' . $data['turnaround_calc']);
		$sale_product->set_turnaround_cost($turnaround_cost);

		// TODO: store product discounts info as JSON
		$sale_product->set_qty_discount_detail($obj_discounts);
		$sale_product->set_quantity_discount($discounts);

		if ($subtotal >= $min_total) {
			$sale_product->set_subtotal_discount($subtotal);
			$sale_product->set_subtotal_discount_real(0);
		} else {
			$sale_product->set_subtotal_discount($min_total);
			$sale_product->set_subtotal_discount_real($subtotal);
			$subtotal = $min_total;
		}

		$product_total = $subtotal;
		if ($total_sqft) { // TODO: ver
			$sale_product->set_price_sqft($product_total / $total_sqft);
		} else {
			$sale_product->set_price_sqft(0);
		}
		$sale_product->set_price_piece(($data['quantity']) ? $product_total / $data['quantity'] : 0);

		// don't include shipping cost (because taxes calculation later) --------------------
		$addings = $turnaround_cost + $reinf_packaging_cost + $proof_cost;
		$product_total += $addings;
		// ----------------------------------------------------------------------------------

		$sale_product->set_product_total($product_total);


		// weight and shipping ----------------------------------------------------------------
		$packaging_cost = 0;
		if ($data['quantity']) {
			if ($product_ref->get_measure_type() == 'fixed') { //$data['closed']) {
				// by quantity
				$weight_product = $product->get_weight() * $data['quantity'];
			} else {
				// by sqft
				$item_weight = round($item_weight, 2);
				$weight_product = round(($product->get_weight() * $total_sqft) + $items_weight, 2);
			}

			// packaging weight
			$cost = new Cost();
			if ($data['packaging']) {
				$cost->retrieve_by('cost_key', 'packaging-' . $data['packaging']); // price_b/_c %
				$weight_packaging = round($weight_product * $cost->get_value() / 100, 2);
				$detail['reinf_packaging']['weight'] = $weight_packaging;

				$weight += $weight_product + $weight_packaging;
			} else {
				$cost->retrieve_by('cost_key', 'packaging-weight'); // %
				$weight_packaging = round($weight_product * $cost->get_value() / 100, 2);
				$weight += $weight_product + $weight_packaging;

				$cost->retrieve_by('cost_key', 'packaging-cost'); // $ by lb
				$packaging_cost = round($weight_product * $cost->get_value(), 2);
			}
		}

		// shipping cost
		$shipping_cost = 0.00;
		$sale_product->set_shipping_cost(0.00);

		$sale_shipping->retrieve_by('sale_product_id', $sale_product->get_id());
		$sale_shipping->set_shipping_level(1); // product

		if ($shipping_error = $this->get_shipping_info($data, $weight, $sale_shipping, $product->get_provider_id())) {
			error_log('Shipping_error sale_product_id: ' . $sale_product->get_id() . ' | Error: ' . $shipping_error);
		}

		$sale_shipping->set_shipping_weight($weight);
		$sale_shipping->set_shipping_zip($data['zip_code']);

		$sale_product->set_shipping_zip($sale_shipping->get_shipping_zip());
		$sale_product->set_shipping_types(json_decode($sale_shipping->get_shipping_types(), true));
		$sale_product->set_shipping_type($sale_shipping->get_shipping_type());
		$sale_product->set_shipping_change($sale_shipping->get_shipping_change());


		// ***************** shipping bonification ***************************************
		if ($sale_shipping->get_shipping_type() == 'Local Delivery' && $product_total >= 20000) {
			$sale_shipping->set_shipping_cost(0.00);
			$sale_shipping->update();
		}

		if (!$shipping_cost = (float)$sale_shipping->get_shipping_cost()) {
			// if no $shipping_cost, no $packaging_cost either
			$packaging_cost = 0;
		}

		$sale_product->set_shipping_cost($shipping_cost + $packaging_cost);

		$economic['shipping'] = array(
			'weight_product' => $weight_product,
			'weight_packaging' => $weight_packaging,
			'weight_total' => $weight,
			'zip' => $data['zip_code'],
			'type' => $sale_shipping->get_shipping_type(),
			'packaging_cost' => $packaging_cost,
			'shipping_cost' => $shipping_cost,
			'val' => $shipping_cost + $packaging_cost,
		);

		$sale_product->set_shipping_weight($weight);

		$summary = array(
			'ws_price' => $ws_price,
			'price' => $price,
			'discounts' => $discounts,
			'subtotal' => $subtotal,
			'minimum' => $min_total,
			'addings' => $addings,
			'total' => $product_total,
			'shipping' => $shipping_cost + $packaging_cost,
		);

		$sale_info = array('size' => $size_info, 'detail' => $detail, 'costs' => $economic, 'summary' => $summary);

		if ($product->get_provider_id()) {
			$provider_info = array(
				'provider_id' => $product->get_provider_id(),
				'provider' => $product->get_provider(),
				'provider_location' => $product->get_provider_city() . ', ' . $product->get_provider_state(),
				'provider_code' => $product->get_provider_code(),
				'provider_name' => $product->get_provider_name(),
				'provider_url' => $product->get_provider_url(),
				'provider_unit' => $size_info['provider_unit'],
				'provider_price' => $size_info['provider_price'],
			);

			$sale_product->set_provider_id($product->get_provider_id());
			$sale_product->set_provider_info($provider_info);

			$sale_info['provider'] = $provider_info;
		}

		$sale_product->set_detail($sale_info);
	}

	private function get_shipping_info($data, $weight, &$sale_shipping, $provider_id)
	{
		$error = false;
		error_log('Data:' . print_r($data, true));
		// check if all fields are available
		if ($data['shipping_address'] && $data['zip_code'] && strlen((string)$data['zip_code']) == 5 && $weight) {
			if ($sale_shipping->get_shipping_zip() != $data['zip_code'] || $sale_shipping->get_shipping_weight() != $weight) {
				// zip or weight change, get new rates

				if (!$this->app->ship_carrier || $this->app->ship_carrier == 'UPS') {
					// UPS
					try {
						$rate = new RocketShipRate('UPS');

						if ($provider_id) {
							$provider = new Provider($provider_id);

							$rate->setParameter('shipAddr1', $provider->get_provider_address());
							$rate->setParameter('shipCity', $provider->get_provider_city());
							$rate->setParameter('shipState', $provider->get_provider_state());
							$rate->setParameter('shipCode', $provider->get_provider_zip());
						}

						$rate->setParameter('toCode', $data['zip_code']);
						$rate->setParameter('residentialAddressIndicator', '0');

						if ($weight <= 150) { // package limit
							$rate->setParameter('weight', $weight);
						} else {
							// distribute packages
							$pack_150 = (int)($weight / 150);
							$pack_last = $weight % $pack_150;

							for ($i = 1; $i <= $pack_150; $i++) {
								$package = new RocketShipPackage('UPS');
								$package->setParameter('weight', 150);
								$rate->addPackageToShipment($package);
							}

							if ($pack_last) {
								$package = new RocketShipPackage('UPS');
								$package->setParameter('weight', $pack_last);
								$rate->addPackageToShipment($package);
							}
						}
					} catch (\Throwable $th) {
						error_log($th);
					}
				} else {
					// FEDEX
					$rate = $this->app->ship_engine;

					$rate->setParameter('toCode', $data['zip_code']);
					$rate->setParameter('residentialAddressIndicator', '0');
					$rate->setParameter('weight', $weight);
				}
				$rates = array();

				// add Local Delivery
				if (in_array($data['zip_code'], $this->app->local_zips)) {
					$cost = new Cost();
					$cost->retrieve_by('cost_key', 'local-delivery-cost');
					$rates[$this->lng->text('checkout:local_delivery')] = $cost->get_value();
				}

				try {
					$response = $rate->getSimpleRates();
				} catch (\Throwable $th) {
					error_log('Shipping Service is down');
					error_log($th);
					$response['error'] = 'Shipping Service is down';
				}

				//error_log('XML' . print_r($rate->getXmlSent(), true));
				//error_log('Debug' . print_r($rate->debug(), true));

				if (array_key_exists('error', $response)) {
					$error = $response['error'];
					error_log('Shipping: ' . $error . ' | ' . print_r($data, true));
					error_log('Response: ' . print_r($response, true));
					$sale_shipping->set_shipping_types('[]');
					$sale_shipping->set_shipping_type('');
					$sale_shipping->set_shipping_cost(0.00); // ***
					$sale_shipping->set_shipping_change(true);
				} else {
					// convert back to old format
					//					$response2 = array();
					//					foreach($response as $key => $item) {
					//						$response2[$key] = $item['Rate'];
					//					}
					// --------------------------

					$rates = array_merge($rates, $response); //$response2);

					error_log('Rates ' . $_SESSION['sale_id']);
					error_log(print_r($response, true));
					error_log(print_r($rates, true));

					// if shipping_type is available, calculate
					$shipping_type = $data['shipping_type'];
					$shipping_cost = 0.00;
					if ($shipping_type && array_key_exists($shipping_type, $rates)) {
						$shipping_cost = (float)$rates[$shipping_type];
					} else {
						// take first value
						$shipping_type = '';
						$val = reset($rates);
						if ($val !== false) {
							$shipping_type = key($rates);
							$shipping_cost = (float)$val;
						}
					}

					$sale_shipping->set_shipping_types(json_encode($rates));
					$sale_shipping->set_shipping_type($shipping_type);
					$sale_shipping->set_shipping_cost($shipping_cost);
					$sale_shipping->set_shipping_change(true);
				}
			} else if ($sale_shipping->get_shipping_type() != $data['shipping_type']) {
				// shipping type change
				$shipping_type = $data['shipping_type'];
				$shipping_cost = 0.00;
				$rates = json_decode($sale_shipping->get_shipping_types(), true);
				if ($shipping_type && array_key_exists($shipping_type, $rates)) {
					$shipping_cost = (float)$rates[$shipping_type];
				} else {
					// take first value
					$shipping_type = '';
					$val = reset($rates);
					if ($val !== false) {
						$shipping_type = key($rates);
						$shipping_cost = (float)$val;
					}
				}
				$sale_shipping->set_shipping_type($shipping_type);
				$sale_shipping->set_shipping_cost($shipping_cost);
				$sale_shipping->set_shipping_change(false);
			} else {
				// no changes

			}
		} else {
			$sale_shipping->set_shipping_types('[]');
			$sale_shipping->set_shipping_type('');
			$sale_shipping->set_shipping_cost(0.00); // ***
			$sale_shipping->set_shipping_change(true);
		}

		return $error;
	}

	private function calc_due_date($date, $turnaround)
	{
		$holidays = (isset($this->app->holidays[date('Y')])) ? $this->app->holidays[date('Y')] : array();
		$date_due = $this->date_add_biz_days($date, $turnaround, $holidays);

		return $date_due;
	}

	private function get_product_info()
	{
		$text = new Document();
		$info = array();

		$text->retrieve_by('document_key', 'info_shipping');
		$info['shipping'] = array('title' => $text->get_title(), 'info' => $text->get_content());
		$text->retrieve_by('document_key', 'info_turnaround');
		$info['turnaround'] = array('title' => $text->get_title(), 'info' => $text->get_content());
		$text->retrieve_by('document_key', 'info_discounts');
		$info['discounts'] = array('title' => $text->get_title(), 'info' => $text->get_content());
		$text->retrieve_by('document_key', 'info_discounts_prints');
		$info['discounts_prints'] = array('title' => $text->get_title(), 'info' => $text->get_content());
		$text->retrieve_by('document_key', 'info_measures');
		$info['measures'] = array('title' => $text->get_title(), 'info' => $text->get_content());

		$text->retrieve_by('document_key', 'info_trimming');
		$info['trimming'] = array('title' => $text->get_title(), 'info' => $text->get_content());
		$text->retrieve_by('document_key', 'info_cut_quantity');
		$info['cut_quantity'] = array('title' => $text->get_title(), 'info' => $text->get_content());

		$text->retrieve_by('document_key', 'info_packaging');
		$info['packaging'] = array('title' => $text->get_title(), 'info' => $text->get_content());
		$text->retrieve_by('document_key', 'info_proof');
		$info['proof'] = array('title' => $text->get_title(), 'info' => $text->get_content());

		return $info;
	}

	private function get_lists($product_id)
	{
		// 1. Get the lists of the product
		$product_lists = new ProductList();
		$product_lists->set_paging(1, 0, '`product_list_id` ASC', array("`product_id` = {$product_id}"));

		// 2. Create an array of lists
		$lists = array();

		// 3. Foreach list, get items for this product
		while ($product_lists->list_paged()) {
			// 4. Get item_list info
			$item_list = new ItemList();
			$item_list->retrieve_by('item_list_key', $product_lists->get_item_list_key());

			// 5. Create an array of items
			$filter = array(
				"`product_id` = {$product_id}",
				"`tbl_product_item`.`item_list_key` = '{$product_lists->get_item_list_key()}'",
			);
			$product_item = new ProductItem();
			$product_item->set_paging(1, 0, '`order` ASC', $filter);

			$items = array();

            $temp_item_filter = new Item();
	    
		
			// lists with max
			//$list_max = $this->utl->get_property('list_max', array());
			//if (in_array($product_lists->get_item_list_key(), $list_max)) { //array('material', 'material-photoproducts', 'material-fineart', 'edges', 'mounting'))) {
			if ($item_list->get_has_max()) {
				while ($product_item->list_paged()) {
				    $temp_item_filter->retrieve_by('item_id', $product_item->get_item_id());
				    $items[(string)$product_item->get_item_id()] = array(
						'title' => $product_item->get_item(),
						'filter_word' => $temp_item_filter->get_filter_word(),
						'info' => $product_item->get_description(),
						'max' => array(
							'max_width' => $product_item->get_max_width(),
							'max_length' => $product_item->get_max_length(),
							'max_absolute' => $product_item->get_max_absolute(),
						),
						'calc_by' => $product_item->get_calc_by(),
					);
				}
			} else {
				while ($product_item->list_paged()) {
					$items[(string)$product_item->get_item_id()] = array(
						'title' => $product_item->get_item(),
						'info' => $product_item->get_description(),
					);
				}
			}

			// 6. Add them to the array of lists
			$lists[$product_lists->get_item_list_key()] = $items;
		}
		return $lists;
	}


	private function get_default_address($object)
	{
		if ($object->get_ship_same()) {
			$address = $object->get_full_name() . '<br />'
				. $object->get_bill_address() . '<br />'
				. $object->get_bill_city() . ', ' . $object->get_bill_state() . ' ' . $object->get_bill_zip() . '<br />'
				. 'Ph ' . $object->get_bill_phone();
		} else {
			$address = $object->get_full_name() . '<br />'
				. $object->get_ship_address() . '<br />'
				. $object->get_ship_city() . ', ' . $object->get_ship_state() . ' ' . $object->get_ship_zip() . '<br />'
				. 'Ph ' . $object->get_ship_phone();
		}
		return $address;
	}

	private function get_ws_info($sale_product)
	{
		// Wholesaler
		$user = $this->app->user;
		$wholesaler = new Wholesaler();
		//$wholesaler->retrieve_by(array('user_id', 'status'), array($user->get_id(), 'ws_approved'));
		$wholesaler->retrieve_by(array('user_id'), array($user->get_id()));
		$country = new Country();
		$country->set_paging(1, 0, "`country` ASC");
		$countries = [];
		$countries['44'] = 'United States of America';
		while ($country->list_paged()) {
			$countries[$country->get_id()] = $country->get_string();
		}

		$isBillable = false;

		$default_address = $default_zip = '';
		$other_addresses = new UserAddress();

		$sale_address = new SaleAddress();
		if ($wholesaler->get_id()) {
			$other_addresses->set_paging(1, 0, false, array("`user_id` = {$user->get_id()}"));

			if (
				$wholesaler->get_bill_address() != '' &&
				$wholesaler->get_bill_city() != '' &&
				$wholesaler->get_bill_state() != '' &&
				$wholesaler->get_bill_zip() != '' &&
				$wholesaler->get_bill_country() != '' &&
				$wholesaler->get_status() == 'ws_approved'
			) {
				$isBillable = true;
			}

			if ($sale_product->get_sale_address_id()) {
				$sale_address = new SaleAddress($sale_product->get_sale_address_id());
			} else {
				if ($this->app->cart_items) {
					// new product, copy address from last product
					$sale_product_tmp = new SaleProduct();
					$sale_product_tmp->retrieve_sale_last($sale_product->get_sale_id());
					$sale_product->set_sale_address_id($sale_product_tmp->get_sale_address_id());

					$sale_address = new SaleAddress($sale_product->get_sale_address_id());
				} else {
					$sale_address = new SaleAddress();
					$sale_address->set_address_ws($sale_address->address_ws_enum('none'));
				}
			}
			$default_address = $this->get_default_address($wholesaler);
			$default_zip = ($wholesaler->get_ship_same()) ? $wholesaler->get_bill_zip() : $wholesaler->get_ship_zip();
		}

		$ws_info = array(
			'wholesaler' => $wholesaler,
			'default_address' => $default_address,
			'default_zip' => $default_zip,
			'other_addresses' => $other_addresses,
			'sale_address' => $sale_address,
			'countries' => $countries,
			'isBillable' => $isBillable,
		);

		return $ws_info;
	}

	private function get_gallery($product_id, $parent_id = false)
	{
		//$path = $this->get_image_path();

		$path = '/product' . (($parent_id) ? sprintf('/%06d', $parent_id) : '');

		$image_url = '/image' . $path;
		$image_path = $this->cfg->path->data . $path;

		// check existing images
		$gallery = array();
		for ($i = 1; $i <= 9; $i++) {
			$image = sprintf('/%06d.%02d.jpg', $product_id, $i);

			if (file_exists($image_path . $image)) {
				$gallery[] = $image_url . '/0' . $image;
			} else {
				break;
			}
		}

		return $gallery;
	}

	protected function run_ajax_list()
	{
		$product = new Product();
		$product_list = [];
		$product->set_paging(1, 0, ['`title` ASC'], ["`product_type` in ('subproduct', 'product-single')"]);
		while ($product->list_paged()) {
			//$product_list[] = htmlentities($product->get_title());
			$product_list[] = str_replace('\'', '&#39;', $product->get_title());
		}
		echo json_encode($product_list);
	}
	protected function run_ajax_search()
	{
		$title = $this->get_input('title', '');
		if ($title) {
			$product = new Product();
			$product->retrieve_by('title', $title);
			$url = "";

			if ($product->get_product_type() == 'subproduct' || $product->get_product_type() == 'product-single') {
				if ($product->get_parent_id()) {
					$parent = new Product($product->get_parent_id());
					$url = $this->app->go('Product', 'en', '/' . $parent->get_product_key() . '/' . $product->get_product_key());
				} else {
					$url = $this->app->go('Product', 'en', '/' . $product->get_product_key());
				}
			}

			echo json_encode($url);
		}
	}
}