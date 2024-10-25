<?php
class MainCtrl extends BaseCtrl {

	public function run($args) {
		$this->run_default($args);
	}


	protected function run_default($args) {
		// Fix for uploadify session
		if (isset($_REQUEST['upload_session'])) {
			session_id($_REQUEST['upload_session']);
		}

		// Session and login
		session_start();

		if (in_array('logout', $args)) {
			// Logout -------------------------------------------------------------------------------------------------
			session_destroy();
			session_start();

			if (isset($_COOKIE['session'])) {
				// remove cookie
				setcookie('session', '', time()-60*60*24*100, '/');
			}
			$page_full = str_replace('logout', '', $this->app->page_full);
			header('Location: ' . $page_full);
			exit; // >>>>>>>>>>


		} else if (isset($_SESSION[md5($_SERVER['REMOTE_ADDR'])])) {
			// There is a user session --------------------------------------------------------------------------------
			$user_id = $_SESSION[md5($_SERVER['REMOTE_ADDR'])];
			$user = new User($user_id);
			$this->init_user($user);

		} else if ($this->get_cookie('k', '')) {
			// remember cookie found ----------------------------------------------
			if ($_SERVER['HTTP_SMVC_AJAX_REQUEST']) {
				header('HTTP/1.1 403 Forbidden', true, 403);

			} else {
				$_SESSION['remember_target'] = $this->app->page_full;

				$this->app->redirect($this->app->go('Session/remember'));
			}

		} else {
			// Can't be here ------------------------------------------------------------------------------------------
			header('Location: /');
			exit; // >>>>>>>>>>
		}

		$this->init_global();

	}

	protected function new_session($username, $password, $md5 = false, $remember = false) {
		if (!$md5) {
			$password = md5($password);
		}
		$user = new User();
		if ($user_id = $user->login($username, $password, true)) {
			// TODO: keep shopping cart ID
			session_destroy();
			session_start();

			$_SESSION[md5($_SERVER['REMOTE_ADDR'])] = $user_id;
			if ($remember) {
				setcookie('session', $password . $username, time()+60*60*24*100, '/');
			}

			$this->init_user($user);

			return true;

		} else {
			return false;
		}
	}

	protected function init_user($user) {
		if (in_array($user->get_role_id(), array(
					Role::enum('superadmin'),
					Role::enum('administrator'),
					Role::enum('admin_yswp')
				))) {
			$this->app->user = $user;
			$this->app->user_id = $user->get_id();
			$this->app->username = $user->get_username();
			$this->app->user_admin = true;
		} else {
			header('Location: /');
			exit;

		}
	}


	private function error_log($error) {
		if ($this->debug) {
			error_log('>>> SUPPLEMVC ' . $error);
		}
	}

	private function init_global() {
		$cost = new Cost();
		$cost->retrieve_by('cost_key', 'retail-increase');
		$this->app->retail_incr = $cost->get_value();

		$this->cfg->setting->img_extensions = 'jpg';
		$this->cfg->setting->img_filter = '*.jpg';
		$this->cfg->setting->img_filter_text = 'Archivos JPG (*.jpg)';

		$this->app->spec_extensions = 'jpg|jpeg|tif|tiff|pdf|zip|rar';

		// States
		$this->app->states = array(
				'AL'=>'Alabama',
				'AK'=>'Alaska',
				'AZ'=>'Arizona',
				'AR'=>'Arkansas',
				'CA'=>'California',
				'CO'=>'Colorado',
				'CT'=>'Connecticut',
				'DE'=>'Delaware',
				'DC'=>'District of Columbia',
				'FL'=>'Florida',
				'GA'=>'Georgia',
				'HA'=>'Hawaii',
				'ID'=>'Idaho',
				'IL'=>'Illinois',
				'IN'=>'Indiana',
				'IA'=>'Iowa',
				'KS'=>'Kansas',
				'KY'=>'Kentucky',
				'LA'=>'Louisiana',
				'ME'=>'Maine',
				'MD'=>'Maryland',
				'MA'=>'Massachusetts',
				'MI'=>'Michigan',
				'MN'=>'Minnesota',
				'MS'=>'Mississippi',
				'MO'=>'Missouri',
				'MT'=>'Montana',
				'NE'=>'Nebraska',
				'NV'=>'Nevada',
				'NH'=>'New Hampshire',
				'NJ'=>'New Jersey',
				'NM'=>'New Mexico',
				'NY'=>'New York',
				'NC'=>'North Carolina',
				'ND'=>'North Dakota',
				'OH'=>'Ohio',
				'OK'=>'Oklahoma',
				'OR'=>'Oregon',
				'PA'=>'Pennsylvania',
				'RI'=>'Rhode island',
				'SC'=>'South carolina',
				'SD'=>'South dakota',
				'TN'=>'Tennessee',
				'TX'=>'Texas',
				'UT'=>'Utah',
				'VT'=>'Vermont',
				'VA'=>'Virginia',
				'WA'=>'Washington',
				'WV'=>'West virginia',
				'WI'=>'wisconsin',
				'WY'=>'wyoming'
			);

	}


}
?>