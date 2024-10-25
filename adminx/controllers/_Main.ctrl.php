<?php
class MainCtrl extends CustomCtrl {

	public function run($args = array()) {
		$this->run_default($args, $action = '');
	}


	protected function run_default($args, $action) {
		// Session and login
		session_start();

		$this->init_app_settings();

		if ($this->app->module_key == 'Session') {
			$user_id = $_SESSION[md5($_SERVER['REMOTE_ADDR'])];
			$this->init_user($user_id);

			// captured in SessionCtrl --------------------------------------------

		} else if (isset($_SESSION[md5($_SERVER['REMOTE_ADDR'])])) {
			// already a user session ---------------------------------------------

			$user_id = $_SESSION[md5($_SERVER['REMOTE_ADDR'])];
			$this->init_user($user_id);

		} else if ($this->get_cookie('k', '')) {
			// remember cookie found ----------------------------------------------
			if ($_SERVER['HTTP_SMVC_AJAX_REQUEST']) {
				header('HTTP/1.1 403 Forbidden', true, 403);

			} else {
error_log('MainCtrl / run_default / remember');
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

				} else { // if (!in_array($this->app->page_key, array('Session/login', 'Session/confirm'))) {
					if ($_SERVER['HTTP_SMVC_AJAX_REQUEST']) {
						$this->init_user(0);
						header('HTTP/1.1 401 Unauthorized', true, 401);

					} else {
						$_SESSION['goto'] = $this->app->page_full;

						$this->app->redirect('/'); //$this->app->go('Session/login'));
					}
				}

			} else {
				// generic user
				$this->init_user(0);
			}
		}

		if ($this->app->user_id) {
			$this->init_sidebar();
		}
	}


	private function init_user($user_id) {
		$user = new User($user_id);

		$this->app->user = $user;
		$this->app->user_id = $user->get_id();
		$this->app->username = $user->get_username();
		$this->app->user_admin = in_array($user->get_role_id(), array(
				Role::enum('superadmin'),
				Role::enum('administrator'),
				Role::enum('admin_yswp'),
			));

		if (!$this->app->user_admin) {
			$this->app->redirect('/'); // >>>>>>>>>>>>>>>>>>>>> Exit
		}


		if ($user->get_id() && $this->utl->get_property('offline', 0)) { //$this->cfg->setting->offline) {
			// only superadmins allowed
			if ($user->get_role_id() != Role::enum('superadmin')) {
				// restart session
				session_destroy();
				session_start();

				$_SESSION['login_var'] = array('offline' => true, 'alert' => 'danger', 'msg' => $this->lng->text('ERROR:OFFLINE_MESSAGE'));

				$this->app->redirect('/'); // >>>>>>>>>>>>>>>>>>>> Exit
			}

		}
	}

	private function init_app_settings() {
		// login captcha
		// get a key from https://www.google.com/recaptcha/admin/create
		$this->app->captcha_public = '6LfhnH4UAAAAAK0Hzx8Fe7kJHCivrnXtzhG2KY6-';
		$this->app->captcha_secret = '6LfhnH4UAAAAAOehUiN6V7rWH3yHvUcI18mS565w';

		// debug
		$this->app->debug = $this->utl->get_property('debug', 0);
		$this->app->debug_sql = array();
		if ($this->app->debug) {
			$this->app->debug_sql = $this->utl->get_property('debug_sql', array());
		}
//print_r($this->app->debug_sql);
//exit;

		// date format
		$this->app->date_format = 'm/d/Y';
		$this->app->datetime_format = 'm/d/Y H:i';
		$this->app->time_format = 'H:i';
		$this->app->date_picker_format = 'mm/dd/yyyy';
		$this->app->db_date_format = 'Y-m-d';
		$this->app->db_datetime_format = 'Y-m-d H:i';

		// forms
		$this->app->form_security_level = false; //'high';
		// false => no tokens, 'low' => one token per user, 'medium' => one token per form type, 'high' one token per form

		// users
		$this->app->user_logged_only = true;
		$this->app->user_allow_signup = false;
		$this->app->user_allow_reset = true;
		$this->app->user_approval = false; // 'admin', 'link'

		$this->app->user_max_login_attemps = 3;
		$this->app->user_password_len_min = 6;
		$this->app->user_password_len_max = 20;

		$this->app->user_show_username_on_reset = false;

		// uploads
		$this->app->file_extensions = 'jpg|jpeg|png|gif|doc|docx|pdf';
		$this->app->xls_extensions = 'xls|xlsx|csv';
		$this->app->spec_extensions = 'jpg|jpeg|tif|tiff|pdf|zip|rar';

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
	}

	private function init_sidebar() {
		$this->app->sidebar = array(
				array(
						'label' => 'menu:home',
						'icon' => 'fa fa-home',
						'module' => 'Home',
					),
				array(
						'label' => 'menu:site',
						'icon' => 'fa fa-external-link',
						'link' => $this->cfg->setting->protocol . '://' . $this->cfg->setting->domain,
						'target' => '_blank',
					),
				array(
						'label' => 'menu:product',
						'icon' => 'fa fa-picture-o',
						'perm' => 'perm:products',
						'items' => array(
								'Product' => array('label' => 'menu:product', 'module' => 'Product', 'perm' => 'perm:product'),
								'ItemList' => array('label' => 'menu:item_list', 'module' => 'ItemList', 'perm' => 'perm:itemlist'),
								'Item' => array('label' => 'menu:item', 'module' => 'Item', 'perm' => 'perm:item'),
								'ProductList' => array('label' => 'menu:product_list', 'module' => 'ProductList', 'perm' => 'perm:productlist'),
								'Cost' => array( 
										'label' => 'menu:cost', 
										'link' => $this->cfg->setting->protocol . '://' . $this->cfg->setting->domain . '/adminx2/costs',
										'perm' => 'perm:cost' 
									),
								'Provider' => array( 'label' => 'menu:provider', 'module' => 'Provider', 'perm' => 'perm:provider' ),
							),
					),
				array(
						'label' => 'menu:content',
						'icon' => 'fa fa-book',
						'perm' => 'perm:content',
						'items' => array(
								'Section' => array( 'label' => 'menu:section', 'module' => 'Section', 'perm' => 'perm:section' ),
								'Faq' => array( 'label' => 'menu:faq', 'module' => 'Faq', 'perm' => 'perm:faq' ),
								'Article' => array( 'label' => 'menu:article', 'module' => 'Article', 'perm' => 'perm:article' ),
								'Disclaimer' => array( 'label' => 'menu:disclaimer', 'module' => 'Disclaimer', 'perm' => 'perm:disclaimer' ),
							),
					),
				array(
					'label' => 'menu:coupon',
					'icon' => 'fa fa-gift',
					'perm' => 'perm:setup',
					'module' => 'Coupon',
				),
				array(
						'label' => 'menu:setup',
						'icon' => 'fa fa-cog',
						'perm' => 'perm:setup',
						'items' => array(
								'Property' => array( 'label' => 'menu:property', 'module' => 'Property', 'perm' => 'perm:property' ),
								'Scaffold' => array( 'label' => 'menu:scaffold', 'module' => 'Scaffold', 'perm' => 'perm:scaffold' ),
							),
					),
				//array(
				//        'label' => 'menu:user',
				//        'icon' => 'fa fa-user',
				//        'perm' => 'perm:user',
				//        'items' => array(
				//                'User' => array( 'label' => 'menu:user', 'module' => 'User', 'perm' => 'perm:user' ),
				//                'Role' => array( 'label' => 'menu:role', 'module' => 'Role', 'perm' => 'perm:role' ),
				//            ),
				//    ),
				array(
						'label' => 'menu:logout',
						'icon' => 'fa fa-power-off',
						'module' => 'Session/logout',
					),
			);
//print_r($this->app->sidebar);
//exit;
	}


}
?>