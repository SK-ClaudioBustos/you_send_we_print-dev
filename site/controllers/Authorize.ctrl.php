<?php

class AuthorizeCtrl extends BaseCtrl {

	public function run($args) {
		$action = array_shift($args);
		switch ($action) {
			default:
				$this->run_default($args);
		}
	}

	private function run_default($args) {
		$credit_card = array(
			'name_card' => $this->get_input('name_card', '', true),
			'credit_card' => $this->get_input('credit_card', '', true),
			'card_number' => $this->get_input('card_number', '', true),
			'exp_month' => $this->get_input('exp_month', '', true),
			'exp_year' => $this->get_input('exp_year', '', true),
			'sec_code' => $this->get_input('sec_code', '', true),
		);


		$sale = new Sale();
		$sale->retrieve($_SESSION['sale_id'], false);

		$sale_bill_address = new SaleAddress();
		$sale_bill_address->retrieve_by_sale($sale->get_id(), $sale_bill_address->address_type_enum('bill'));

		$transaction_data = $this->send($sale, $credit_card, $sale_bill_address);

		if ($transaction_data) {
			// save transaction data
			$this->save($transaction_data);

			$url = $this->app->authorize_prods['10001']['return'];
			$this->app->redirect($url);

		} else {
			// no token
			// TODO: error message?
			header('Location: ' . $this->app->go('Cart/checkout'));
			exit;
		}
	}

	private function send($sale, $credit_card, $sale_bill_address) {
		$data = array();

		$data['x_login'] = $this->app->authorize_info['login_id'];
		$data['x_tran_key'] = $this->app->authorize_info['transaction_key'];
		$data['x_version'] = '3.1';
		$data['x_delim_data'] = 'TRUE';
		$data['x_delim_char'] = ',';
		$data['x_encap_char'] = '"';
		$data['x_relay_response'] = 'FALSE';
		$data['x_first_name'] = html_entity_decode($sale_bill_address->get_first_name(), ENT_QUOTES, 'UTF-8');
		$data['x_last_name'] = html_entity_decode($sale_bill_address->get_last_name(), ENT_QUOTES, 'UTF-8');
		$data['x_address'] = html_entity_decode($sale_bill_address->get_address(), ENT_QUOTES, 'UTF-8');
		$data['x_city'] = html_entity_decode($sale_bill_address->get_city(), ENT_QUOTES, 'UTF-8');
		$data['x_state'] = html_entity_decode($sale_bill_address->get_state(), ENT_QUOTES, 'UTF-8');
		$data['x_zip'] = html_entity_decode($sale_bill_address->get_zip(), ENT_QUOTES, 'UTF-8');
		$data['x_country'] = html_entity_decode($sale_bill_address->get_country(), ENT_QUOTES, 'UTF-8');
		$data['x_phone'] = $sale_bill_address->get_phone();
		$data['x_email'] = $sale_bill_address->get_email();
		$data['x_description'] = html_entity_decode('Sale in yousendweprint.com #' . $sale->get_id(), ENT_QUOTES, 'UTF-8');
		$data['x_amount'] = number_format($sale->get_total(), 2, '.', '');
		$data['x_method'] = 'CC';
		$data['x_card_num'] = str_replace('-', '', $credit_card['card_number']);
		$data['x_exp_date'] = $credit_card['exp_month'] . $credit_card['exp_year'];
		$data['x_card_code'] = $credit_card['sec_code'];

		if ($this->app->authorize_info['transaction_mode'] == 'testMode') {
			$data['x_test_request'] = 'TRUE';
		}

		$curl = curl_init($this->app->authorize_info['transaction_server']);

		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

		$response = curl_exec($curl);

		curl_close($curl);

		$i = 1;
		$response_data = array();
		$results = explode(',', $response);
		foreach ($results as $result) {
			$response_data[$i] = trim($result, '"');
			$i++;
		}

		//echo '<pre>';print_r($response_data);die('</pre>');
		if ($response_data[1] == '1') {
			return $response_data;
		} else {
			error_log('Authorize error >>> ' . $response_data[4]);
			$_SESSION['payment_error'] = $response_data[4];
			return false;
		}
	}

	private function save($transaction_data) {
		$authorize = new Authorize();
		$authorize->set_sale_id($_SESSION['sale_id']);
		$authorize->set_response_code($transaction_data[1]);
		$authorize->set_response_reason_code($transaction_data[3]);
		$authorize->set_response_reason_text($transaction_data[4]);
		$authorize->set_authorization_code($transaction_data[5]);
		$authorize->set_avs_response($transaction_data[6]);
		$authorize->set_transaction_id($transaction_data[7]);
		$authorize->set_description($transaction_data[9]);
		$authorize->set_amount($transaction_data[10]);
		$authorize->set_method($transaction_data[11]);
		$authorize->set_transaction_type($transaction_data[12]);
		$authorize->set_md5_hash($transaction_data[38]);
		$authorize->set_card_code_response($transaction_data[39]);
		$authorize->set_cavr($transaction_data[40]);
		$authorize->set_account_number($transaction_data[51]);
		$authorize->set_card_type($transaction_data[52]);

		$authorize->update();
	}
}

?>