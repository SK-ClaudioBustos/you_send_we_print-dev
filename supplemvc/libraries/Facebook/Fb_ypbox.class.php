<?php
	/*
	* Return array converted to object
	* Using __FUNCTION__ (Magic constant)
	* for recursive call
	*/
	function arrayToObject($d) {
		if (is_array($d)) {
			$obj = (object) array_map(__FUNCTION__, $d);

//	print_r(d);
//	var_dump($obj);
//	exit;

			return $obj;
		} else {
			// Return object
			return $d;
		}
	}


class Fb_ypbox
{
	var $fb_app_id;
	var $fb_app_secret;
	var $cookie;
	var $userData;


	// Sherton

	function getFacebookLocation() {
		$url = 'https://api.facebook.com/method/fql.query?query=SELECT%20current_location%20FROM%20user%20WHERE%20uid=' . $this->getUserid() . '&format=json&access_token=' . $this->getAccessToken();
		$content = $this->getDataFromUrl($url);
		$content = json_decode($content, true);

		if (sizeof($content)) {
			return $content[0]['current_location'];
		} else {
			return false;
		}
	}

	///////////////////////
	// START ADDS
	function getFacebookFriends($criteria='') {
		$name = $criteria['name'];

		if($name=='') $name = 'me';

		$url = 'https://graph.facebook.com/'.$name.'/friends?access_token='.$this->getAccessToken();
		$content = $this->getDataFromUrl($url);
		$content = json_decode($content,true);

		$users = $this->formatFacebookUsers($content);

		return $users;
	}

	function formatFacebookUsers($content) {
		for($i=0; $i<count($content['data']); $i++) {
			$id = $content['data'][$i]['id'];
			$name = $content['data'][$i]['name'];

			$picture = 'https://graph.facebook.com/'.$id.'/picture?type=square'; //square, small, large
			$url = 'http://www.facebook.com/profile.php?id='.$id;

			$users[$i]['id'] = $id;
			$users[$i]['name'] = $name;
			$users[$i]['picture'] = $picture;
			$users[$i]['url'] = $url;
		}
		return $users;
	}

	function displayUsersIcons($criteria) {
		$users = $criteria['users'];
		$nb_display = $criteria['nb_display'];
		$width = $criteria['width'];

		if($width=='') $width="30";

		if($nb_display>count($users) || $nb_display=='') $nb_display=count($users); //display value never bigger than nb users

		$display = '';
		for($i=0;$i<$nb_display;$i++) {
			$name = $users[$i]['name'];
			$picture = $users[$i]['picture'];
			$url = $users[$i]['url'];

			$display .= '<a href="'.$url.'" target="_blank" title="'.$name.'">';
			$display .= '<img src="'.$picture.'" width="'.$width.'" style="padding:2px;">';
			$display .= '</a>';
		}
		return $display;
	}
	// END ADDS
	///////////////////////

	//Class Instantiation
	function __construct($criteria=array()) { // SMVC construct name changed because class name function is deprecated
		$fb_app_id = $criteria['fb_app_id'];
		$fb_app_secret = $criteria['fb_app_secret'];

		$this->fb_app_id = $fb_app_id;
		$this->fb_app_secret = $fb_app_secret;
		//if no app id and secret given, try to get them globaly
		if($this->fb_app_id==''||$this->fb_app_secret=='') {
			$this->fb_app_id = $GLOBALS['fb_app_id'];
			$this->fb_app_secret = $GLOBALS['fb_app_secret'];
		}

//		$fc1 = Fb_ypbox_cookie::getInstance(array('fb_app_id'=>$GLOBALS['fb_app_id'], 'fb_app_secret'=>$GLOBALS['fb_app_secret']));
		$fc1 = Fb_ypbox_cookie::getInstance(array('fb_app_id' => $this->fb_app_id, 'fb_app_secret' => $this->fb_app_secret));
		$this->cookie = $fc1->getCookie();
error_log('Fb_ypbox >>> ' . $this->fb_app_id . ' | ' . $this->fb_app_secret . ' | ' . serialize($this->cookie));
		$this->userData = $fc1->getUserData();

		//if cookie empty flush cookie session
		if($this->cookie['access_token']=='') {
			$_SESSION['fb_box_cookie'] = '';
			$this->cookie = '';
		}
		else {
			$_SESSION['fb_box_cookie'] = $this->cookie;
		}
	}

	//load JS file + ajax URL path
	function load_js_functions($criteria=array()) {
		$timeline_js = $criteria['timeline_js'];
		$prettydate_js = $criteria['prettydate_js'];

		$userData = $this->getUserData();
		echo "\n\n".'<script type=\'text/javascript\'>/* <![CDATA[ */ var Fb_ypbox = {
		ajaxurl: "'.$GLOBALS['fb_ypbox_path'].'", scope: "'.$GLOBALS['fb_scope'].'",
		connect_redirect: "'.$GLOBALS['fb_connect_redirect'].'",
		logout_redirect: "'.$GLOBALS['fb_logout_redirect'].'", token: "'.$this->getAccessToken().'",
		user_id: "'.$userData['id'].'", name: "'.$userData['name'].'"
		}; /* ]]> */ </script>'."\n\n";
		echo '<script type="text/javascript" src="'.$GLOBALS['fb_ypbox_path'].'/include/js/script.js"></script>'."\n\n";
		if($timeline_js) echo '<script type="text/javascript" src="'.$GLOBALS['fb_ypbox_path'].'/include/js/timeline.js"></script>'."\n\n";
		if($prettydate_js) echo '<script type="text/javascript" src="'.$GLOBALS['fb_ypbox_path'].'/include/js/jquery.prettydate.js"></script>'."\n\n";
	}

	//Load the Facebook JS SDK
	function loadJsSDK() {
		echo '<div id="fb-root"></div>';
		echo '<script>';

		echo 'window.fbAsyncInit = function() {';
		echo 'FB.init({appId: '.$this->fb_app_id.', status: true, cookie: true, xfbml: true, oauth: true});';
		echo 'onFbSdkCallbackFB_box();';
		echo $GLOBALS['fb_sdk_js_callback'];
		echo '};';

		if($GLOBALS['fb_sdk_lang']=='') $GLOBALS['fb_sdk_lang'] = 'en_US';

		?>
		(function(d){
			var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id; js.async = true;
			js.src = "//connect.facebook.net/<?php echo $GLOBALS['fb_sdk_lang']; ?>/all.js";
			ref.parentNode.insertBefore(js, ref);
		}(document));
		<?php

		echo '</script>';
	}

	function getUserid() {
		$cookie = $this->getCookie();
		return $cookie['user_id'];
	}

	function getUserData($as_object = true) {
		if ($as_object) {
			return arrayToObject($this->userData);
		} else {
			return $this->userData;
		}
	}



	function getLongLivedToken($criteria=array()) {
		$token = $criteria['token'];

		if($token=='') $token = $this->getAccessToken();

		if($token!='') {
			//get longer-lived token
			$url = 'https://graph.facebook.com/oauth/access_token?client_id='.$this->fb_app_id.'&client_secret='.$this->fb_app_secret.'&grant_type=fb_exchange_token&fb_exchange_token='.$token;
			//echo '<a href="'.$url.'" target="_blank">'.$url.'</a><br>';
			$response = $this->getDataFromUrl($url);
			//print_r($url);
			parse_str($response, $token_data);
			$token = $token_data['access_token'];
			$expires = $token_data['expires'];
			if($expires!='' && $expires!=0) $expires = (time()+$expires);
			else $expires = 0;
		}

		$data['token'] = $token;
		$data['expires'] = $expires;
		return $data;
	}

	function getAccessToken() {
		$cookie = $this->getCookie();
		return $cookie['access_token'];
	}

	function getCookie() {
		$cookie = $this->cookie;
		return $cookie;
	}

	//Facebook API basic call
	function get_fb_api_results($criteria=array()) {
		$object = $criteria['object'];
		$connection = $criteria['connection'];
		$token = $criteria['token'];
		$limit = $criteria['limit'];

		$pos = strrpos($connection, "?");
		if($pos>0) $tokenRel='&'; //if ? detected in $connection
		else $tokenRel='?'; //default

		if($object=='') $object = 'me';
		if($token=='') $token = $this->getAccessToken();

		$url = 'https://graph.facebook.com/'.$object;
		if($connection!='') $url .= '/'.$connection;
		if($token!='') $url .= $tokenRel.'access_token='.$token;
		if($limit!='') $url .= '&limit='.$limit;

		//echo $url;
		$content = $this->getDataFromUrl($url);
		//print_r($content);
		//echo '<br><br>';
		$content = json_decode($content,true);

		return $content;
	}

	function getGrantedPermissions() {
		$data = $this->get_fb_api_results(array('object'=>'me', 'connection'=>'permissions'));
		$data = $data['data'][0];
		return $data;
	}

	//Get Facebook pages
	function getFacebookPages($criteria=array()) {
		$token = $criteria['token'];

		if($token=='') $token = $this->getAccessToken();

		$accounts = $this->getFacebookAccounts(array('token'=>$token));
		$k=0;
		for($i=0; $i<count($accounts['data']); $i++) {
			if($accounts['data'][$i]['category']!='Application') {
				$pages[$k] = $accounts['data'][$i];
				$k++;
			}
		}
		return $pages;
	}

	//Get Facebook accounts (including pages and apps)
	function getFacebookAccounts($criteria=array()) {
		$token = $criteria['token'];

		$accounts = $this->get_fb_api_results(array('connection'=>'accounts', 'token'=>$token));
		return $accounts;
	}

	//Getting data fron a remote URL
	function getDataFromUrl($url) {
		$ch = curl_init();
		$timeout = 5;
		//echo $url.'<br><br>';
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to make it support SSL calls on some servers
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	//Posting data to a remote URL using POST
	function postDataToURL($url, $postParms) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to make it support SSL calls on some servers
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postParms);
		$results = curl_exec($ch);
		curl_close($ch);
		return $results;
	}

	//This function enable the posting of a status
	function updateFacebookStatus($criteria, $token='') {
		$fb_id = $criteria['fb_id'];
		$message = $criteria['message'];
		$link = $criteria['link'];
		$picture = $criteria['picture'];
		$name = $criteria['name'];
		$caption = $criteria['caption'];
		$description = $criteria['description'];
		$source = $criteria['source'];

		if($fb_id=='') $fb_id = 'me';

		$criteriaString = '&message='.$message;
		if($link!='') $criteriaString .= '&link='.$link;
		if($picture!='') $criteriaString .= '&picture='.$picture;
		if($name!='') $criteriaString .= '&name='.$name;
		if($caption!='') $criteriaString .= '&caption='.$caption;
		if($description!='') $criteriaString .= '&description='.$description;
		if($source!='') $criteriaString .= '&source='.$source;

		$postParms = "access_token=".$token.$criteriaString;

		$url = 'https://graph.facebook.com/'.$fb_id.'/feed';

		$results = $this->postDataToURL($url, $postParms);

		return $results;
	}
}

class Fb_ypbox_cookie
{
	private static $_instance;
	private static $fb_app_id;
	private static $fb_app_secret;
	private static $cookie;
	private static $userData;

	function getCookie() {
		return self::$cookie;
	}

	function getUserData() {
		return self::$userData;
	}

	//Getting data fron a remote URL
	function getDataFromUrl($url) {
		$ch = curl_init();
		$timeout = 5;
		//echo $url;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to make it support SSL calls on some servers
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	public static function getInstance($criteria=array()) {
		self::$fb_app_id = $criteria['fb_app_id'];
		self::$fb_app_secret = $criteria['fb_app_secret'];

		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	// Do not allow an explicit call of the constructor: $v = new Singleton();
	final private function __construct() {
		//if cookie found in session and still valid...
		if($_SESSION['fb_box_cookie']['access_token']!='' && time()<$_SESSION['fb_box_cookie']['expires']) {
			$cookie = $_SESSION['fb_box_cookie'];
		}
		else {
			$cookie = $this->get_facebook_cookie(self::$fb_app_id, self::$fb_app_secret);
		}
		//print_r($cookie);
		//echo '<br><br>';
		if($this->parse_signed_request_verify()) {
			self::$cookie = $cookie;
			self::$userData = $this->getUserDataFromApi();
		}
	}

	function parse_signed_request($signed_request, $secret) {
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);

		// decode the data
		$sig = $this->base64_url_decode($encoded_sig);
		$data = json_decode($this->base64_url_decode($payload), true);

		if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
			//error_log('Unknown algorithm. Expected HMAC-SHA256');
			return null;
		}

		// Adding the verification of the signed_request below
		$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		if ($sig !== $expected_sig) {
			//error_log('Bad Signed JSON signature!');
			return null;
		}

		return $data;
	}

	function parse_signed_request_verify() {
		$data=1;
		return $data;
	}

	function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}

	function get_facebook_cookie($app_id, $app_secret) {
		//echo $app_id.'<br>';
		//print_r($_COOKIE['fbsr_' . $app_id]);
		$signed_request = $this->parse_signed_request($_COOKIE['fbsr_' . $app_id], $app_secret);
		//print_r($signed_request);
		//$signed_request[uid] = $signed_request[user_id]; // for compatibility
		if (!is_null($signed_request)) {
			$url = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=&client_secret=$app_secret&code=$signed_request[code]";
			$access_token_response = $this->getDataFromUrl($url);

			//echo $signed_request[code].'<br>';
			//print_r($access_token_response);

			parse_str($access_token_response);
			$signed_request[access_token] = $access_token;
			if($expires==0) $signed_request[expires] = 0;
			else $signed_request[expires] = time() + $expires;
		}
		return $signed_request;
	}

	function getUserDataFromApi() {
		$cookie = self::$cookie;
		if($cookie['access_token']!='') {
			$url = 'https://graph.facebook.com/me?access_token='.$cookie['access_token'];
			//echo '<a href="'.$url.'" target="_blank">'.$url.'</a><br>';
			$data = json_decode($this->getDataFromUrl($url));
			//No error
			if($data->error->message=='') {
				$fb['id'] = $data->id;
				$fb['name'] = $data->name;
				$fb['first_name'] = $data->first_name;
				$fb['last_name'] = $data->last_name;
				$fb['link'] = $data->link;
				$fb['birthday'] = $data->birthday;
				$fb['gender'] = $data->gender;
				$fb['email'] = $data->email;
				$fb['timezone'] = $data->timezone;
				$fb['locale'] = $data->locale;
				$fb['updated_time'] = $data->updated_time;
				$fb['picture'] = 'http://graph.facebook.com/'.$data->id.'/picture';
				$fb['picture_large'] = 'http://graph.facebook.com/'.$data->id.'/picture?type=large';
				//tokens
				$fb['token'] = $cookie['access_token'];
				$fb['token_expires'] = $cookie['expires'];
				return $fb;
			}
			else {
				//if error (token expires etc...)
				self::$cookie = '';
			}
		}
	}

	public function __destruct() {
		//$this->closeConnection();
	}

	// Do not allow the clone operation: $x = clone $v;
	final private function __clone() { }
}

?>