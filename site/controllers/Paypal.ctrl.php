<?php
// settings at _Main.ctrl.php

class PaypalCtrl extends BaseCtrl {

	public function run($args) {
		$action = $args[0];
error_log('PaypalCtrl Run args: ' . print_r($args, true));
		switch($action) {
			case 'ajax_form':		$this->run_ajax_form($args); break;
			case 'ipn':				$this->run_ipn($args); break;
			case 'pdt':				$this->run_pdt($args); break;
			case 'ajax_confirm':	$this->run_ajax_confirm($args); break;

			default:				$this->run_default($args, $action);
		}
	}


	protected function run_default($args, $action) {
		// it shouldn't be here
error_log('Paypal run_default? ' . $action . ' | ' . $_SESSION['paypal_token'] . ' | ' . $_POST['txn_id']);
error_log(print_r($_POST, true));

		// where to go?
		$this->app->redirect($this->app->go('Home'));
		exit;
	}

	protected function run_ajax_confirm($args = []){
		$data = [
				'transaction_id' => $this->get_input('transaction_id', '', true),
				'status' => $this->get_input('status', '', true),
				'email' => $this->get_input('email', '', true),
				'payer_id' => $this->get_input('payer_id', '', true),
				'value' => $this->get_input('value', '', true),
				'value_site' => $this->get_input('value_site', '', true),
				'full_name' => $this->get_input('full_name', '', true),
				'full_address' => $this->get_input('full_address', '', true)
		];

		$sale = new Sale();
		$sale->retrieve($_SESSION['sale_id'],false,false);
		if (($data['value'] != $sale->get_total())|| $data['status'] != 'COMPLETED') {
			echo $data['value'] .' '. $sale->get_total();
			exit;
		}

		$paypal = new New_paypal();
		$paypal->set_sale_id($_SESSION['sale_id']);
		$paypal->set_transaction_id($data['transaction_id']);
		$paypal->set_status($data['status']);
		$paypal->set_email($data['email']);
		$paypal->set_payer_id($data['payer_id']);
		$paypal->set_value($data['value']);
		$paypal->set_full_name($data['full_name']);
		$paypal->set_full_address($data['full_address']);
		$paypal->set_active(1);
		$paypal->update();

		echo 1;
		exit;
	}

	protected function run_ajax_form($args) {
		if ($item_number = $this->get_input('item_number', '', true)) {

			if (isset($this->app->paypal_prods[$item_number])) {

				$paypal = array(
						'info' => $this->app->paypal_info,
						'product' => $this->app->paypal_prods[$item_number],
					);

			} else {
				// invalid item number
				$paypal = array(
						'error' => 'invalid item number: ' . $item_number,
					);
			}
		} else {
			// no item number
			$paypal = array(
					'error' => 'no number',
				);
		}

		header('Content-type: application/json');
		echo json_encode($paypal);

	}


	// Examines all the IPN and turns it into a string
	protected function array2str($kvsep, $entrysep, $a) {
		$str = "";
		foreach ($a as $k => $v) {
			$str .= "{$k}{$kvsep}{$v}{$entrysep}";
		}
		return $str;
	}


	protected function run_pdt($args) {
error_log('PDT 101 >>> ');
error_log(print_r($_POST, true));
		//if (isset($_SESSION['paypal_token']) && isset($_POST['txn_id'])) {
		if (isset($_POST['txn_id'])) {
error_log('PDT 102 >>> txn_id ok');

			$paypal = $this->save('pdt');

			if (is_array($paypal['items'])) {
				// cart
				//error_log('Paypal cart not implemented' . $item_number);
				error_log('Paypal cart not implemented' . $paypal['item_number']);
				// where to go?
				$this->app->redirect($this->app->go('Home'));
				exit;

			} else {
				// single item
				$item_number = $paypal['items'];
				if (isset($this->app->paypal_prods[$item_number])) {
					$return = $this->app->paypal_prods[$item_number]['return'];

				} else {
					error_log('Return url not available - Item number ' . $item_number);
					$return = $this->app->go('Home');
				}

error_log('PDT 103 >>> return: ' . $return);
				$this->app->redirect($return);
			}

		} else {
			// redirected twice???
error_log('PDT 104 >>> missing txn_id ' . $_SESSION['paypal_token'] . '|' . $_POST['txn_id']);
error_log(print_r($_POST, true));

			// wait for previous PDT or IPN complete
			sleep(5);

			// look for a saved payment
			$paypal = new Paypal();
			$paypal->retrieve_by('custom', $_SESSION['paypal_token'], false);

error_log('PDT 105 >>> try to recover');

			if ($paypal->get_id() && $paypal->get_payment_status() == 'Completed') {
error_log('PDT 106 >>> try to recover - found' . $paypal->get_id());

				$paypal_item = new PaypalItem();
				$paypal_item->retrieve_by('paypal_id', $paypal->get_id(), false);

error_log('PDT 107 >>> try to recover item');
				if ($paypal_item->get_id()) {
error_log('PDT 108 >>> try to recover item - found');

					$item_number = $paypal_item->get_item_number();
					if (isset($this->app->paypal_prods[$item_number])) {
						$return = $this->app->paypal_prods[$item_number]['return'];

					} else {
						error_log('Return url not available - Item number ' . $item_number);
						$return = $this->app->go('Home');
					}

					//$this->redirect($return);
					$this->app->redirect($return);
				}

			}

			// where to go?
			//$this->redirect($this->app->go('Home'));
			$this->app->redirect($this->app->go('Home'));

		}
	}

	protected function run_ipn($args) {
		// Verifying paypal message - Using POST vars rm=2 in html form
		error_log("IPN: " . print_r($args, true));
		$paypal_info = $this->app->paypal_info;

		$req = 'cmd=_notify-validate';
		$fullipnA = array();

		foreach ($_POST as $key => $value) {
			$fullipnA[$key] = $value;
			$encodedvalue = urlencode(stripslashes($value));
			$req .= "&$key=$encodedvalue";
		}

		$fullipn = $this->array2str(" : ", "\n", $fullipnA);

		$url = $paypal_info['url'];

		// ask Paypal for confirmation
		$curl_result = $curl_err = '';
		$fp = curl_init();
		curl_setopt($fp, CURLOPT_URL, $url);
		curl_setopt($fp, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($fp, CURLOPT_POST, 1);
		curl_setopt($fp, CURLOPT_POSTFIELDS, $req);
		curl_setopt($fp, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
		curl_setopt($fp, CURLOPT_HEADER , 0);
		curl_setopt($fp, CURLOPT_VERBOSE, 1);
		curl_setopt($fp, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($fp, CURLOPT_TIMEOUT, 30);

		// Paypal response
		$response = curl_exec($fp);
		$curl_err = curl_error($fp);
		curl_close($fp);

		$payment_status = $_POST['payment_status'];

		if (strcmp($response, "VERIFIED") == 0) {

			// Check the status of the order
			if ($payment_status != "Completed") {
				//send_mail('The payment was not accepted by paypal - Payment Status: '. $payment_status, $paypal_info['email']);
				error_log('The payment was not accepted by paypal - Payment Status: ' . $payment_status);

			}

			// all good so far, the transaction has been confirmed so I can do all -> Update DB, stock, credit computations, activate accounts etc etc
			$this->save('ipn');

		} else {
		  	//the transaction is invalid I can NOT charge the client.
			//send_mail("Invalid payment - $fullipn", $email);
			error_log('Paypal Invalid payment - ' . $fullipn);
		}

	}


	private function save($via) {
		$data = array(
				'invoice' => $this->get_input('invoice', '', true),
				'custom' => $this->get_input('custom', '', true),
				'test_ipn' => $this->get_input('test_ipn', '', true),
				'memo' => $this->get_input('memo', '', true),

				'business' => $this->get_input('business', '', true),
				'receiver_id' => $this->get_input('receiver_id', '', true),
				'receiver_email' => $this->get_input('receiver_email', '', true),

				'first_name' => $this->get_input('first_name', '', true),
				'last_name' => $this->get_input('last_name', '', true),
				'contact_phone' => $this->get_input('contact_phone', '', true),
				'address_city' => $this->get_input('address_city', '', true),
				'address_country' => $this->get_input('address_country', '', true),
				'address_country_code' => $this->get_input('address_country_code', '', true),
				'address_name' => $this->get_input('address_name', '', true),
				'address_state' => $this->get_input('address_state', '', true),
				'address_status' => $this->get_input('address_status', '', true),
				'address_street' => $this->get_input('address_street', '', true),
				'address_zip' => $this->get_input('address_zip', '', true),

				'payer_business_name' => $this->get_input('payer_business_name', '', true),
				'payer_email' => $this->get_input('payer_email', '', true),
				'payer_id' => $this->get_input('payer_id', '', true),
				'payer_status' => $this->get_input('payer_status', '', true),
				'residence_country' => $this->get_input('residence_country', '', true),

				'txn_id' => $this->get_input('txn_id', '', true),
				'txn_type' => $this->get_input('txn_type', '', true),
				'transaction_entity' => $this->get_input('transaction_entity', '', true),

				'tax' => $this->get_input('tax', '', true),
				'auth_id' => $this->get_input('auth_id', '', true),
				'auth_exp' => $this->get_input('auth_exp', '', true),
				'auth_status' => $this->get_input('auth_status', '', true),
				'auth_amount' => $this->get_input('auth_amount', '', true),

				'num_cart_items' => $this->get_input('num_cart_items', 0),
				'mc_currency' => $this->get_input('mc_currency', '', true),
				'exchange_rate' => $this->get_input('exchange_rate', '', true),
				'mc_fee' => $this->get_input('mc_fee', '', true),
				'mc_gross' => $this->get_input('mc_gross', '', true),

				'parent_txn_id' => $this->get_input('parent_txn_id', '', true),
				'payment_date' => $this->get_input('payment_date', '', true),
				'payment_status' => $this->get_input('payment_status', '', true),
				'payment_type' => $this->get_input('payment_type', '', true),

				'pending_reason' => $this->get_input('pending_reason', '', true),
				'reason_code' => $this->get_input('reason_code', '', true),
				'remaining_settle' => $this->get_input('remaining_settle', '', true),

				'mc_handling' => $this->get_input('mc_handling', '', true),
				'mc_shipping' => $this->get_input('mc_shipping', '', true),

				'settle_currency' => $this->get_input('settle_currency', '', true),
				'case_id' => $this->get_input('case_id', '', true),
				'case_type' => $this->get_input('case_type', '', true),
				'case_creation_date' => $this->get_input('case_creation_date', '', true),

				'handling' => $this->get_input('handling', '', true),
				'shipping' => $this->get_input('shipping', '', true),

				'settle_amount' => $this->get_input('settle_amount', '', true),
				'auction_buyer_id' => $this->get_input('auction_buyer_id', '', true),
				'auction_closing_date' => $this->get_input('auction_closing_date', '', true),
				'auction_multi_item' => $this->get_input('auction_multi_item', '', true),
				'for_auction' => $this->get_input('for_auction', '', true),

				'subscr_date' => $this->get_input('subscr_date', '', true),
				'subscr_effective' => $this->get_input('subscr_effective', '', true),
				'period1' => $this->get_input('period1', '', true),
				'period2' => $this->get_input('period2', '', true),
				'period3' => $this->get_input('period3', '', true),
				'amount1' => $this->get_input('amount1', '', true),
				'amount2' => $this->get_input('amount2', '', true),
				'amount3' => $this->get_input('amount3', '', true),
				'mc_amount1' => $this->get_input('mc_amount1', '', true),
				'mc_amount2' => $this->get_input('mc_amount2', '', true),
				'mc_amount3' => $this->get_input('mc_amount3', '', true),
				'recurring' => $this->get_input('recurring', '', true),

				'reattempt' => $this->get_input('reattempt', '', true),
				'retry_at' => $this->get_input('retry_at', '', true),
				'recur_times' => $this->get_input('recur_times', '', true),

				'username' => $this->get_input('username', '', true),
				'password' => $this->get_input('password', '', true),
				'subscr_id' => $this->get_input('subscr_id', '', true),
				'receipt_id' => $this->get_input('receipt_id', '', true),
			);

		error_log('New payment was successfully recieved from ' . $data['payer_email'] . ' | ' . $via);

		// user_id
		$custom = explode('-', $data['custom']);

		$object = new Paypal();

		// fill the object
		$object->set_via($via);

		if (is_array($custom)) {
			$object->set_user_id((int)$custom[0]);
		}

		$object->set_invoice($data['invoice']);
		$object->set_custom($data['custom']);
		$object->set_test_ipn($data['test_ipn']);
		$object->set_memo($data['memo']);
		$object->set_business($data['business']);
		$object->set_receiver_id($data['receiver_id']);
		$object->set_receiver_email($data['receiver_email']);
		$object->set_first_name($data['first_name']);
		$object->set_last_name($data['last_name']);
		$object->set_contact_phone($data['contact_phone']);
		$object->set_address_city($data['address_city']);
		$object->set_address_country($data['address_country']);
		$object->set_address_country_code($data['address_country_code']);
		$object->set_address_name($data['address_name']);
		$object->set_address_state($data['address_state']);
		$object->set_address_status($data['address_status']);
		$object->set_address_street($data['address_street']);
		$object->set_address_zip($data['address_zip']);
		$object->set_payer_business_name($data['payer_business_name']);
		$object->set_payer_email($data['payer_email']);
		$object->set_payer_id($data['payer_id']);
		$object->set_payer_status($data['payer_status']);
		$object->set_residence_country($data['residence_country']);
		$object->set_txn_id($data['txn_id']);
		$object->set_txn_type($data['txn_type']);
		$object->set_transaction_entity($data['transaction_entity']);
		$object->set_tax($data['tax']);
		$object->set_auth_id($data['auth_id']);
		$object->set_auth_exp($data['auth_exp']);
		$object->set_auth_status($data['auth_status']);
		$object->set_auth_amount($data['auth_amount']);
		$object->set_num_cart_items($data['num_cart_items']);
		$object->set_mc_currency($data['mc_currency']);
		$object->set_exchange_rate($data['exchange_rate']);
		$object->set_mc_fee($data['mc_fee']);
		$object->set_mc_gross($data['mc_gross']);
		$object->set_parent_txn_id($data['parent_txn_id']);
		$object->set_payment_date($data['payment_date']);
		$object->set_payment_status($data['payment_status']);
		$object->set_payment_type($data['payment_type']);
		$object->set_pending_reason($data['pending_reason']);
		$object->set_reason_code($data['reason_code']);
		$object->set_remaining_settle($data['remaining_settle']);
		$object->set_mc_handling($data['mc_handling']);
		$object->set_mc_shipping($data['mc_shipping']);
		$object->set_settle_currency($data['settle_currency']);
		$object->set_case_id($data['case_id']);
		$object->set_case_type($data['case_type']);
		$object->set_case_creation_date($data['case_creation_date']);
		$object->set_handling($data['handling']);
		$object->set_shipping($data['shipping']);
		$object->set_settle_amount($data['settle_amount']);
		$object->set_auction_buyer_id($data['auction_buyer_id']);
		$object->set_auction_closing_date($data['auction_closing_date']);
		$object->set_auction_multi_item($data['auction_multi_item']);
		$object->set_for_auction($data['for_auction']);
		$object->set_subscr_date($data['subscr_date']);
		$object->set_subscr_effective($data['subscr_effective']);
		$object->set_period1($data['period1']);
		$object->set_period2($data['period2']);
		$object->set_period3($data['period3']);
		$object->set_amount1($data['amount1']);
		$object->set_amount2($data['amount2']);
		$object->set_amount3($data['amount3']);
		$object->set_mc_amount1($data['mc_amount1']);
		$object->set_mc_amount2($data['mc_amount2']);
		$object->set_mc_amount3($data['mc_amount3']);
		$object->set_recurring($data['recurring']);
		$object->set_reattempt($data['reattempt']);
		$object->set_retry_at($data['retry_at']);
		$object->set_recur_times($data['recur_times']);
		$object->set_username($data['username']);
		$object->set_password($data['password']);
		$object->set_subscr_id($data['subscr_id']);
		$object->set_receipt_id($data['receipt_id']);

		$object->set_active(0); // 1??
		$paypal_id = $object->update();

		$payment_status = $data['payment_status'];

		if ($items = $data['num_cart_items']) {
			$item_arr = array();
			for ($i = 1; $i <= $items; $i++) {
				$data = array(
						'item_name' => $this->get_input('item_name' . $i, '', true),
						'item_number' => $this->get_input('item_number' . $i, '', true),
						'quantity' => $this->get_input('quantity' . $i, 0),
						'mc_gross' => $this->get_input('mc_gross' . $i, 0.00),

						'option_name1' => $this->get_input('option_name1', '', true),
						'option_selection1' => $this->get_input('option_selection1', '', true),
						'option_name2' => $this->get_input('option_name2', '', true),
						'option_selection2' => $this->get_input('option_selection2', '', true),
					);

				$this->save_item($data, $paypal_id, $i, 1);
				$item_arr[] = $data['item_number'];
			}
			return array('id' => $paypal_id, 'payment_status' => $payment_status, 'items' => $item_arr);

		} else {
			$data = array(
					'item_name' => $this->get_input('item_name', '', true),
					'item_number' => $this->get_input('item_number', '', true),
					'quantity' => $this->get_input('quantity', '', true),
					'mc_gross' => $this->get_input('mc_gross', '', true),

					'option_name1' => $this->get_input('option_name1', '', true),
					'option_selection1' => $this->get_input('option_selection1', '', true),
					'option_name2' => $this->get_input('option_name2', '', true),
					'option_selection2' => $this->get_input('option_selection2', '', true),
				);

			$this->save_item($data, $paypal_id, 1, 1);
			return array('id' => $paypal_id, 'payment_status' => $payment_status, 'items' => $data['item_number']);
		}
	}

	private function save_item($data, $paypal_id, $number, $active) {
		$item = new PaypalItem();

		$item->set_paypal_id($paypal_id);
		$item->set_number($number);
		$item->set_item_name($data['item_name']);
		$item->set_item_number($data['item_number']);
		$item->set_quantity($data['quantity']);
		$item->set_mc_gross($data['mc_gross']);

		$item->set_option_name1($data['option_name1']);
		$item->set_option_selection1($data['option_selection1']);
		$item->set_option_name2($data['option_name2']);
		$item->set_option_selection2($data['option_selection2']);

		$item->set_active($active);
		$item->update();

	}
}
?>