<?php
class MainCtrl extends CustomCtrl {

	public function run($args = array()) {
		$this->run_default($args, $action = '');
	}


	protected function run_default($args, $action) {
		//var_dump($args);
		//var_dump($action);die;
		// Session and login
		session_start();

		$this->init_app_settings();

		if ($this->app->module_key == 'Session') {
			$user_id = $_SESSION[md5($_SERVER['REMOTE_ADDR'])];
			$this->init_user($user_id);

			// captured in SessionCtrl --------------------------------------------

		} else if (in_array('logout', $args)) {
			$page_full = str_replace('/logout', '', $this->app->page_full);
			$_SESSION['logout_target'] = $page_full;

			$this->app->redirect($this->app->go('Session/logout'), false);

		} else if (isset($_SESSION[md5($_SERVER['REMOTE_ADDR'])])) {
			// already a user session ---------------------------------------------

			$user_id = $_SESSION[md5($_SERVER['REMOTE_ADDR'])];
			$this->init_user($user_id);

		} else if ($this->get_cookie('k', '')) {
			// remember cookie found ----------------------------------------------
			if ($_SERVER['HTTP_SMVC_AJAX_REQUEST']) {
				header('HTTP/1.1 403 Forbidden', true, 403);

			} else {
				$_SESSION['remember_target'] = $this->app->page_full;

				$this->app->redirect($this->app->go('Session/remember'));
			}

		} else {
			if ($this->app->user_logged_only) {
				// nothing to do here, keep the url -----------------------------------

				if (in_array($this->app->page_key, array('EmailQueue/dispatch'))) {
					// allowed without login
					// generic user
					$this->init_user(0);

				} else if (!in_array($this->app->page_key, array('Session/login', 'Session/confirm'))) {
					if ($_SERVER['HTTP_SMVC_AJAX_REQUEST']) {
						$this->init_user(0);
						header('HTTP/1.1 401 Unauthorized', true, 401);

					} else {
						$_SESSION['goto'] = $this->app->page_full;

						$this->app->redirect($this->app->go('Session/login'));
					}
				}

			} else {
				// generic user
				$this->init_user(0);
			}
		}

		$this->init_sidebar();
	}


	private function init_user($user_id) {
		$user = new User($user_id);

		$this->app->user = $user;
		$this->app->user_id = $user->get_id();
		$this->app->username = $user->get_username();
		$this->app->user_admin = in_array($user->get_role_id(), array(
				Role::enum('superadmin'),
				Role::enum('administrator'),
				Role::enum('admin_yswp')
			));

		$wholesaler = new Wholesaler();
		$wholesaler->retrieve_by(array('user_id'), array($user->get_id()));
		$this->app->wholesaler = $wholesaler;
		$this->app->wholesaler_id = $wholesaler->get_id();
		$this->app->wholesaler_ok = ($wholesaler->get_status() == 'ws_approved');
		//$this->app->wholesaler_ok = ($wholesaler->get_id());

		// check pending PP
		//if ($user->get_id() && $this->app->module_key != 'Cart') {
		//    $paypal = new Paypal();
		//    if ($token = $paypal->retrieve_pending($user->get_id())) {
		//        // redirect to order
		//        $_SESSION['paypal_token'] = $token;
		//        $token_arr = explode('-', $token);
		//        $_SESSION['sale_id'] = $token_arr[0];
		//        $this->redirect($this->app->go('Cart', false, '/paypal_complete')); // <<<<<<<<<<<<< exit
		//    }
		//}

		// retrieve last incomplete sale, if exist
		//if ($user->get_id() && !isset($_SESSION['sale_id'])) {
		//    $sale = new Sale();
		//    $sale->retrieve_last(array($user->get_id(), 'st_saved'), false);
		//    if ($sale->get_id()) {
		//        $_SESSION['sale_id'] = $sale->get_id();
		//        $this->app->cart_items = $sale->item_count();
		//}

		if ($user->get_id() && $this->utl->get_property('offline', 0)) { //$this->cfg->setting->offline) {
			// only superadmins allowed
			if ($user->get_role_id() != Role::enum('superadmin')) {
				// restart session
				session_destroy();
				session_start();

				$_SESSION['login_var'] = array('offline' => true, 'alert' => 'danger', 'msg' => $this->lng->text('ERROR:OFFLINE_MESSAGE'));

				$this->app->redirect($this->app->go('Session/login'));
			}

		}
	}

	private function init_app_settings() {
		// TODO: move to properties <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

		// login captcha
		// get a key from https://www.google.com/recaptcha/admin/create
		$this->app->captcha_public = '6LfGnp8UAAAAAN7NJRwAdGTwGteBZZg8Q4Hz6yV9'; //'6LeyJx0UAAAAALKlhSgPZ7eSBSTCo7nmSXJ5VzcF';
		$this->app->captcha_secret = '6LfGnp8UAAAAADE5pbozZnGNRTLfoqOaqmD6XOzj'; //'6LeyJx0UAAAAAJUmhxSDj4IKe_SerdfyDsfmapPe';

		// debug
		$this->app->debug = $this->utl->get_property('debug', 0);
		$this->app->debug_sql = array();
		if ($this->app->debug) {
			$this->app->debug_sql = $this->utl->get_property('debug_sql', array());
		}

		// social
		$this->app->social = $this->utl->get_property('social', array());

		// certificates
		$this->app->fiscal_years = $this->utl->get_property('fiscal_years', array()); //array('2016', '2017', '2018', '2019');

		//holidays
		$this->app->holidays = $this->utl->get_property('holidays', array());

		// local_zips for shipping
		$this->app->local_zips = $this->utl->get_property('local_zips', array());

		$this->app->cutoff_time_lbl = '3:00 pm';	// 12 hs
		$this->app->cutoff_time = '15:00:00'; 		// 24 hs

		// date format
		$this->app->date_format = 'm/d/Y';
		$this->app->datetime_format = 'm/d/Y h:i A';
		$this->app->date_picker_format = 'mm/dd/yyyy';
		$this->app->time_format = 'h:i A';
		$this->app->db_date_format = 'Y-m-d';
		$this->app->db_datetime_format = 'Y-m-d H:i';

		// forms
		$this->app->form_security_level = false; //'high';
		// false => no tokens, 'low' => one token per user, 'medium' => one token per form type, 'high' one token per form

		// users
		$this->app->user_logged_only = false;
		$this->app->user_allow_signup = false;
		$this->app->user_allow_reset = true;
		$this->app->user_approval = false; // 'admin', 'link'

		$this->app->user_max_login_attemps = 5;
		$this->app->user_password_len_min = 6;
		$this->app->user_password_len_max = 20;
		$this->app->username_len_min = 6;
		$this->app->username_len_max = 20;

		$this->app->user_show_username_on_reset = false;

		// uploads
		$this->app->file_extensions = 'jpg|jpeg|png|gif|doc|docx|pdf';
		$this->app->xls_extensions = 'xls|xlsx|csv';

		// shipping
		$this->app->ship_url = $this->utl->get_property('ship-url', '');
		$this->app->ship_api_key = $this->utl->get_property('ship-api-key', '');
		$this->app->ship_from = $this->utl->get_property('ship-from', array());
		$this->app->ship_carriers = $this->utl->get_property('ship-carriers', array());
		$this->app->ship_carrier = $this->utl->get_property('ship-carrier', 'UPS');

		$ship_engine = new ShipEngine($this->app->ship_carriers['FEDEX']);
		$ship_engine->setParameter('shipUrl', $this->app->ship_url);
		$ship_engine->setParameter('shipApiKey', $this->app->ship_api_key);
		$ship_engine->setParameter('shipFrom', $this->app->ship_from);
		$this->app->ship_engine = $ship_engine;

		// register
		$document = new Document();
		$document->retrieve_by(array('document_key', 'lang_iso'), array('register-panel', $this->cfg->setting->language));
		$this->app->register_text = html_entity_decode($document->get_content());

		// warning
		$warning = new Document();
		$warning->retrieve_by(array('document_key', 'lang_iso'), array('site-warning', $this->cfg->setting->language));
		if ($text = $warning->get_content()) {
			$this->app->warning = html_entity_decode($text);
		}
		// warning2
		$warning2 = new Document();
		$warning2->retrieve_by(array('document_key', 'lang_iso'), array('site-warning2', $this->cfg->setting->language));
		if ($text = $warning2->get_content()) {
			$this->app->warning2 = html_entity_decode($text);
		}

		// how to buy
		$how_to = new Document();
		$how_to->retrieve_by(array('document_key', 'lang_iso'), array('how-to-buy', $this->cfg->setting->language));
		$this->app->how_to_title = $how_to->get_title();
		$this->app->how_to_text = html_entity_decode($how_to->get_content());

		// Cart
		if (isset($_SESSION['sale_id'])) {
			$sale = new Sale();
			$sale->retrieve($_SESSION['sale_id'], false);
			$this->app->cart_items = $sale->item_count();

		} else {
			$this->app->cart_items = 0;
		}

		// paypal
		$this->app->paypal_sandbox = true;
		if (in_array($this->cfg->setting->domain, array(
				'www.yousendweprint.com',
				'yousendweprint.com',
			))) {
			$this->app->paypal_sandbox = false;
		}

		if ($this->app->paypal_sandbox) {
			$this->app->paypal_info = array(
					'url' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
					'business' => 'carlos_1247864033_biz@supplest.com',
					'return_url' => $this->app->go('Paypal', false, '/pdt/'),
					'notify_url' => $this->app->go('Paypal', false, '/ipn/'),
					'email' => 'carlost@supplest.com',
					'shipping' => 0,
				);
		} else {
			$this->app->paypal_info = array(
					'url' => 'https://www.paypal.com/cgi-bin/webscr',
					'business' => 'diego@blixgraphics.com',
					'return_url' => $this->app->go('Paypal', false, '/pdt/'),
					'notify_url' => $this->app->go('Paypal', false, '/ipn/'),
					'email' => 'carlost@supplest.com',
					'shipping' => 0,
				);
		}

		$this->app->paypal_prods = array(
			// generic product
			'10001' => array(
					'return' => $this->app->go('Cart', false, '/paypal_complete'),
					'cancel_return' => $this->app->go('Cart/checkout'),
				),
		);

		// Authorize
		global $authorize;
		$this->app->authorize_sandbox = true;
		if (in_array($this->cfg->setting->domain, array(
				'www.yousendweprint.com',
				'yousendweprint.com',
			))) {
			$this->app->authorize_sandbox = false;
		}

		if ($this->app->authorize_sandbox) {
			$this->app->authorize_info = array(
				'login_id' => '2rV6457RAeU',
				'transaction_key' => '9dr46Y72Wu44WrkZ',
				'transaction_server' => 'https://test.authorize.net/gateway/transact.dll',
				'transaction_mode' => 'liveMode',
			);
		} else {
			$this->app->authorize_info = array(
				'login_id' => $authorize['login_id'],
				'transaction_key' => $authorize['transaction_key'],
				'transaction_server' => 'https://secure.authorize.net/gateway/transact.dll',
				'transaction_mode' => 'liveMode',
			);
		}

		$this->app->authorize_prods = array(
			// generic product
			'10001' => array(
					'return' => $this->app->go('Cart', false, '/authorize_complete'),
					'cancel_return' => $this->app->go('Cart', false, '/authorize_cancel'),
				),
		);

		// news
		$articles = new Article();
		$articles->set_paging(1, 0, "`date_begin` DESC");
		$articles->set_section_key('article'); // TODO: FIX THIS!!!!
		$this->app->articles = $articles;

//echo $articles->list_count();
//exit;
		// States
		$this->app->states = array(
				'AL' => 'Alabama',
				'AK' => 'Alaska',
				'AZ' => 'Arizona',
				'AR' => 'Arkansas',
				'CA' => 'California',
				'CO' => 'Colorado',
				'CT' => 'Connecticut',
				'DE' => 'Delaware',
				'DC' => 'District of Columbia',
				'FL' => 'Florida',
				'GA' => 'Georgia',
				'HA' => 'Hawaii',
				'ID' => 'Idaho',
				'IL' => 'Illinois',
				'IN' => 'Indiana',
				'IA' => 'Iowa',
				'KS' => 'Kansas',
				'KY' => 'Kentucky',
				'LA' => 'Louisiana',
				'ME' => 'Maine',
				'MD' => 'Maryland',
				'MA' => 'Massachusetts',
				'MI' => 'Michigan',
				'MN' => 'Minnesota',
				'MS' => 'Mississippi',
				'MO' => 'Missouri',
				'MT' => 'Montana',
				'NE' => 'Nebraska',
				'NV' => 'Nevada',
				'NH' => 'New Hampshire',
				'NJ' => 'New Jersey',
				'NM' => 'New Mexico',
				'NY' => 'New York',
				'NC' => 'North Carolina',
				'ND' => 'North Dakota',
				'OH' => 'Ohio',
				'OK' => 'Oklahoma',
				'OR' => 'Oregon',
				'PA' => 'Pennsylvania',
				'RI' => 'Rhode Island',
				'SC' => 'South Carolina',
				'SD' => 'South Dakota',
				'TN' => 'Tennessee',
				'TX' => 'Texas',
				'UT' => 'Utah',
				'VT' => 'Vermont',
				'VA' => 'Virginia',
				'WA' => 'Washington',
				'WV' => 'West Virginia',
				'WI' => 'Wisconsin',
				'WY' => 'Wyoming'
			);

		$this->app->states_short = array(
				'AL' => 'AL',
				'AK' => 'AK',
				'AZ' => 'AZ',
				'AR' => 'AR',
				'CA' => 'CA',
				'CO' => 'CO',
				'CT' => 'CT',
				'DE' => 'DE',
				'DC' => 'DC',
				'FL' => 'FL',
				'GA' => 'GA',
				'HA' => 'HA',
				'ID' => 'ID',
				'IL' => 'IL',
				'IN' => 'IN',
				'IA' => 'IA',
				'KS' => 'KS',
				'KY' => 'KY',
				'LA' => 'LA',
				'ME' => 'ME',
				'MD' => 'MD',
				'MA' => 'MA',
				'MI' => 'MI',
				'MN' => 'MN',
				'MS' => 'MS',
				'MO' => 'MO',
				'MT' => 'MT',
				'NE' => 'NE',
				'NV' => 'NV',
				'NH' => 'NH',
				'NJ' => 'NJ',
				'NM' => 'NM',
				'NY' => 'NY',
				'NC' => 'NC',
				'ND' => 'ND',
				'OH' => 'OH',
				'OK' => 'OK',
				'OR' => 'OR',
				'PA' => 'PA',
				'RI' => 'RI',
				'SC' => 'SC',
				'SD' => 'SD',
				'TN' => 'TN',
				'TX' => 'TX',
				'UT' => 'UT',
				'VT' => 'VT',
				'VA' => 'VA',
				'WA' => 'WA',
				'WV' => 'WV',
				'WI' => 'WI',
				'WY' => 'WY'
			);
	}



	private function init_sidebar() {
	    $menu_groups = [];
	    $menu_group_homes = [];
		$menu_items = [];
		$menu_subitems = [];
		$menu_tags = [];
		$menu_featured1 = [];
		

	    $subproduct = new Product();
		$subproduct->set_paging(1, 0,
				array("`product_order` ASC", "`product_id` ASC"),
				array("`product_type` = 'subproduct'")
			);
	  while ($subproduct->list_paged()) {
	      $menu_subitems[(string)$subproduct->get_parent_id()][$subproduct->get_product_key()] = $subproduct->get_title();
	      $menu_subitems[$subproduct->get_product_key()]["parent_id"] = $subproduct->get_parent_id();

	  }
	  //print_r($menu_subitems);
		$categories = new Product();
		$categories->set_paging(1, 0,
				array("`product_order` ASC", "`product_id` ASC"),
				array("`product_type` = 'category'")
			);
		while ($categories->list_paged()) {
			$menu_group = array();
			$menu_item = array();

			$groups = new Product();
			$groups->set_paging(1, 0,
						array("`product_order` ASC", "`product_id` ASC"),
						array("`product_type` = 'group'", "`parent_id` = {$categories->get_id()
					}",
				));

			while ($groups->list_paged()) {
				$menu_group[(string)$groups->get_id()] = $groups->get_title();
				$menu_group[(string)$groups->get_product_key()] = $groups->get_title();
				$menu_group_homes[(string)$groups->get_product_key()] = $groups->get_group_home();

				$product_groups = new ProductGroup();
				$product_groups->set_paging(1, 0,
						array("`product_order` ASC", "`product_id` ASC"),
						array("`group_id` = {$groups->get_id()}")
					);

				while ($product_groups->list_paged_product()) {
					$item = array(
							'id' => $product_groups->get_product_id(),
							'title' => $product_groups->get_product(),
						);

					if ($featured = $product_groups->get_featured()) {
						$item['class'] = $featured;
						$item['featured'] = $this->lng->text('featured:' . $featured);
					}

					$menu_item[(string)$groups->get_product_key()][$product_groups->get_product_key()] = $item;


					//$menu_item[(string)$product_groups->get_product_key()] = $product_groups->get_product();
				}
			}

			$cat_title = str_replace(" ", "_", strtolower($categories->get_title()));
			$menu_groups[$cat_title] =  array(
					'title' => $categories->get_title(),
					'groups' => $menu_group,
				);
			$menu_items[$cat_title] = $menu_item;
		}

		$this->app->menu_groups = $menu_groups;
		$this->app->menu_group_homes = $menu_group_homes;
		$this->app->menu_items = $menu_items;
		$this->app->menu_subitems = $menu_subitems;
		
		$menu_tags = $this->utl->get_property('home_tags', 0);
		
		$this->app->menu_tags = $menu_tags;
		$menu_featured1 =  $this->utl->get_property('menumega_featured1', 0);	
		$this->app->menu_featured1 = $menu_featured1;
		$menu_featured2 =  $this->utl->get_property('menumega_featured2', 0);	
		$this->app->menu_featured2 = $menu_featured2;
		$menu_featured3 =  $this->utl->get_property('menumega_featured3', 0);	
		$this->app->menu_featured3 = $menu_featured3;
		$menu_featured4 =  $this->utl->get_property('menumega_featured4', 0);	
		$this->app->menu_featured4 = $menu_featured4;
		$menu_featured5 =  $this->utl->get_property('menumega_featured5', 0);	
		$this->app->menu_featured5 = $menu_featured5;
		$menu_featured6 =  $this->utl->get_property('menumega_featured6', 0);	
		$this->app->menu_featured6 = $menu_featured6;
		$menu_featured7 =  $this->utl->get_property('menumega_featured7', 0);	
		$this->app->menu_featured7 = $menu_featured7;
		$menu_featured8 =  $this->utl->get_property('menumega_featured8', 0);	
		$this->app->menu_featured8 = $menu_featured8;
		$menu_featured9 =  $this->utl->get_property('menumega_featured9', 0);	
		$this->app->menu_featured9 = $menu_featured9;
		$menu_featured10 =  $this->utl->get_property('menumega_featured10', 0);	
		$this->app->menu_featured10 = $menu_featured10;

//print_r($menu_featured2);
//print_r($menu_groups);
//print_r($menu_items);
//exit;
	}


	private function init_sidebarK() {
		$menu_groups = array();
		$menu_items = array();

		$sections = new Product();
		$sections->set_paging(1, 0, "`product_order` ASC");

		while ($sections->list_children()) {
			$section_key = $sections->get_product_key();

			$groups = new Product();
			$groups->set_parent_key($section_key);

			$menu_group = array();
			$menu_item = array();

			while ($groups->list_children()) {
				$group_key = $groups->get_product_key();
				$menu_group[$group_key] = $groups->get_title();

				$items = new Product();
				$items->set_parent_key($group_key); // TODO: use $filter

				$menu_item[$group_key] = array();

				while ($items->list_children()) {
					//$menu_item[$group_key][$items->get_product_key()] = $items->get_title()
					//    . (($featured = $items->get_featured()) ? '|' . $this->lng->text('featured:' . $featured) : '');
					$item = array(
							'id' => $items->get_id(),
							'title' => $items->get_title(),
						);

					if ($featured = $items->get_featured()) {
						$item['class'] = $featured;
						$item['featured'] = $this->lng->text('featured:' . $featured);
					}

					$menu_item[$group_key][$items->get_product_key()] = $item;
				}
			}

			$menu_groups[$section_key] = array(
					'title' => $sections->get_title(),
					'groups' => $menu_group,
				);
			$menu_items[$section_key] = $menu_item;

		}

		$this->app->menu_groups = $menu_groups;
		$this->app->menu_items = $menu_items;

//print_r($menu_groups);
//print_r($menu_items);
exit;
	}


}
?>