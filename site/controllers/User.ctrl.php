<?php

/**
 *
 * -------------------------------------------------------
 * CLASSNAME:        UserCtrl
 * GENERATION DATE:  14.07.2013
 * -------------------------------------------------------
 *
 */

class UserCtrl extends CustomCtrl
{
	protected $mod = 'User';


	protected function run_default($args, $action)
	{
		switch ($action) {
			case 'wholesaler':
				$this->run_register_ws($args);
				break;

			case 'account':
				$this->run_account($args);
				break;
			case 'registered':
				$this->run_registered($args);
				break;

			case 'confirm':
				$this->run_confirm($args);
				break;

			case 'ajax_confirm':
				$this->run_ajax_confirm($args);
				break;

			case 'final':
				$this->run_final();
				break;
			//Non existing
			//case 'address_remove':
			//	$this->run_address_remove($args);
			//	break;
			//case 'address_save':
			//	$this->run_address_save($args);
			//	break;

			default:
				$this->run_register($args);
		}
	}

	protected function run_register($args)
	{
		if (!$this->app->user_id) {

			$user = new User();
			$user_msg = array('error' => '', 'captcha_error' => '', 'success' => '');

			if ($this->get_input('first_name', '', true)) {
				// come from home
				$user->set_first_name($this->get_input('first_name', '', true));
				$user->set_email($this->get_input('email', '', true));
				$user->set_newsletter($this->get_input('newsletter', '', true));
			} else if (isset($_SESSION['user_msg'])) {
				$user_msg = $_SESSION['user_msg'];
				unset($_SESSION['user_msg']);
				if ($user_msg['error']) {
					$user = unserialize($_SESSION['user_var']);
					unset($_SESSION['user_var']);
				}
			}

			$title = $this->lng->text('register:title');
			$token = $this->get_form_token('register');

			$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_register',
				'object' => $user,
				'title' => $title,
				'error_msg' => $user_msg['error'],
				'captcha_msg' => $user_msg['captcha_error'],
				'success_msg' => $user_msg['success'],
				'token' => $token,
				'show_warning' => false,
			));
			$page_args = array_merge($page_args, $this->tpl->get_view('user/register', $page_args));
			$this->tpl->page_draw($page_args);
		} else {
			// back?
			$wholesaler = new Wholesaler();
			$wholesaler->retrieve_by('user_id', $this->app->user_id);

			if (!$wholesaler->get_id()) {
				// registration not finished?
				header('Location: ' . $this->app->go('User/account'));
				exit;
			} else {
				// Must not be logged
				header('Location: ' . $this->app->go('Home'));
				exit;
			}
		}
	}

	protected function run_single($object, $args = array())
	{
		if ($_SESSION['logged_by_remember'] && !$args['profile']) {
			$_SESSION['session_target'] = $this->app->page_full;
			$this->app->redirect($this->app->go('Session/login_rmb'));
		} else {
			$roles = new Role();
			$roles->set_paging(1, 0, '`role` ASC');

			$page_args = array_merge($args, array(
				'roles' => $roles,
			));
			parent::run_single($object, $page_args);
		}
	}

	protected function run_register_ws($args = [])
	{
		if ($this->app->user_id) {
			$user = $this->app->user;

			$wholesaler = new Wholesaler();
			$returned = false;

			$wholesaler->retrieve_by('user_id', $user->get_id());
			if (!$wholesaler->get_id() || $wholesaler->get_status() == "ws_pending") {
				$wholesaler_msg = array('error' => '', 'success' => '');

				if (isset($_SESSION['wholesaler_msg'])) {
					$wholesaler_msg = $_SESSION['wholesaler_msg'];
					unset($_SESSION['wholesaler_msg']);
					if ($wholesaler_msg['error']) {
						$wholesaler = unserialize($_SESSION['wholesaler_var']);
						unset($_SESSION['wholesaler_var']);
						$returned = false;
					}
				}

				$permit = new Document();
				$permit->retrieve_by('document_key', 'wholesale-permit');

				$certificate = new Document();
				$certificate->retrieve_by('document_key', 'florida-certificate');

				$country = new Country();
				$country->set_paging(1, 0, "`country` ASC");

				$countries = array();
				$countries['44'] = 'United States of America';
				while ($country->list_paged()) {
					$countries[$country->get_id()] = $country->get_string();
				}

				$states = array('--' => '[' . $this->lng->text('wholesaler:outside') . ']') + $this->app->states;

				$how_hears = array(
					'team' => $this->lng->text('how_hear:team'),
					'contact' => $this->lng->text('how_hear:contact'),
					'trade' => $this->lng->text('how_hear:trade'),
					'mouth' => $this->lng->text('how_hear:mouth'),
					'search' => $this->lng->text('how_hear:search'),
					'social' => $this->lng->text('how_hear:social'),
					'article' => $this->lng->text('how_hear:article'),
					'magazine' => $this->lng->text('how_hear:magazine'),
					'other' => $this->lng->text('how_hear:other'),
				);

				$languages = array(
					'en' => $this->lng->text('wholesaler:lang_english'),
					'es' => $this->lng->text('wholesaler:lang_spanish'),
					'bt' => $this->lng->text('wholesaler:lang_both'),
				);

				$title = $this->lng->text('wholesaler:title');
				$page_args = array_merge($args, array(
					'meta_title' => $title,
					'body_id' => 'body_register',

					'title' => $title,
					'object' => $user,
					'wholesaler' => $wholesaler,
					'countries' => $countries,
					'states' => $states,
					'permit' => $permit,
					'certificate' => $certificate,
					'fiscal_years' => $this->app->fiscal_years,
					'how_hears' => $how_hears,
					'languages' => $languages,
					'error_msg' => $wholesaler_msg['error'],
					'success_msg' => $wholesaler_msg['success'],
					'show_warning' => false,
					'returned' => $returned,
				));
				$page_args = array_merge($page_args, $this->tpl->get_view('user/register_ws', $page_args));
				$this->tpl->page_draw($page_args);
			} else {
				// Already Wholesale
				//header('Location: ' . $this->app->go('Home'));
				$args = array_merge(['wholesaler'], $args);
				$this->run_account($args);
				exit;
			}
		} else {
			// Must be logged
			header('Location: ' . $this->app->go('Home'));
			exit;
		}
	}

	protected function run_account($args)
	{
		if ($this->app->user_id) {
			$sub = array_shift($args);
			switch ($sub) {
				case 'wholesaler':
					$this->run_account_ws($args);
					break;
				case 'orders':
					$this->run_orders($args);
					break;
				case 'addresses':
					$this->run_addresses($args);
					break;

				default:
					$user = $this->app->user;
					$user_msg = array('error' => '', 'success' => '');

					$wholesaler = new Wholesaler();
					$wholesaler->retrieve_by('user_id', $user->get_id());

					$signup = (!$wholesaler->get_id());

					if (isset($_SESSION['user_msg'])) {
						$user_msg = $_SESSION['user_msg'];
						unset($_SESSION['user_msg']);
						if ($user_msg['error']) {
							$user = unserialize($_SESSION['user_var']);
							unset($_SESSION['user_var']);
						}
					}

					$title = $this->lng->text('account:title');
					$page_args = array_merge($args, array(
						'meta_title' => $title,
						'body_id' => 'body_account',

						'object' => $user,
						'wholesaler' => $wholesaler,
						'title' => $title,
						'signup' => $signup,
						'error_msg' => $user_msg['error'],
						'success_msg' => $user_msg['success'],
					));
					$page_args = array_merge($page_args, $this->tpl->get_view('user/account', $page_args));
					$this->tpl->page_draw($page_args);
			}
		} else {
			// Must be logged
			header('Location: ' . $this->app->go('Home'));
			exit;
		}
	}

	protected function run_account_ws($args)
	{
		$is_admin = false;
		$active = isset($args['active']);

		if ($user_id = array_shift($args)) {
			// administrator editing?
			if ($this->app->user_admin) {
				$is_admin = true;
			} else {
				// got id but not admin
				$user_id = $this->app->user_id;
			}
		} else {
			$user_id = $this->app->user_id;
		}

		if ($user_id) {
			$user = new User($user_id);

			$wholesaler = new Wholesaler();
			$wholesaler->retrieve_by('user_id', $user_id);

			if ($wholesaler->get_id()) {
				$wholesaler_msg = array('error' => '', 'success' => '');

				if (isset($_SESSION['wholesaler_msg'])) {
					$wholesaler_msg = $_SESSION['wholesaler_msg'];
					unset($_SESSION['wholesaler_msg']);
					if ($wholesaler_msg['error']) {
						$wholesaler = unserialize($_SESSION['wholesaler_var']);
						unset($_SESSION['wholesaler_var']);
					}
				}

				$countries = new Country();
				$countries->set_paging(1, 0, "`country` ASC");

				$country = new Country();
				$country->set_paging(1, 0, "`country` ASC");

				$countries = array();
				$countries['44'] = 'United States of America';
				while ($country->list_paged()) {
					$countries[$country->get_id()] = $country->get_string();
				}

				$states = array('--' => '[' . $this->lng->text('wholesaler:outside') . ']') + $this->app->states;

				$permit = new Document();
				$permit->retrieve_by('document_key', 'wholesale-permit');

				$certificate = new Document();
				$certificate->retrieve_by('document_key', 'florida-certificate');

				$languages = array(
					'en' => $this->lng->text('wholesaler:lang_english'),
					'es' => $this->lng->text('wholesaler:lang_spanish'),
					'bt' => $this->lng->text('wholesaler:lang_both'),
				);

				$title = $this->lng->text('account:title');
				$page_args = array_merge($args, array(
					'meta_title' => $title,
					'body_id' => 'body_wholesale',

					'title' => $title,
					'object' => $user,
					'wholesaler' => $wholesaler,
					'user_id' => ($is_admin) ? $user_id : '',
					'countries' => $countries,
					'states' => $states,
					'permit' => $permit,
					'certificate' => $certificate,
					'fiscal_years' => $this->app->fiscal_years,
					'languages' => $languages,
					'error_msg' => $wholesaler_msg['error'],
					'success_msg' => $wholesaler_msg['success'],
					'active' => $active,
				));
				$page_args = array_merge($page_args, $this->tpl->get_view('user/account_ws', $page_args));
				$this->tpl->page_draw($page_args);
			} else {
				// not wholesale yet?
				header('Location: ' . $this->app->go('User/account'));
				exit;
			}
		} else {
			// not logged
			header('Location: ' . $this->app->go('Home'));
			exit;
		}
	}


	protected function run_registered($args)
	{
		if ($this->app->user_id) {

			$user = new User($this->app->user_id);
			$wholesaler = new Wholesaler();
			$wholesaler->retrieve_by('user_id', $this->app->user_id);
			$wholesaler->set_status('ws_approved');
			$wholesaler->update();
			// TODO: more conditions
			//$area = array_shift($args);

			//$key = ($area == 'wholesaler') ? 'registered_ws' : 'registered';

			//$doc = new Document();
			//$doc->retrieve_by('document_key', $key);
			//$title = $doc->get_title();
			//$text = $doc->get_content();

			$title = $this->lng->text('wholesaler:signup');
			$header = $this->lng->text('wholesaler:data');
			//$subheader1 = $this->lng->text('wholesaler:data_sh');
			//$subheader2 = $this->lng->text('wholesaler:data_sh_2');
			$subheader1 = "";
			$subheader2 = "";

			if (isset($args['second'])) {
				$header = $this->lng->text('wholesaler:file_skip');
			}

			if (isset($args['final']) && $args['final']) {
				$header = $this->lng->text('wholesaler:file_save_h');
				$subheader1 = $this->lng->text('wholesaler:file_save_sb1');
				$subheader2 = $this->lng->text('wholesaler:file_save_sb2');
			}

			$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_user',
				'title' => $title,
				//'text' => html_entity_decode($text),
				'header' => $header,
				'subheader1' => $subheader1,
				'subheader2' => $subheader2,
			));
			$page_args = array_merge($page_args, $this->tpl->get_view('user/registered', $page_args));
			$this->tpl->page_draw($page_args);
		} else {
			// Must be logged
			header('Location: ' . $this->app->go('Home'));
			exit;
		}
	}

	protected function run_address_edit($args)
	{
		$id = array_shift($args);

		$address_msg = array('error' => '', 'success' => '');
		if (isset($_SESSION['address_msg'])) {
			$address_msg = $_SESSION['address_msg'];
			unset($_SESSION['address_msg']);
			if ($address_msg['error']) {
				$address = unserialize($_SESSION['address_var']);
				unset($_SESSION['address_var']);
			}
		} else {
			$address = new UserAddress($id);
		}

		$user = $this->app->user;
		$wholesaler = new Wholesaler();
		$wholesaler->retrieve_by('user_id', $user->get_id());

		$title = $this->lng->text('account:title');
		$subtitle = $this->lng->text(($address->get_id()) ? 'addresses:address_edit' : 'addresses:new');

		$page_args = array_merge($args, array(
			'meta_title' => $title,
			'body_id' => 'body_addresses',

			'title' => $title,
			'subtitle' => $subtitle,
			'object' => $address,
			'wholesaler' => $wholesaler,
		));
		$page_args = array_merge($page_args, $this->tpl->get_view('user/address_edit', $page_args));
		$this->tpl->page_draw($page_args);
	}

	protected function run_addresses($args)
	{
		$action = array_shift($args);

		if ($action == 'edit') {
			$this->run_address_edit($args);
		} else {
			$user = $this->app->user;
			$address_msg = array('error' => '', 'success' => '');

			if (isset($_SESSION['address_msg'])) {
				$address_msg = $_SESSION['address_msg'];
				unset($_SESSION['address_msg']);
			}

			$wholesaler = new Wholesaler();
			$wholesaler->retrieve_by('user_id', $user->get_id());

			$addresses = new UserAddress();
			$addresses->set_paging(1, 0, '`user_address_id` DESC', array(
				"`user_id` = {$user->get_id()}",
			));

			$edit_url = $this->app->go($this->app->module_key . '/account', false, '/addresses/edit/');
			$remove_url = $this->app->go($this->app->module_key, false, '/address_remove/');

			$title = $this->lng->text('account:title');
			$page_args = array_merge($args, array(
				'meta_title' => $title,
				'body_id' => 'body_addresses',

				'title' => $title,
				'object' => $user,
				'wholesaler' => $wholesaler,
				'addresses' => $addresses,
				'edit_url' => $edit_url,
				'remove_url' => $remove_url,
			));
			$page_args = array_merge($page_args, $this->tpl->get_view('user/addresses', $page_args));
			$this->tpl->page_draw($page_args);
		}
	}


	protected function run_orders($args)
	{
		$user = $this->app->user;

		$wholesaler = new Wholesaler();
		$wholesaler->retrieve_by('user_id', $user->get_id());

		$sales = new Sale();
		$sales->set_user_id($user->get_id());
		$sales->set_status('st_new');
		$sales->set_paging(1, 0, '`sale_id` DESC');

		$product = new Product();
		$sale_products = new SaleProduct();/*

		while ($sales->list_paged()) {
			echo "sale id: ". $sales->get_id();
			echo "<br>";
			$sale_products->set_sale_id($sales->get_id());
			$sale_products->set_paging(1,0,0);
			while ($sale_products->list_paged_s()) {
				echo "id: " . $sale_products->get_id();
				echo "<br>";
			}
		}die;
 */

		$title = $this->lng->text('account:title');
		$page_args = array_merge($args, array(
			'meta_title' => $title,
			'body_id' => 'body_orders',

			'title' => $title,
			'object' => $user,
			'wholesaler' => $wholesaler,
			'sales' => $sales,
			'saleProducts' => $sale_products,
			'product' => $product,
		));
		$page_args = array_merge($page_args, $this->tpl->get_view('user/orders', $page_args));
		$this->tpl->page_draw($page_args);
	}

	protected function run_final(){
		$title = $this->lng->text('wholesaler:signup');
		$header = $this->lng->text('wholesaler:file_save_h');
		$subheader1 = $this->lng->text('wholesaler:file_save_sb1');
		$subheader2 = $this->lng->text('wholesaler:file_save_sb2');

		$page_args = [
			'meta_title' => $title,
			'body_id' => 'body_user',
			'title' => $title,
			'header' => $header,
			'subheader1' => $subheader1,
			'subheader2' => $subheader2,
		];

		$page_args = array_merge($page_args, $this->tpl->get_view('user/final', $page_args));
		$this->tpl->page_draw($page_args);
	}

	protected function run_save($args = false)
	{
		$save = $this->get_input('action', '');
		switch ($save) {
			case 'register':
				$this->save_register($args);
				break;
			case 'register_ws':
				$this->save_register_ws($args);
				break;
			case 'register_ws_files':
				$this->save_register_ws_files($args);
				break;
			case 'account':
				$this->save_account($args);
				break;
			case 'account_ws':
				$this->save_account_ws($args);
				break;
			case 'address':
				$this->save_address($args);
				break;

			default:
				header('Location: ' . $this->app->go('Home'));
				exit;
		}
	}

	private function save_address($args)
	{
		if ($this->app->user_id) {
			$data = array(
				'ship_last_name'	=> $this->get_input('ship_last_name', '', true),
				'ship_address'		=> $this->get_input('ship_address', '', true),
				'ship_zip'			=> $this->get_input('ship_zip', '', true),
				'ship_city'			=> $this->get_input('ship_city', '', true),
				'ship_state'		=> $this->get_input('ship_state', '', true),
				'ship_phone'		=> $this->get_input('ship_phone', '', true),

				'id'				=> $this->get_input('id', 0),
			);

			$error_fields = $this->validate_data($data, array(
				'ship_last_name' 	=> array('string', false, 1),
				'ship_address' 		=> array('string', false, 1),
				'ship_zip' 			=> array('string', false, 1),
				'ship_city' 		=> array('string', false, 1),
				'ship_state' 		=> array('string', false, 1),
				'ship_phone' 		=> array('string', false, 1),
			));

			$error = $this->missing_fields($error_fields);

			$object = new UserAddress($data['id']);

			$object->set_user_id($this->app->user_id);
			$object->set_ship_last_name($data['ship_last_name']);

			$object->set_ship_address($data['ship_address']);
			$object->set_ship_city($data['ship_city']);
			$object->set_ship_state($data['ship_state']);
			$object->set_ship_zip($data['ship_zip']);
			$object->set_ship_country($data['ship_country']);
			$object->set_ship_phone($data['ship_phone']);
			$object->set_active(1);

			if (sizeof($error)) {
				$error_msgs = $this->lng->all();
				//$error_msg = preg_replace('#^([A-Z_:]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error);

				$error_msg = preg_replace_callback('#^([A-Z_]+)$#', function ($m) use ($error_msgs) {
					return (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];
				}, $error);

				$_SESSION['address_msg'] = array('error' => $error_msg, 'success' => '');
				$_SESSION['address_var'] = serialize($object);

				header('Location: ' . $this->app->go($this->app->module_key . '/account', false, '/addresses/edit/' . $object->get_id()));
				exit;
			} else {
				$edit = $object->get_id();

				// save the record
				$object->update();

				$_SESSION['address_msg'] = array('success' => $this->lng->text(($edit) ? 'account:saved' : 'addresses:added'), 'error' => '');

				header('Location: ' . $this->app->go($this->app->module_key . '/account', false, '/addresses'));
				exit;
			}
		}
	}

	private function save_register_ws($args)
	{
		if ($this->app->user_id) {
			$data = array(
				//'first_name'		=> $this->get_input('first_name', '', true, 'caps'),
				//'last_name'			=> $this->get_input('last_name', '', true, 'caps'),
				'username'				=> $this->get_input('username', '', true),
				'password'				=> $this->get_input('user_password', '', true),

				'company'			=> $this->get_input('company', '', true, 'caps'),
				'website'			=> $this->get_input('website', '', true, 'lower'),
				'business_type'		=> $this->get_input('business_type', '', true),
				'trade_id'			=> $this->get_input('trade_id', '', true),
				'how_hear'			=> $this->get_input('how_hear', '', true),
				'language'			=> $this->get_input('language', '', true),

				'bill_address'		=> $this->get_input('bill_address', '', true),
				'bill_city'			=> $this->get_input('bill_city', '', true, 'caps'),
				'bill_state'		=> $this->get_input('bill_state', '', true),
				'bill_zip'			=> $this->get_input('bill_zip', '', true),
				'bill_country'		=> $this->get_input('bill_country', 0),
				'bill_phone'		=> $this->get_input('bill_phone', '', true),
				//'bill_fax'			=> $this->get_input('bill_fax', '', true),

				'wholesaler_number'	=> $this->get_input('wholesaler_number', '', true),
			);
			//print_r($data);
			//exit;
			$error_fields = $this->validate_data($data, array(
				//'first_name' 	=> array('string', false, 1),
				//'last_name' 	=> array('string', false, 1),

				'company' 		=> array('string', false, 1),
				//'business_type'	=> array('string', false, 1),
				//'trade_id' 		=> array('string', false, 1),

				'bill_address' 	=> array('string', false, 1),
				'bill_country' 	=> array('string', false, 1),
				'bill_state' 	=> array('string', false, 1),
				'bill_city' 	=> array('string', false, 1),
				'bill_zip' 		=> array('string', false, 1),
				'bill_phone' 	=> array('phone', false),
				'how_hear' 		=> array('string', false, 1),
				'language' 		=> array('string', false, 1),
				//'username' 				=> array('string', false, $this->app->username_len_min, $this->app->username_len_max),
				'password'				=> array('string', false, $this->app->user_password_len_min, $this->app->user_password_len_max),
			));
			//print_r($error_fields);
			//exit;

			$myfile = fopen("./data/registrations2.txt", "a");
			$txt = json_encode($data) . "\n";
			fwrite($myfile, $txt);
			fclose($myfile);

			$error = $this->missing_fields($error_fields);

			$user = new User($this->app->user_id);
			$object = new Wholesaler();
			if ($user) {
				$object->retrieve_by('user_id', $user->get_id());
			}
			$object->set_missing_fields($error_fields);

			// fill the object

			$object->set_user_id($this->app->user_id);

			//$object->set_first_name($data['first_name']);
			$object->set_first_name($user->get_first_name());
			//$object->set_last_name($data['last_name']);
			$object->set_last_name($user->get_last_name());

			$object->set_company($data['company']);
			$object->set_website($data['website']);
			$object->set_business_type($data['business_type']);
			$object->set_trade_id($data['trade_id']);
			$object->set_bill_address($data['bill_address']);
			$object->set_bill_country($data['bill_country']);
			$object->set_bill_state($data['bill_state']);
			$object->set_bill_city($data['bill_city']);
			$object->set_bill_zip($data['bill_zip']);
			$object->set_bill_phone($data['bill_phone']);
			$object->set_bill_fax($data['bill_fax']);

			$object->set_how_hear($data['how_hear']);
			$object->set_language($data['language']);
			$object->set_status('ws_approved');
			$object->set_active(1);
			$object->set_ship_same(1);
			$object->set_password($data['password']);

			$object->set_wholesaler_number($data['wholesaler_number']);

			if (sizeof($error)) {
				// TODO: save attach anyway?

				$error_msgs = $this->lng->all();
				/* $error_msg = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error); */
				$error_msg = preg_replace_callback('#^([A-Z_]+)$#', function ($m) use ($error_msgs) {
					return (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];
				}, $error);

				$_SESSION['wholesaler_msg'] = array('error' => $error_msg, 'success' => '');
				$_SESSION['wholesaler_var'] = serialize($object);

				header('Location: ' . $this->app->go($this->app->module_key . '/wholesaler'));
				exit;
			} else {
				// save the record
				if ($data['username'] != '') {
					$user->set_username($data['username']);
				}
				$user->set_password($data['password']);
				$user->update();
				$object->update();

				$this->send_welcome_email($user);

				$this->save_ws_attachs($object);

				// save again
				$object->update();


				$permit = new Document();
				$permit->retrieve_by('document_key', 'wholesale-permit');

				$certificate = new Document();
				$certificate->retrieve_by('document_key', 'florida-certificate');
				$title = $this->lng->text('wholesaler:title');
				$page_args = array_merge(['wholesaler'],$args, array(
					'meta_title' => $title,
					'body_id' => 'body_register',

					'title' => $title,
					'object' => $user,
					'wholesaler' => $object,
					'permit' => $permit,
					'certificate' => $certificate,
					'fiscal_years' => $this->app->fiscal_years,
					'show_warning' => false,
				));
				//$page_args = array_merge($page_args, $this->tpl->get_view('user/register_ws', $page_args));
				//$this->tpl->page_draw($page_args);

				$this->run_registered($page_args);
				exit;
				//header('Location: ' . $this->app->go($this->app->module_key . '/registered', false, '/wholesaler'));
				//exit;
			}
		} else {
			// Must be logged
			header('Location: ' . $this->app->go('Home'));
			exit;
		}
	}

	private function save_register_ws_files($args)
	{
		if ($this->app->user_id) {
			$data = array(
				'wholesaler_number'	=> $this->get_input('wholesaler_number', '', true),
			);
			$user = new User($this->app->user_id);
			$object = new Wholesaler();
			if ($user) {
				$object->retrieve_by('user_id', $user->get_id());
			}

			$error_fields = $this->validate_data($data, [
				'wholesaler_number' 		=> array('string', false, 1),
			]);
			//print_r($error_fields);
			//exit;
			$error = $this->missing_fields($error_fields);
			$object->set_missing_fields($error_fields);

			if (sizeof($error)) {
				$error_msgs = $this->lng->all();

				$error_msg = preg_replace_callback('#^([A-Z_]+)$#', function ($m) use ($error_msgs) {
					return (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];
				},
					$error
				);

				$_SESSION['wholesaler_msg'] = array('error' => $error_msg, 'success' => '');
				$_SESSION['wholesaler_var'] = serialize($object);
			}

			if ($data['wholesaler_number']) {
				// fill the object
				$object->set_wholesaler_number($data['wholesaler_number']);
				//$object->set_status('ws_approved');

				// save the record
				$object->update();

				$this->save_ws_attachs($object);

				// save again
				$object->update();

				/*$page_args = [
					'meta_title' => $this->lng->text('wholesaler:signup'),
					'body_id' => 'body_wholesaler_registered',
					'title' => $this->lng->text('wholesaler:signup'),
					'second' => true,
					'wholesaler' => $object,
				];*/

				$this->run_final();
			} else {
				$permit = new Document();
				$permit->retrieve_by('document_key', 'wholesale-permit');

				$certificate = new Document();
				$certificate->retrieve_by('document_key', 'florida-certificate');
				$title = $this->lng->text('wholesaler:title');
				$page_args = array_merge(['wholesaler'], $args, array(
					'meta_title' => $title,
					'body_id' => 'body_register',

					'title' => $title,
					'object' => $user,
					'wholesaler' => $object,
					'permit' => $permit,
					'certificate' => $certificate,
					'fiscal_years' => $this->app->fiscal_years,
					'show_warning' => false,
					'second' => true,
				));
				//$page_args = array_merge($page_args, $this->tpl->get_view('user/register_ws', $page_args));
				//$this->tpl->page_draw($page_args);

				$this->run_registered($page_args);
				exit;

			}
		}
	}

	private function save_account($args)
	{
		if ($this->app->user_id) {
			$data = array(
				'password'		=> $this->get_input('user_password', '', true),
				'email'			=> $this->get_input('email', '', false, 'lower'),
				'email_repeat'	=> $this->get_input('email2', '', false, 'lower'),
				'newsletter'	=> $this->get_input('newsletter', 0),

				'id'			=> $this->get_input('id', 0),
			);

			$error_fields = $this->validate_data($data, array(
				'password'		=> array('string', false, 6, 16),
				'email' 		=> array('string', false, 1, 100),
			));

			$error = $this->missing_fields($error_fields);
			$this->validate_email($data['email'], $error_fields, $error, 'email');

			$object = new User($data['id']);
			$prev_email = false;

			if ($data['email'] != $object->get_email()) {
				if ($data['email'] != $data['email_repeat']) {
					$error[] = 'EMAILS_DONT_MATCH';
				} else {
					$prev_email = $object->get_email();
				}
			}
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_email($data['email']);
			$object->set_email_repeat($data['email_repeat']);

			$change_newsletter = false;
			if ($data['newsletter'] != $object->get_newsletter()) {
				$change_newsletter = true;
			}
			$object->set_newsletter($data['newsletter']);

			$change_password = false;
			if ($data['password'] && $data['password'] != '````````````') {
				$object->set_password($data['password']);
				$change_password = true;
			}

			if (sizeof($error)) {
				$this->show_user_error($object, $error, '', '/account');
			} else {
				if ($prev_email) {
					$existing = $object->verify($object->get_username(), $object->get_email(), $object->get_id());
					if (in_array('email', $existing)) {
						$error[] = 'ERROR_EMAIL_EXISTS';
						$error_fields[] = 'email';
					}
				}

				if (sizeof($error)) {
					$this->show_user_error($object, $error, '', '/account');
				} else {
					// save the record
					$object->update();

					if ($change_password && isset($_COOKIE['session'])) {
						// update cookie
						setcookie('session', md5($data['password']) . $object->get_username(), time() + 60 * 60 * 24 * 100, '/');
					}

					// suscription
					if ($prev_email) {
						// remove previous
						$contact = new Contact();
						$contact->remove_by_mail($prev_email, 'suscriber');
					}
					if ($object->get_newsletter()) {
						if ($change_newsletter) {
							$contact = new Contact();
							$contact->set_section_key('suscriber');
							$contact->set_category_key('user');
							$contact->set_first_name($object->get_username());
							$contact->set_email($object->get_email());
							$contact->set_active(1);
							$contact->update();
						}
					} else {
						if ($change_newsletter && !$prev_email) {
							// remove previous if it didn't be changed
							$contact = new Contact();
							$contact->remove_by_mail($object->get_email(), 'suscriber');
						}
					}

					$_SESSION['user_msg'] = array('success' => $this->lng->text('account:success'), 'error' => '', 'captcha_error' => '');


					$wholesaler = new Wholesaler();
					$wholesaler->retrieve_by('user_id', $object->get_id());

					if (!$wholesaler->get_id()) {
						$this->app->redirect($this->app->go($this->app->module_key . '/wholesaler'));
					} else {
						$this->app->redirect($this->app->go($this->app->module_key . '/account'));
					}
				}
			}
		} else {
			// Must be logged
			header('Location: ' . $this->app->go('Home'));
			exit;
		}
	}


	private function save_account_ws($args)
	{
		$is_admin = false;
		if ($user_id = array_shift($args)) {
			// administrator editing?
			if ($this->app->user_admin) {
				$is_admin = true;
			} else {
				// got id but not admin
				$user_id = $this->app->user_id;
			}
		} else {
			$user_id = $this->app->user_id;
		}

		if ($user_id) {
			$data = array(
				//'first_name'		=> $this->get_input('first_name', '', true, 'caps'),
				//'last_name'			=> $this->get_input('last_name', '', true, 'caps'),

				'company'			=> $this->get_input('company', '', true, 'caps'),
				'website'			=> $this->get_input('website', '', true, 'lower'),
				'business_type'		=> $this->get_input('business_type', '', true),
				'trade_id'			=> $this->get_input('trade_id', '', true),
				'how_hear'			=> $this->get_input('how_hear', '', true),
				'language'			=> $this->get_input('language', '', true),

				'bill_address'		=> $this->get_input('bill_address', '', true),
				'bill_city'			=> $this->get_input('bill_city', '', true, 'caps'),
				'bill_state'		=> $this->get_input('bill_state', '', true),
				'bill_zip'			=> $this->get_input('bill_zip', '', true),
				'bill_country'		=> $this->get_input('bill_country', 0),
				'bill_phone'		=> $this->get_input('bill_phone', '', true),
				'bill_fax'			=> $this->get_input('bill_fax', '', true),

				'ship_same'			=> $this->get_input('ship_same', 0),

				'ship_company'		=> $this->get_input('ship_company', '', true, 'caps'),
				'ship_first_name'	=> $this->get_input('ship_first_name', '', true, 'caps'),
				'ship_last_name'	=> $this->get_input('ship_last_name', '', true, 'caps'),

				'ship_address'		=> $this->get_input('ship_address', '', true),
				'ship_city'			=> $this->get_input('ship_city', '', true, 'caps'),
				'ship_state'		=> $this->get_input('ship_state', '', true),
				'ship_zip'			=> $this->get_input('ship_zip', '', true),
				'ship_country'		=> $this->get_input('ship_country', 0),
				'ship_phone'		=> $this->get_input('ship_phone', '', true),
				'ship_fax'			=> $this->get_input('ship_fax', '', true),

				'wholesaler_number'	=> $this->get_input('wholesaler_number', '', true),

			);

			$error_fields = $this->validate_data($data, array(
				//'first_name' 		=> array('string', false, 1),
				//'last_name' 		=> array('string', false, 1),

				'company' 			=> array('string', false, 1),
				//'business_type'		=> array('string', false, 1),
				//'trade_id' 			=> array('string', false, 1),

				'bill_address' 		=> array('string', false, 1),
				'bill_city' 		=> array('string', false, 1),
				'bill_state' 		=> array('string', false, 1),
				'bill_zip' 			=> array('string', false, 1),
				'bill_phone' 		=> array('string', false, 1),
			));

			$error = $this->missing_fields($error_fields);

			$object = new Wholesaler();
			$object->retrieve_by('user_id', $user_id);
			$object->set_missing_fields($error_fields);

			// fill the object

			$object->set_user_id($user_id);

			$object->set_first_name($data['first_name']);
			$object->set_last_name($data['last_name']);

			$object->set_company($data['company']);
			$object->set_website($data['website']);
			$object->set_business_type($data['business_type']);
			$object->set_trade_id($data['trade_id']);
			$object->set_bill_address($data['bill_address']);
			$object->set_bill_city($data['bill_city']);
			$object->set_bill_state($data['bill_state']);
			$object->set_bill_zip($data['bill_zip']);
			$object->set_bill_country($data['bill_country']);
			$object->set_bill_phone($data['bill_phone']);
			$object->set_bill_fax($data['bill_fax']);

			$object->set_how_hear($data['how_hear']);
			$object->set_language($data['language']);
			$object->set_active(1);

			$object->set_ship_same($data['ship_same']);

			if ($data['ship_same']) {
				$object->set_ship_company($data['company']);
				$object->set_ship_first_name($data['first_name']);
				$object->set_ship_last_name($data['last_name']);

				$object->set_ship_address($data['bill_address']);
				$object->set_ship_city($data['bill_city']);
				$object->set_ship_state($data['bill_state']);
				$object->set_ship_zip($data['bill_zip']);
				$object->set_ship_country($data['bill_country']);
				$object->set_ship_phone($data['bill_phone']);
				$object->set_ship_fax($data['bill_fax']);
			} else {
				$object->set_ship_company($data['ship_company']);
				$object->set_ship_first_name($data['ship_first_name']);
				$object->set_ship_last_name($data['ship_last_name']);

				$object->set_ship_address($data['ship_address']);
				$object->set_ship_city($data['ship_city']);
				$object->set_ship_state($data['ship_state']);
				$object->set_ship_zip($data['ship_zip']);
				$object->set_ship_country($data['ship_country']);
				$object->set_ship_phone($data['ship_phone']);
				$object->set_ship_fax($data['ship_fax']);
			}

			if (sizeof($error)) {
				$error_msgs = $this->lng->all();
				/* $error_msg = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error); */
				$error_msg = preg_replace_callback('#^([A-Z_]+)$#', function ($m) use ($error_msgs) {
					return (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];
				}, $error);

				$_SESSION['wholesaler_msg'] = array('error' => $error_msg, 'success' => '');
				$_SESSION['wholesaler_var'] = serialize($object);
			} else {
				// save the record
				$object->update();

				$this->save_ws_attachs($object);

				// save again
				$object->update();

				$_SESSION['wholesaler_msg'] = array('success' => $this->lng->text('account:saved'), 'error' => '');
			}

			header('Location: ' . $this->app->go($this->app->module_key . '/account', false, '/wholesaler/' . (($is_admin) ? $user_id : '')));
			exit;
		} else {
			// Must be logged
			header('Location: ' . $this->app->go('Home'));
			exit;
		}
	}

	private function save_register($args)
	{
		unset($_SESSION['user_phone']);
		unset($_SESSION['user_company']);

		// if ($this->check_form_token('register')) {
		if (true) {
			//require_once($this->cfg->path->lib . '/RecaptchaLib/recaptchalib.php');

			$data = array(
				'agreed'				=> $this->get_input('agreed', 0),

				'first_name'			=> $this->get_input('first_name', '', true),
				'last_name'				=> $this->get_input('last_name', '', true),
				'username'				=> $this->get_input('username', '', true),
				'password'				=> $this->get_input('user_password', '', true),
				'email'					=> $this->get_input('email', '', false, 'lower'),

				'newsletter'			=> $this->get_input('newsletter', 1),
				'wholesale'				=> $this->get_input('wholesale', 0),
				'phone'					=> $this->get_input('phone', '',true),
				'company'				=> $this->get_input('company', ""),
			);

			if ($data['password'] == '') {
				$data['password'] = rand(100000,9999999999);
				$data['password'] = substr(rand(100000,9999999999),0,10);
			}
			if ($data['username'] == '') {
				$data['username'] = str_replace(" ", "_", strtolower($data['first_name'])) . str_replace(" ", "_", strtolower($data['last_name']));
				$data['username'] = substr($data['username'],0,20);
			}

			$data['agreed'] = ($data['agreed'] == 1) ? 1 : 'None';

			$error_fields = $this->validate_data($data, array(
				'agreed' 				=> array('num', false, 1),
				'username' 				=> array('string', false, $this->app->username_len_min, $this->app->username_len_max),
				'password'				=> array('string', false, $this->app->user_password_len_min, $this->app->user_password_len_max),
				'email' 				=> array('string', false, 1, 100),
				'first_name' 			=> array('string', false, 1, 100),
				'last_name' 			=> array('string', false, 1, 100),
				'phone' 				=> array('phone', false),
				'company' 				=> array('string', false, 1, 100),
			));

			$myfile = fopen("./data/registrations.txt", "a");
			$txt = 'date: '. date('Y-m-d') . ' ' .json_encode($data)."\n";
			fwrite($myfile, $txt);
			fclose($myfile);

			$error = $this->missing_fields($error_fields);

			$this->validate_email($data['email'], $error_fields, $error, 'email');
			/*if ($data['email'] != $data['email_repeat']) {
				$error[] = 'EMAILS_DONT_MATCH';
				$error_fields[] = 'email';
				$error_fields[] = 'email_repeat';
			}*/

			// captcha
			// if (!sizeof($error)) {
			// 	if (!$this->valid_captcha()) {
			// 		$error[] = 'INVALID_CAPTCHA';
			// 	}
			// }

			$object = new User();
			$object->set_missing_fields($error_fields);

			// fill the object
			$object->set_agreed($data['agreed']);
			$object->set_first_name($data['first_name']);
			$object->set_last_name($data['last_name']);
			$object->set_username($data['username']);
			$object->set_email($data['email']);
			$object->set_email_repeat($data['email']);
			$object->set_password($data['password']);
			$object->set_role_id(Role::enum('user'));

			$object->set_newsletter($data['newsletter']);
			$object->set_active(1);

			$wholesaler = new Wholesaler();
			$wholesaler->set_company($data['company']);
			$wholesaler->set_bill_phone($data['phone']);
			$wholesaler->set_first_name($data['first_name']);
			$wholesaler->set_last_name($data['last_name']);
			$_SESSION['user_phone'] = $data['phone'];
			$_SESSION['user_company'] = $data['company'];

			// if (sizeof($error)) {
			if (false) {
				$this->show_user_error($object, $error, '/register');
			} else {
				$existing = $object->verify($data['username'], $data['email']);
				if ($existing['username']) {
					//$error[] = 'ERROR_USERNAME_EXISTS';
					//$error_fields[] = 'username';

					do {
						$username = $data['username'] . rand(1, 9999);
						$object->set_username($username);
					}
					while ($object->verify($username, $data['email'])['username']);
				}
				if ($existing['email']) {
					$error[] = 'ERROR_EMAIL_EXISTS';
					$error_fields[] = 'email';
				}

				// if (sizeof($error)) {
				if (false) {
					$object->set_missing_fields($error_fields);
					$this->show_user_error($object, $error, '/register');
				} else {
					// save the record
					$object->update();
					$this->send_verification_email($object);

					$wholesaler->set_user_id($object->get_id());
					$wholesaler->set_status("ws_pending");
					$wholesaler->set_active(1);
					$wholesaler->update();
					unset($_SESSION['user_phone']);
					unset($_SESSION['user_company']);

					// suscription
					if ($object->get_newsletter()) {
						$contact = new Contact();
						$contact->set_section_key('suscriber');
						$contact->set_category_key('user');
						$contact->set_first_name($object->get_username());
						$contact->set_email($object->get_email());
						$contact->set_active(1);
						$contact->update();
					}

					// login
					//if ($user_id = $user->login($data['username'], $data['password'], $_SERVER['REMOTE_ADDR'])) {
					if ($this->new_session($object->get_username(), $data['password'], true)) {
						// TODO: keep shopping cart ID
						session_destroy();
						session_start();
						//$_SESSION['username'] = $data['username'];

					} else {
						// what happened?
						$error = array('ERROR:REGISTER_LOGIN_FAILED: ' . $data['username'] . '|' . $data['password']);
						header('Location: ' . $this->app->go('Home'));
						exit;
					}
					// wholesaler
					//header('Location: ' . $this->app->go($this->app->module_key . '/wholesaler'));
					$this->email_sent();
					exit;
				}
			}
		} else {
			// invalid token
			$object = new User();
			$error = array('ERROR:RESET_INVALID_KEY');

			$this->show_user_error($object, $error, false, '/register');
		}
	}

	private function show_user_error($object, $error, $target)
	{
		$error_msgs = $this->lng->all();
		//$error_msg = preg_replace('#^([A-Z_:]+)$#e', "(!empty(\$error_msgs['\\1'])) ? \$error_msgs['\\1'] : '\\1'", $error);

		$error_msg = preg_replace_callback('#^([A-Z_]+)$#', function ($m) use ($error_msgs) {
			return (!empty($error_msgs[$m[1]])) ? $error_msgs[$m[1]] : $m[1];
		}, $error);

		$_SESSION['user_msg'] = array('error' => $error_msg, 'success' => '');
		$_SESSION['user_var'] = serialize($object);

		header('Location: ' . $this->app->go($this->app->module_key . $target));
		exit;
	}

	private function save_ws_attachs(&$object)
	{
		$permit_images = $object->get_wholesaler_image();
		$certificate_images = $object->get_certificate_image();

		foreach ($this->app->fiscal_years as $year) {
			// permit
			$folder = $this->cfg->path->data . '/user/permit/' . $year;
			$filename = sprintf('%06d-permit-' . $year, $object->get_user_id());
			$result = $this->save_attach($folder, 'wholesaler_image_' . $year, $this->cfg->setting->upl_extensions, $filename, $original_name);
			if ($result === true) {
				//$object->set_wholesaler_image($original_name);
				$permit_images[(string)$year] = $original_name;
			} else {
				error_log('Permit Image Error UserID ' . $object->get_user_id() . ': ' . $result);
			}

			// certificate
			$folder = $this->cfg->path->data . '/user/certificate/' . $year;
			$filename = sprintf('%06d-certif-' . $year, $object->get_user_id());
			$result = $this->save_attach($folder, 'certificate_image_' . $year, $this->cfg->setting->upl_extensions, $filename, $original_name);
			if ($result === true) {
				//$object->set_certificate_image($original_name);
				$certificate_images[(string)$year] = $original_name;
			} else {
				error_log('Certificate Image Error UserID ' . $object->get_user_id() . ': ' . $result);
			}
		}

		$object->set_wholesaler_image($permit_images);
		$object->set_certificate_image($certificate_images);
	}

	protected function send_verification_email(User &$user) {
		$act_key = $this->get_uid($user->get_id());
		$act_limit = $this->utl->date_modify(date('Y-m-d H:i:s'), '+2 day', false, 'Y-m-d H:i:s');
		$act_limit_txt = $this->utl->date_format($act_limit, '-3:00', $this->app->datetime_format);

		$user->set_activation_key($act_key);
		$user->set_activation_limit($act_limit);
		$user->update();

		$views = $this->tpl->get_view('_email/confirm_mail', array(
			'name' => $user->get_first_name(),
			'lastname' => $user->get_last_name(),
			'sitename' => $this->cfg->setting->site,
			'url' => $this->app->go($this->app->module_key, false, '/confirm/' . $act_key),
			'limit' => $act_limit_txt,
		));

		$this->utl->notify(array(
			'to' => array($user->get_email() => $user->get_username()),
			'subject' => $views['subject'],
			'body' => $views['body']
		));
	}

	protected function send_welcome_email(User &$user) {
		$views = $this->tpl->get_view('_email/welcome_email', [
			'name' => $user->get_first_name(),
			'lastname' => $user->get_last_name(),
			'sitename' => $this->cfg->setting->site,
			'url' => $this->app->go('Home'),
		]);
		$this->utl->notify(array(
			'to' => array($user->get_email() => $user->get_username()),
			'subject' => $views['subject'],
			'body' => $views['body']
		));
	}

	protected function run_confirm($args = []) {
		$act_key = $args[0];

		$today = date('Y-m-d H:i:s');

		if ($act_key != '') {
			$user = new User();
			$user->retrieve_by_activation_key([$act_key, $today]);
			//$user->retrieve_by_activation_key([$act_key]);
			if ($user->get_id()) {
				$user->set_confirmed(1);
				$user->update();

				$this->app->user = $user;
				$this->app->user_id = $user->get_id();

				$wholesaler = new Wholesaler();
				$wholesaler->retrieve_by_user($user->get_id());
				if ($wholesaler->get_status() != 'ws_approved') {
					$wholesaler->set_taxable('tx_yes');
					$wholesaler->update();
				}

				/*$page_args = [
					'meta_title' => $this->lng->text('user_confirm_title'),
					'body_id' => 'body_confirmed',
					'object' => $user,
					'title' => $this->lng->text('user_confirm_title'),
				];
				$page_args = array_merge($page_args, $this->tpl->get_view('user/confirmed', $page_args));

				$this->tpl->page_draw($page_args);*/
				//$args = array_merge(['wholesaler'], $args, ['active' => true]);
				//$this->run_account($args);
				//$this->run_register_ws($args);
				header('Location: ' . $this->app->go('User/wholesaler'));
			}
		}
	}

	protected function run_ajax_confirm() {
		$user = $this->app->user;
		$this->send_verification_email($user);
		echo json_encode(['success' => true, 'id' => $user->get_id()]);
	}

	protected function email_sent() {
		$page_args = [
			'meta_title' => $this->lng->text('user:email:sent:title'),
			'body_id' => 'body_email_sent',
			'title' => $this->lng->text('user:email:sent:title'),
		];
		$page_args = array_merge($page_args, $this->tpl->get_view('user/email_sent', $page_args));

		$this->tpl->page_draw($page_args);
	}
}
