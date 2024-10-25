<?php
class SMvcUtil {
	protected $cfg;
	protected $lng;

	protected $mailer = false;


	public function __construct() {
		$this->cfg = &CustomApp::$config;
		$this->lng = $this->cfg->lang;
	}


	// date functions --------------------------------------------------------------------

	public function date_valid($date, $format = 'Y-m-d H:i:s') {
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	public function date_diff($datetime1, $datetime2 = false, $in_format = 'Y-m-d H:i:s') {
		$timezone = new DateTimeZone(date_default_timezone_get());

		$date1 = new DateTime($datetime1, $timezone);
		if ($datetime2) {
			$date2 = new DateTime($datetime2, $timezone);
		} else {
			$date2 = new DateTime('now', $timezone);
		}

		$interval = $date1->diff($date2);
		return $interval->format('%R%a');
	}

	public function date_modify($datetime, $diff, $time_offset = false, $out_format = 'Y-m-d') {
		$timezone = new DateTimeZone(date_default_timezone_get());

		$date = new DateTime($datetime, $timezone);
		$date->modify($diff);

	   	if ($time_offset) {
	   		$time_offset = explode(':', $time_offset);
	   		$datetime = $this->date_modify($datetime, $time_offset[0] . ' hours ', false, 'Y-m-d H:i:s');

	   		if ($mins = (int)$time_offset[1]) {
	   			$datetime = $this->date_modify($datetime, $mins . ' minutes ', false, 'Y-m-d H:i:s');
	   		}
	   	}

	   	// echo $date->format("U") <<  timestamp
		return $date->format($out_format); exit;
	}

	public function date_format($datetime, $time_offset = false, $out_format = 'm/d/Y', $in_format = 'Y-m-d H:i:s')  {
		if ($datetime) {
			// fix / problem
			//if (strpos($in_format, '/')) {
			//    $in_format = str_replace('/', '-', $in_format);
			//    $datetime = str_replace('/', '-', $datetime);
			//}

			if ((int)str_replace(array('0', '-', ':', ' '), '', $datetime)) {
			   	$timezone = new DateTimeZone(date_default_timezone_get());
			   	if ($time_offset && $time_offset != 0.00) {
			   		//$time_offset = explode(':', $time_offset);
			   		$time_offset = explode('.', $time_offset);
			   		$datetime = $this->date_modify($datetime, $time_offset[0] . ' hours ', false, 'Y-m-d H:i:s');

			   		if ($mins = (int)$time_offset[1]) {
			   			$datetime = $this->date_modify($datetime, $mins . ' minutes ', false, 'Y-m-d H:i:s');
			   		}
			   	}
//echo '[[[[[[[[[[[[[[' . $in_format . '|' . $datetime . '|' . strtotime($datetime);
//exit;
				$date = new DateTime(date($in_format, strtotime($datetime)), $timezone);
				return $date->format($out_format);
			} else {
				return '';
			}
		} else {
			return '';
		}
	}

	public function date_is_working_day($timestamp, $holidays = array()) {
		return (date('N', $timestamp) < 6 && !in_array(date('Y-m-d', $timestamp), $holidays));
	}

	public function date_add_biz_days($start_date, $business_days, $holidays = array(), $cutoff_time) {
		$business_days = intval($business_days); // Decrement does not work on strings

		// add one day for current day
		$business_days++;

		if ($this->date_is_working_day(strtotime($start_date), $holidays)) {
			// if working day, verify cutoff_time
			$start_time = date('H:i:s', strtotime($start_date));
error_log('$start_time ' . $business_days . '|' . $start_time . '|' . $cutoff_time);
			if ($start_time >= $cutoff_time) {
				// add one day
				$business_days++;
			}
		}

		$current_timestamp = strtotime($start_date);
		while ($business_days > 0) {
			//if (date('N', $current_timestamp) < 6 && !in_array(date('Y-m-d', $current_timestamp), $holidays)) {
			if ($this->date_is_working_day($current_timestamp, $holidays)) {
				$business_days--;
			}
			if ($business_days > 0) {
				$current_timestamp = strtotime('+1 day', $current_timestamp);
			}
		}
		return date('Y-m-d', $current_timestamp);
	}


	public function get_rewrite_string($text, $lowercase = true, $transliterate = true, $limit = null) {
		require_once($this->cfg->path->supplemvc . '/libraries/UrlSlug/url_slug.php');

		$options = array(
				'lowercase' => $lowercase,
				'transliterate' => $transliterate,
				'limit' => $limit,
			);
		return url_slug($text, $options);;
	}

	// Notification

	public function notify_close() {
		// close a previously open SMTP connection with $keep_alive = true

	}

	//public function notify($info = array(), $use_queue = true, $keep_alive = false) {
	public function notify($info = array(), $use_queue = false, $keep_alive = false) { // <<< $use_queue = false
		// info:
		// 		from_email
		//		from_name
		//		reply_to_email	/ default: from_email
		//		reply_to_name	/ default: from_name
		//		to 				/ array($email => $name)
		//		cc 				/ array($email => $name)
		//		bcc				/ array($email => $name)
		//		subject
		//		body
		//		attachs			/ not implemented

		// TODO: option for sending one mail by account separately
		// $phpMailer->SmtpClose();

		if ($info['from_email']) {
			$from_email = $info['from_email'];
			$from_name = (isset($info['from_name'])) ? $info['from_name'] : $info['from_email'];

		} else {
			if ($from = $this->get_property('notify_from')) {
				$from_email = $from['email'];
				$from_name = (isset($from['name'])) ? $from['name'] : $from['email'];
			}
		}

		if (!$from_email) {
			// can't send
			error_log('Notify - No From available / ' . print_r($info, true));

		} else if (!$info['to']) {
			// nobody to send
			error_log('Notify - No To available / ' . print_r($info, true));

		} else {
			error_log('Notify - Entering / ' . print_r($info, true));

			if ($info['reply_to_email']) {
				$reply_to_email = $info['reply_to_email'];
				$reply_to_name = (isset($info['reply_to_name'])) ? $info['reply_to_name'] : $info['reply_to_email'];
			} else {
				$reply_to_email = $from_email;
				$reply_to_name = $from_name;
			}

			if ($use_queue) {
				$email_queue = new EmailQueue();

				$email_queue->set_client_id($info['client_id']);
				$email_queue->set_email_delivery_id($info['email_delivery_id']);
				$email_queue->set_email_template_id($info['email_template_id']);

				$email_queue->set_sender(array('email' => $from_email, 'name' => $from_name));
				$email_queue->set_reply_to(array('email' => $reply_to_email, 'name' => $reply_to_name));

				$email_queue->set_recipient($info['to']);
				$email_queue->set_recipient_cc($info['cc']);
				$email_queue->set_recipient_bcc($info['bcc']);

				$email_queue->set_subject($info['subject']);
				$email_queue->set_body($info['body']);

				$email_queue->set_active(1);

				$email_queue_id = $email_queue->update();
				return $email_queue_id; // >>>>>>>>>>>>>>>>>> exit

			} else {
				if ($this->mailer) {
					// already connected

				} else {
					// get SMTP config
					$smtp = $this->get_property('smtp_connection');

					if (!is_array($smtp) || !sizeof($smtp)) {
						error_log('Notify No SMTP Config: ' . print_r($smtp, true));
						return false; // >>>>>>>>>>>>>>>>>>>>>> exit
					}
					$this->mailer = new PHPMailer();

					$this->mailer->IsSMTP();
					$this->mailer->SMTPAuth = true;

					$this->mailer->SMTPSecure = $smtp['encryption']; //'tls';
					$this->mailer->Port = $smtp['port']; //587;

					$this->mailer->Host = $smtp['host'];
					$this->mailer->Username = $smtp['username'];
					$this->mailer->Password = $smtp['password'];

					$this->mailer->SMTPKeepAlive = $keep_alive;
					$this->mailer->SMTPDebug = $smtp['debug'];
					$this->mailer->Debugoutput = 'error_log';

					$this->mailer->CharSet = 'UTF-8';
					//$this->mailer->Timeout = 1;
				}

				//if ($this->cfg->setting->language != 'en') {
				//	$this->mailer->setLanguage($this->cfg->setting->language, $this->cfg->path->mailer . '/language');
				//}

				$this->mailer->setFrom($from_email, $from_name);
				$this->mailer->addReplyTo($reply_to_email, $reply_to_name);

				foreach($info['to'] as $email => $name) {
					$this->mailer->addAddress($email, $name);
				}

				if ($info['cc']) {
					foreach($info['cc'] as $email => $name) {
						$this->mailer->addCC($email, $name);
					}
				}

				if ($info['bcc']) {
					foreach($info['bcc'] as $email => $name) {
						$this->mailer->addBCC($email, $name);
					}
				}

				$this->mailer->Subject = $info['subject'];
				$this->mailer->msgHTML($info['body']);

				if ($info['body_txt']) {
					$this->mailer->AltBody = $info['body_txt'];
				}

				if ($attachs = $info['attachs']) {
					if (!is_array($attachs)) {
						$attachs = array($attachs);
					}
					foreach($attachs as $attach) {
						$this->mailer->addAttachment($attach);
					}
				}

				//error_log('Notify Sending: ' . $from_email . ' | ' . print_r($info, true));

				//send the message, check for errors
				if (!$this->mailer->send()) {
					error_log('Notify Send Error: ' . $this->mailer->ErrorInfo); // . ' | ' . $from_email . ' | ' . print_r($info, true));
				}

				// clear addresses
				$this->mailer->clearAllRecipients();
				$this->mailer->clearAttachments();
			}
		}
	}

	// Properties

	public function get_property($key, $default = false, $dec_places = 2) {
		$property = new Property();
		$property->retrieve_by('property_key', $key);
		$id = $property->get_id();

		switch($property->get_type()) {
				case 'int':
				case 'trf':
					$value = (int)(($id) ? (int)$property->get_value() : $default);
					break;
				case 'dec':
					$value = number_format(($id) ? $property->get_value() : $default, $dec_places);
					break;
				case 'jsn':
					$value = ($id) ? json_decode($property->get_value_str(), true) : $default;
					break;
				default: // str
					$value = (string)(($id) ? $property->get_value_str() : $default);
			}

		return $value;
	}

	public function set_property($key, $value, $dec_places = 2) {
		$property = new Property();
		$property->retrieve_by('property_key', $key);

		switch($property->get_type()) {
				case 'int':
				case 'trf':
					$property->set_value((int)$value);
					break;
				case 'dec':
					$property->set_value(number_format($value, $dec_places));
					break;
				case 'jsn':
				default: // str
					$property->set_value_str((string)$value);
			}
		$property->update();
	}


/**
 * Indents a flat JSON string to make it more human-readable.
 * @param string $json The original JSON string to process.
 * @return string Indented version of the original JSON string.
 */
	public function json_pretty_print($json) {

		$result = '';
		$pos = 0;
		$strLen = strlen($json);
		$indentStr = '	';
		$newLine = "\n";
		$prevChar = '';
		$outOfQuotes = true;

		for ($i=0; $i<=$strLen; $i++) {

			// Grab the next character in the string.
			$char = substr($json, $i, 1);

			// Are we inside a quoted string?
			if ($char == '"' && $prevChar != '\\') {
				$outOfQuotes = !$outOfQuotes;

			// If this character is the end of an element,
			// output a new line and indent the next line.
			} else if(($char == '}' || $char == ']') && $outOfQuotes) {
				$result .= $newLine;
				$pos --;
				for ($j=0; $j<$pos; $j++) {
					$result .= $indentStr;
				}
			}

			// Add the character to the result string.
			$result .= $char;

			// added -----
			if ($char == ':') {
				// add a space
				$result .= ' ';
			}
			// -----------


			// If the last character was the beginning of an element,
			// output a new line and indent the next line.
			if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos ++;
				}

				for ($j = 0; $j < $pos; $j++) {
					$result .= $indentStr;
				}
			}

			$prevChar = $char;
		}

		return $result;
	}

	// from http://stackoverflow.com/questions/6054033/pretty-printing-json-with-php
	function json_pretty_print2($json) {
	    $result = '';
	    $level = 0;
	    $in_quotes = false;
	    $in_escape = false;
	    $ends_line_level = NULL;
	    $json_length = strlen( $json );

	    for( $i = 0; $i < $json_length; $i++ ) {
	        $char = $json[$i];
	        $new_line_level = NULL;
	        $post = "";
	        if( $ends_line_level !== NULL ) {
	            $new_line_level = $ends_line_level;
	            $ends_line_level = NULL;
	        }
	        if ( $in_escape ) {
	            $in_escape = false;
	        } else if( $char === '"' ) {
	            $in_quotes = !$in_quotes;
	        } else if( ! $in_quotes ) {
	            switch( $char ) {
	                case '}': case ']':
	                    $level--;
	                    $ends_line_level = NULL;
	                    $new_line_level = $level;
	                    break;

	                case '{': case '[':
	                    $level++;
	                case ',':
	                    $ends_line_level = $level;
	                    break;

	                case ':':
	                    $post = " ";
	                    break;

	                case " ": case "\t": case "\n": case "\r":
	                    $char = "";
	                    $ends_line_level = $new_line_level;
	                    $new_line_level = NULL;
	                    break;
	            }
	        } else if ( $char === '\\' ) {
	            $in_escape = true;
	        }
	        if( $new_line_level !== NULL ) {
	            $result .= "\n".str_repeat( "\t", $new_line_level );
	        }
	        $result .= $char.$post;
	    }

	    return $result;
	}

	public function clean_text($text, $length = false, $remove_cr = false) {
		$clean = strip_tags(html_entity_decode($text));
		$clean = preg_replace('/\s\s+/', ' ', $clean);
		if ($remove_cr) {
			$clean = str_replace("\n", ' ', $clean);
		}

		if ($length) {
			$clean = (strlen($clean) > $length) ? substr($clean, 0, $length - 1) . '&hellip;' : $clean;
		}

		return $clean;
	}

	// nl2p
	// This function will convert newlines to HTML paragraphs
	// without paying attention to HTML tags. Feed it a raw string and it will
	// simply return that string sectioned into HTML paragraphs

	public function nl2p($str) {
	    $arr=explode("\n",$str);
	    $out='';

	    for($i=0;$i<count($arr);$i++) {
	        if(strlen(trim($arr[$i]))>0)
	            $out.='<p>'.trim($arr[$i]).'</p>';
	    }
	    return $out;
	}



	// nl2p_html
	// This function will add paragraph tags around textual content of an HTML file, leaving
	// the HTML itself intact
	// This function assumes that the HTML syntax is correct and that the '<' and '>' characters
	// are not used in any of the values for any tag attributes. If these assumptions are not met,
	// mass paragraph chaos may ensue. Be safe.

	public function nl2p_html($str) {

	    // If we find the end of an HTML header, assume that this is part of a standard HTML file. Cut off everything including the
	    // end of the head and save it in our output string, then trim the head off of the input. This is mostly because we don't
	    // want to surrount anything like the HTML title tag or any style or script code in paragraph tags.
	    if(strpos($str,'</head>')!==false) {
	        $out=substr($str,0,strpos($str,'</head>')+7);
	        $str=substr($str,strpos($str,'</head>')+7);
	    }

	    // First, we explode the input string based on wherever we find HTML tags, which start with '<'
	    $arr=explode('<',$str);

	    // Next, we loop through the array that is broken into HTML tags and look for textual content, or
	    // anything after the >
	    for($i=0;$i<count($arr);$i++) {
	        if(strlen(trim($arr[$i]))>0) {
	            // Add the '<' back on since it became collateral damage in our explosion as well as the rest of the tag
	            $html='<'.substr($arr[$i],0,strpos($arr[$i],'>')+1);

	            // Take the portion of the string after the end of the tag and explode that by newline. Since this is after
	            // the end of the HTML tag, this must be textual content.
	            $sub_arr=explode("\n",substr($arr[$i],strpos($arr[$i],'>')+1));

	            // Initialize the output string for this next loop
	            $paragraph_text='';

	            // Loop through this new array and add paragraph tags (<p>...</p>) around any element that isn't empty
	            for($j=0;$j<count($sub_arr);$j++) {
	                if(strlen(trim($sub_arr[$j]))>0)
	                    $paragraph_text.='<p>'.trim($sub_arr[$j]).'</p>';
	            }

	            // Put the text back onto the end of the HTML tag and put it in our output string
	            $out.=$html.$paragraph_text;
	        }

	    }

	    // Throw it back into our program
	    return $out;
	}

	public function get_tab_error($missing_fields, $tab_fields) {
		$tab_error = array();

		foreach ($tab_fields as $tab_field) {
			$tab_error[] = (sizeof(array_intersect($missing_fields, $tab_field))) ? ' <i class="fa fa-warning red"></i>' : '';
		}
		return $tab_error;
	}

	public function get_token($length, $alpha_only = false) {
		if (!function_exists('openssl_random_pseudo_bytes')) {
			return $this->random_string($length, $alpha_only);

		} else {

		    $token = "";

		    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";

		    if (!$alpha_only) {
		    	$codeAlphabet .= "0123456789";
		    }

		    for($i = 0; $i < $length; $i++){
				$token .= $codeAlphabet[$this->crypto_rand_secure(0, strlen($codeAlphabet))];
		    }
		    return $token;
		}
	}

	private function random_string($length, $alpha_only) {
		$keys = array_merge(range('a', 'z'), range('A', 'Z'));

		if (!$alpha_only) {
			$keys = array_merge($keys, range(0, 9));
		}

		$key = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}

		return $key;
	}

	// from http://stackoverflow.com/questions/1846202/php-how-to-generate-a-random-unique-alphanumeric-string/13733588#13733588
	private function crypto_rand_secure($min, $max) {
		$range = $max - $min;

		if ($range < 0) {
			return $min; // not so random...
		}

		$log = log($range, 2);
		$bytes = (int) ($log / 8) + 1; 		// length in bytes
		$bits = (int) $log + 1; 			// length in bits
		$filter = (int) (1 << $bits) - 1; 	// set all lower bits to 1

		do {
		    $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
		    $rnd = $rnd & $filter; 			// discard irrelevant bits
		} while ($rnd >= $range);
		return $min + $rnd;
	}

	public function size_format($bytes) {
		$base = log($bytes) / log(1024);
		$suffixes = array('', ' kb', ' MB', ' GB', ' TB');
		$suffix = $suffixes[floor($base)];
		return number_format(pow(1024, $base - floor($base)), 2) . $suffix;
	}

}
?>
