<?php
class ShipEngine {

	protected $parameters = array();

	// required: 'toCode', 'weight'


	public function __construct($carrierId) {
		$this->setParameter('carrierId', $carrierId);
	}


	public function setParameter($parameter, $value) {
		$this->parameters[$parameter] = $value;
	}

	public function getSimpleRates() {
		$info = array(
				'from_country_code' => 'US',
				'from_postal_code' => $this->parameters['shipFrom']['postal_code'],
				'to_country_code' => 'US',
				'to_postal_code' => $this->parameters['toCode'],
				'weight' => array(
						'value' => $this->parameters['weight'],
						'unit' => 'pound',
					),
				'carrier_ids' => array(
						$this->parameters['carrierId'],
					),
				'confirmation' => 'none',
				'address_residential_indicator' => 'no',
			);

		$ch = curl_init();
		$curlConfig = array(
				CURLOPT_URL => $this->parameters['shipUrl'] . 'rates/estimate',
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => array(
						"Content-Type: application/json",
						"api-key: mI18sYNhrdQlLyCFwQCr9MPbm8x7fBO8Cg5m5kHrDyM"
					),
				CURLOPT_POSTFIELDS => json_encode($info)
			);
		curl_setopt_array($ch, $curlConfig);
		$result = curl_exec($ch);
		curl_close($ch);

		$rates_full = json_decode($result, true);

		$rates = array();
		if (sizeof($rates_full)) {
			foreach($rates_full as $rate) {
				if (sizeof($rate['error_messages'])) {
					$rates['error'] = implode(' / ', $rate['error_messages']);
					break;
				}
				$type = str_replace('®', '', $rate['service_type']) . sprintf(' (%s biz day/s)', $rate['delivery_days']);

				$rates[$type] = $rate['shipping_amount']['amount'] + $rate['other_amount']['amount'];
			}

		} else {
			$rates['error'] = 'no_rates';
		}
		asort($rates);

		return $rates;
	}

	public function getFullRates() {
		$info = array(
				'shipment' => array(
						'validate_address' => 'no_validation',
						'ship_to' => array(
								'postal_code' => $this->parameters['toCode'],
							),
						'ship_from' => $this->parameters['shipFrom'],
						'packages' => array(
								array(
										'weight' => array(
												'value' => $this->parameters['weight'],
												'unit' => 'pound',
											),
									)
							)
					),
				'rate_options' => array(
						'carrier_ids' => array(
								$this->parameters['carrierId'],
							)
					),
			);

		$ch = curl_init();
		$curlConfig = array(
				CURLOPT_URL => $this->parameters['shipUrl'] . 'rates',
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => array(
						"Content-Type: application/json",
						"api-key: mI18sYNhrdQlLyCFwQCr9MPbm8x7fBO8Cg5m5kHrDyM"
					),
				CURLOPT_POSTFIELDS => json_encode($info)
			);
		curl_setopt_array($ch, $curlConfig);
		$result = curl_exec($ch);
		curl_close($ch);
	}
}
?>