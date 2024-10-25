<?
// http://developers.facebook.com/docs/reference/fql/user

class Facebook {

	// Protected Vars

	protected $cookie;


	// Constructors

	public function __construct() {
		$this->cookie = $this->get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
	}


	// Getters

	public function getCookie() {
		return $this->cookie;
	}

	public function getAccessToken() {
		return $this->cookie['access_token'];
	}

	public function getUserid() {
		$cookie = $this->getCookie();
		return $cookie['user_id'];
	}

	// Setters


	// Public Methods


	// Protected Methods

	public function displayLoginButton() {
		echo '<a href="javascript:" onclick="fbActionConnect();">Facebook connect</a>';
	}


	public function getProfilePicture() {
		$url = 'https://graph.facebook.com/'.$this->getUserid().'/picture?type=large';
		//$url = 'api.facebook.com/method/fql.query?query=SELECT pic_big FROM user WHERE uid = '.$this->getUserid();
		$url = $this->get_redirect_url($url);
		return $url;
	}

	public function getUserData() {
		if($this->getCookie()) {
			$url = 'https://graph.facebook.com/me?access_token='.$this->getAccessToken();
			$userData = json_decode($this->getDataFromUrl($url));
			return $userData;
		}
	}

	public function loadJsSDK($path_to_library='') {
		echo '<div id="fb-root"></div>';
		echo '<script>';

	    ?>

		function logoutFacebookUser() {
			FB.logout(function(response) {
			  window.location.reload();
			});
		}

		function fbActionConnect() {
			FB.login(function(response) {
			  if (response.authResponse) {
			  	window.location = "<?php echo $path_to_library; ?>./connect.php";
			  }
			}, {scope:'read_stream,publish_stream,manage_pages,email'});
		}

	    <?php

		echo 'window.fbAsyncInit = function() {';
		echo 'FB.init({appId: '.FACEBOOK_APP_ID.', status: true, cookie: true, xfbml: true, oauth: true});';

		echo '};';

		echo '(function() {';
			echo 'var e = document.createElement(\'script\'); e.async = true;';
		    echo 'e.src = document.location.protocol +';
		    echo '\'//connect.facebook.net/en_US/all.js\';';
		    echo 'document.getElementById(\'fb-root\').appendChild(e);';
		echo '}());';

		echo '</script>';
	}

	public function parse_signed_request($signed_request, $secret) {
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);

		// decode the data
		$sig = $this->base64_url_decode($encoded_sig);
		$data = json_decode($this->base64_url_decode($payload), true);

		if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
			error_log('Unknown algorithm. Expected HMAC-SHA256');
			return null;
		}

		// check sig
		$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		if ($sig !== $expected_sig) {
			error_log('Bad Signed JSON signature!');
			return null;
		}

		return $data;
	}

	protected function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}

	public function get_facebook_cookie($app_id, $app_secret) {
	    $signed_request = $this->parse_signed_request($_COOKIE['fbsr_' . $app_id], $app_secret);
	    //$signed_request[uid] = $signed_request[user_id]; // for compatibility
	    if (!is_null($signed_request)) {
	    	$url = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=&client_secret=$app_secret&code=$signed_request[code]";
	    	$access_token_response = $this->getDataFromUrl($url);
	        parse_str($access_token_response);
	        $signed_request[access_token] = $access_token;
	        if($expires==0) $signed_request[expires] = 0;
	        else $signed_request[expires] = time() + $expires;
	    }
	    return $signed_request;
	}

	function get_redirect_url($url) {
		$redirect_url = null;

		$url_parts = @parse_url($url);
		if (!$url_parts) return false;
		if (!isset($url_parts['host'])) return false; //can't process relative URLs
		if (!isset($url_parts['path'])) $url_parts['path'] = '/';

		$sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
		if (!$sock) return false;

		$request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n";
		$request .= 'Host: ' . $url_parts['host'] . "\r\n";
		$request .= "Connection: Close\r\n\r\n";
		fwrite($sock, $request);
		$response = '';
		while(!feof($sock)) $response .= fread($sock, 8192);
		fclose($sock);

		if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
			if ( substr($matches[1], 0, 1) == "/" )
				return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
			else
				return trim($matches[1]);

		} else {
			return false;
		}
	}

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

	function getFacebookAccounts() {
		$url = 'https://graph.facebook.com/me/accounts?access_token='.$this->getAccessToken();
		$content = $this->getDataFromUrl($url);
		$content = json_decode($content,true);
		return $content;
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

	function getFacebookFeeds() {
		$url = 'https://graph.facebook.com/me/posts?access_token='.$this->getAccessToken();
		$data = $this->getDataFromUrl($url);
		$data = json_decode($data,true);
//print_r($data);
		$dataList = $this->formatFacebookPosts($data);
print_r($dataList);
		return $dataList;
	}

	function getDataFromUrl($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function formatFacebookPosts($data) {
		$i=0;
		foreach($data['data'] as $value) {
			$id = $value['id'];
			$from_id = $value['from']['id'];
			$from_name = $value['from']['name'];

			$type = $value['type']; //video, link, status, picture, swf
			$message = $value['message'];
			$picture = $value['picture'];
			$link = $value['link'];
			$source = $value['source']; //for videos
			$name = $value['name']; //for videos or links
			$caption = $value['caption']; //for videos (domain name url) or links
			$description = $value['description']; //for videos
			$icon = $value['icon'];
			$created = $value['created_time'];
			$likes_nb = $value['likes'];

			$comments = $value['comments']['data']; //(message, created_time)
			$comments_nb = $value['comments']['count'];
			$action_comment = $value['actions'][0]['link'];

			$picture_url = 'https://graph.facebook.com/'.$from_id.'/picture';
			$profile_url = 'http://www.facebook.com/profile.php?id='.$from_id;

			$attribution = $value['attribution'];

			if($type=='status') {
				$dataList[$i]['id'] = $id;
				$dataList[$i]['from_id'] = $from_id;
				$dataList[$i]['from_name'] = $from_name;
				$dataList[$i]['type'] = $type;
				$dataList[$i]['message'] = $message;
				$dataList[$i]['picture'] = $picture;
				$dataList[$i]['link'] = $link;
				$dataList[$i]['source'] = $source;
				$dataList[$i]['name'] = $name;
				$dataList[$i]['caption'] = $caption;
				$dataList[$i]['description'] = $description;
				$dataList[$i]['icon'] = $icon;
				$dataList[$i]['created'] = $created;
				$dataList[$i]['attribution'] = $attribution;
				$dataList[$i]['likes_nb'] = $likes_nb;
				$dataList[$i]['comments'] = $comments;
				$dataList[$i]['comments_nb'] = $comments_nb;
				$dataList[$i]['action_comment'] = $action_comment;
				$dataList[$i]['picture_url'] = $picture_url;
				$dataList[$i]['profile_url'] = $profile_url;
				$i++;
			}
		}
		return $dataList;
	}

	function updateFacebookStatus($status) {
		$postParms = "access_token=".$this->getAccessToken()."&message=".$status;
		$ch = curl_init('https://graph.facebook.com/me/feed');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postParms);
		$results = curl_exec($ch);
		curl_close($ch);
	}

}

?>