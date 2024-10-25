<?php
//{{VALIDATE
/**
* Main Address Validation class for carrier.
*
* Valid carriers are: UPS, USPS, STAMPS, and FedEx.
*/
class RocketShipUPSAddressValidate {

    // Set variable for valid parameters
    var $OKparams;
    var $carrier; // Set variable for carrier

    function __Construct($license='',$username='',$password='') {
        $carrier = 'UPS';
        // Validate carrier name
        rocketshipit_validateCarrier($carrier);

        $this->carrier = strtoupper($carrier);
        $this->OKparams = rocketshipit_getOKparams($carrier);

        // Set up core class and grab carrier-specific defaults that are unique to the current carrier
        if ($this->carrier == "UPS") {
            $this->core = new ups($license, $username, $password); // This class depends on ups

            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }

            if ($license != '') {
                $this->core->license = $license;
            }
            if ($username != '') {
                $this->core->username = $username;
            }
            if ($password != '') {
                $this->core->password = $password;
            }
        }
        if ($this->carrier == 'FEDEX') {
            $this->core = new fedex(); // This class depends on fedex
            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }
        }
        if ($this->carrier == 'STAMPS') {
            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }
            $this->core = new stamps(); // This class depends on stamps
        }
    }

    //{{_UPS
    // Builds xml for a rate request converts xml to a string, sends the xml to ups,
    // stores the xmlSent and xmlResponse in the ups class incase you want to see it.
    // Finally, this class returns the xml response from UPS as an array.
    function getUPSValidate() {
        // Grab the auth portion of the xml from the ups class
        $this->core->access();
        $accessXml = $this->core->xmlObject;

        // Start a new xml object
        $xml = new xmlBuilder();

        $xml->push('AddressValidationRequest',array('xml:lang' => 'en-US'));
            $xml->push('Request');
                $xml->push('TransactionReference'); // Not required
                    $xml->element('CustomerContext', 'RocketShipIt'); // Not required
                    //$xml->element('XpciVersion', '1.0'); // Not required
                $xml->pop(); // close TransactionReference, not required
                $xml->element('RequestAction', 'AV');
            $xml->pop(); // Close Request
            $xml->push('Address');
                if ($this->toCity != '') {
                    $xml->element('City',$this->toCity);
                }
                if ($this->toState != '') {
                    $xml->element('StateProvinceCode',$this->toState);
                }
                if ($this->toCode != '') {
                    $xml->element('PostalCode',$this->toCode);
                }
            $xml->pop(); // Close Address
        $xml->pop(); // Close AddressValidationRequest

        // Convert xml object to a string appending the auth xml
        $xmlString = $accessXml->getXml(). $xml->getXml();

        // Submit the cURL call
        $this->core->request('AV', $xmlString);

        // Convert the xmlString to an array
        $xmlParser = new upsxmlParser();
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();
        return $xmlArray; 
    }
    //}}

    //{{_USPS
    public function getUSPSValidate() {
        return array();
    }
    //}}

    //{{_UPS
    function buildUPSValidateStreetLevelXml() {
        $this->core->access();
        $accessXml = $this->core->xmlObject;

        $xml = new xmlBuilder();

        $xml->push('AddressValidationRequest',array('xml:lang' => 'en-US'));
            $xml->push('Request');
                $xml->push('TransactionReference'); // Not required
                    $xml->element('CustomerContext', 'RocketShipIt'); // Not required
                    //$xml->emptyelement('ToolVersion');
                $xml->pop(); // close TransactionReference, not required
                $xml->element('RequestAction', 'XAV');
                $xml->element('RequestOption', '3');
            $xml->pop(); // close Request
            $xml->push('AddressKeyFormat');
                $xml->element('ConsigneeName', $this->toName);
                $xml->element('AttentionName', $this->toName);
                $xml->element('PoliticalDivision1', $this->toState);
                $xml->element('PoliticalDivision2', $this->toCity);
                $xml->element('AddressLine', $this->toAddr1);
                $xml->element('BuildingName', $this->toAddr2);
                $xml->element('PostcodePrimaryLow', $this->toCode);
                $xml->element('PostcodeExtendedLow', $this->toExtendedCode);
                $xml->element('CountryCode', $this->toCountry);
            $xml->pop(); // close AddressKeyFormat
        $xml->pop(); // close AddressValidationRequest

        $xmlString = $accessXml->getXml(). $xml->getXml();
        return $xmlString;
    }
    //}}

    // Function that allows parameters to be set
    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->{$param} = $value;
        $this->core->{$param} = $value;
    }
}
//{{/VALIDATE}}
?>
