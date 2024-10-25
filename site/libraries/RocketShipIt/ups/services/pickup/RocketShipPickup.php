<?php
//{{PICKUP

// Main class for sending soap requests to the pickup API.
// This is not done in XML because UPS doesn't support XML
// for pickup requests.
function upsSoapRequest($request, $methodCode) {

    // Get credential information from config
    $license = getUPSDefault('license');
    $username = getUPSDefault('username');
    $password = getUPSDefault('password');

    if (getGenericDefault("debugMode") == 1) {
        $soapUrl = "https://wwwcie.ups.com/webservices/Pickup";
    } else {
        $soapUrl = "https://onlinetools.ups.com/webservices/Pickup";
    }

    $client = new SoapClient(__DIR__ . "/schemas/UPSPickup/Pickup.wsdl", array('trace' => 1, "location" => $soapUrl));
    $ns = "http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0";
    $security = array("UsernameToken" => array("Username" => $username, "Password" => $password), "ServiceAccessToken" => array("AccessLicenseNumber" => $license));
    $header = new SOAPHeader($ns, "UPSSecurity", $security);
    $client->__setSoapHeaders($header);

    //var_dump($client->__getFunctions());die();
    
    $methods = array(
        0 => 'ProcessPickupCreation',
        1 => 'ProcessPickupRate',
        2 => 'ProcessPickupCancel',
        3 => 'ProcessPickupPendingStatus',
    );
    
    try {
            $response = call_user_func_array(array($client, $methods[$methodCode]), array($request));
            //$response = $client->PessPickupRate($request);
        } catch(exception $ex) {
            echo $ex->faultstring;
            print_r($ex->detail);
            //echo $client->__getLastRequest();
            //var_dump($ex->faultcode, $ex->faultstring, $ex->detail);
            //echo $fault->getMessage();
            //echo $fault->faultstring();
            //echo $client->__getLastResponse();
    }
    //echo $client->__getLastRequest();
    return $response;
}

class RocketShipPickup {

	/**
     * Class constructor
     * 
     * @param $carrier
     */
    function __Construct($carrier) {
        rocketshipit_validateCarrier($carrier);
        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        
        $this->OKparams = rocketshipit_getOKparams($carrier);
        foreach ($this->OKparams as $param) {
            $this->setParameter($param, '');
        }
    }
    
	/**
     * Sets paramaters to be used in {@link RocketShipPickup() RocketShipPickup}.
     *
     * Only valid parameters are accepted.  
     * @see getOKparams()
     */
    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->{$param} = $value;
    }
    
    function getPickupRate() {
        switch ($this->carrier) {
            case "UPS":
                return $this->upsRateRequest();
            case "USPS":
                return '';
            case "FEDEX":
                return '';
        }
    }

    function createPickupRequest() {
        switch ($this->carrier) {
            case "UPS":
                return $this->upsPickupCreationRequest();
            case "USPS":
                return '';
            case "FEDEX":
                return '';
        }
    }
    
    function requestPendingStatus() {
        switch ($this->carrier) {
            case "UPS":
                return $this->upsPendingStatusRequest();
            case "USPS":
                return '';
            case "FEDEX":
                return '';
        }
    }
    
    function cancelPickupRequest() {
        switch ($this->carrier) {
            case "UPS":
                return $this->upsPickupCancelRequest();
            case "USPS":
                return '';
            case "FEDEX":
                return '';
        }
    }
    
    //{{_UPS
    function upsRateRequest() {
        $request = array();

        // Pickup address
        $a = array();
        $a['AddressLine'] = $this->pickupAddr1;
        $a['City'] = $this->pickupCity;
        $a['StateProvince'] = $this->pickupState;
        $a['PostalCode'] = $this->pickupCode;
        $a['CountryCode'] = $this->pickupCountry;
        if ($this->pickupResidential != '') {
            $a['ResidentialIndicator'] = 'Y';
        } else {
            $a['ResidentialIndicator'] = 'N';
        }

        $request['Request'] = '';
        $request['PickupAddress'] = $a;

        // Y - Indicates alternative address than what is associated with shipper account
        // N - Default address associated with shipper account, defaults to N
        if ($this->pickupAlternative != '') {
            $request['AlternateAddressIndicator'] = 'Y';
        } else {
            $request['AlternateAddressIndicator'] = 'N';
        }

        if ($this->pickupDate != '') {
            $pickupDate = array();
            $pickupDate['CloseTime'] = $this->closeTime; //HHmm 0-23, 0-59
            $pickupDate['ReadyTime'] = $this->readyTime; //HHmm 0-23, 0-59
            $pickupDate['PickupDate'] = $this->pickupDate; //yyyyMMdd
            $request['PickupDateInfo'] = $pickupDate;
        }

        // 01 - Same-Day pickup
        // 02 - Future-Day pickup
        // 03 - A Specific-Day pickup
        $request['ServiceDateOption'] = '02';

        return upsSoapRequest($request, 1);
    }
    //}}
    
    //{{_UPS
    function upsPendingStatusRequest() {
        $request = array();
        $request['Request'] = '';
        
        $request['PickupType'] = "01";
        $request['AccountNumber'] = $this->accountNumber;
        
        return upsSoapRequest($request, 3);
    }
    //}}
    
    //{{_UPS
    function upsPickupCreationRequest() {
        $request = array();
        $request['Request'] = '';
        
        $request['RatePickupIndicator'] = 'Y';
            
        // Pickup Address
        $request['PickupAddress'] = array(
            'CompanyName'	       => $this->pickupCompanyName,
            'ContactName'	       => $this->pickupContactName,
            'AddressLine'          => $this->pickupAddr1,
            'City'                 => $this->pickupCity,
            'StateProvince'        => $this->pickupState,
            'PostalCode'           => $this->pickupCode,
            'CountryCode'          => $this->pickupCountry,
            'Phone'                => array('Number' => $this->pickupPhone),
            'ResidentialIndicator' => ($this->pickupResidential != '' ? 'Y' : 'N'),
        );
        
        if($this->pickupRoom) {
            $request['PickupAddress']['Room'] = $this->pickupRoom;
        }
        
        if($this->pickupRoom) {
            $request['PickupAddress']['Floor'] = $this->pickupFloor;
        }
        
        $request['AlternateAddressIndicator'] = ($this->pickupAlternative != '' ? 'Y' : 'N');
        
        // Tracking number
        if($this->trackingNumber != "") {
            $request['TrackingData'] = array(
                "TrackingNumber" => $this->trackingNumber,
            );
        }
        
        // Pickup Date Info
        $request['PickupDateInfo'] = array(
            'CloseTime'  => $this->closeTime,
            'ReadyTime'  => $this->readyTime,
            'PickupDate' => $this->pickupDate,
        );
        
        /**
         * Pickup Piece Type
         * 
         * ServiceCode:
         * 001 - UPS Next Day Air
         * 002 - UPS Next Day Air
         * 003 - UPS Ground
         * 004 - UPS Ground, UPS Standard
         * 007 - UPS Worldwide Express
         * 008 - UPS Worldwide Expedited
         * 011 - UPS Standard
         * 012 - UPS Three Day Select
         * 013 - UPS Next Day Air Saver
         * 014 - UPS Next Day Air Early A.M.
         * 021 - UPS Economy
         * 031 - UPS Basic
         * 054 - UPS Worldwide Express Plus
         * 059 - UPS Second Day Air A.M.
         * 064 - UPS Express NA1
         * 065 - UPS Saver
         * 082 - UPS Today Standard
         * 083 - UPS Today Dedicated Courier
         * 084 - UPS Today Intercity
         * 085 - UPS Today Express
         * 086 - UPS Today Express Saver
         * 
         * ContainerCode:
         * 01 = PACKAGE
         * 02 = UPS LETTER
         */
        $request['PickupPiece'] = array(
        	'ServiceCode'            => $this->pickupServiceCode,
            'Quantity'               => $this->pickupQuantity,
            'DestinationCountryCode' => $this->pickupDestination,
            'ContainerCode'          => $this->pickupContainerCode,
        );
        
        $request['OverweightIndicator'] = ($this->pickupOverweight != '' ? 'N' : 'Y');
        
        $request['Shipper'] = array(
            'Account' => array(
                'AccountNumber'      => $this->accountNumber,
                'AccountCountryCode' => $this->pickupCountry,
            )
        );
        
        /**
         * Pickup Method Type
         * 
         * 00 = No payment needed
		 * 01 = Pay by shipper account
		 * 02 = Pay by return service
		 * 03 = Pay by charge card
		 * 04 = Pay by tracking number
         */
        $request['PaymentMethod'] = $this->paymentMethodCode;
        
        /**
         * Pickup Charge Card
         * 
         * CardType:
         * 01 = American Express
 		 * 03 = Discover	
 		 * 04 = Mastercard
		 * 06 = VISA
		 * 
		 * ExpirationDate: yyyyMM
		 * SecurityCode: 3 or 4 digit
         */
        if($this->paymentMethodCode == '03') {
            $request['Shipper']['ChargeCard'] = array(
				"CardHolderName" => $this->pickupCardHolder,
				"CardType"       => $this->pickupCardType, 
				"CardNumber"     => $this->pickupCardNumber,
                "ExpirationDate" => $this->pickupCardExpiry, 
      			"SecurityCode"   => $this->pickupCardSecurity,
      			"CardAddress"    => array(
                    "Address"     => $this->pickupCardAddress,
                    "CountryCode" => $this->pickupCardCountry,
                )
            );
        }
        
        return upsSoapRequest($request, 0);
    }
    //}}
    
    //{{_UPS
    function upsPickupCancelRequest() {
        $request = array();
        $request['Request'] = '';
        
        $request['CancelBy'] = '02';
        $request['PRN'] = $this->pickupPRN;
        
        return upsSoapRequest($request, 2);
    }
    //}}
}
//}}

?>
