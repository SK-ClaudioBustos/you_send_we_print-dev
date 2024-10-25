<?php
//{{VALIDATE
/**
* Main Address Validation class for carrier.
*
* Valid carriers are: UPS, USPS, STAMPS, and FedEx.
*/
class RocketShipAddressValidate {

    // Set variable for valid parameters
    var $OKparams;
    var $carrier; // Set variable for carrier
    var $inherited;

    function __Construct($carrier,$license='',$username='',$password='') {
        // Validate carrier name
        rocketshipit_validateCarrier($carrier);

        $this->carrier = strtoupper($carrier);
        $this->OKparams = rocketshipit_getOKparams($carrier);

        // Set up core class and grab carrier-specific defaults that are unique to the current carrier
        if ($this->carrier == "UPS") {
            $this->core = new ups($license, $username, $password); // This class depends on ups
            $this->inherited = new RocketShipUPSAddressValidate($license, $username, $password);

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
            $this->inherited = new RocketShipFEDEXAddressValidate($license, $username, $password);
        }
        if ($this->carrier == 'STAMPS') {
            $this->core = new stamps(); // This class depends on stamps
            $this->inherited = new RocketShipSTAMPSAddressValidate($license, $username, $password);
        }
        foreach ($this->OKparams as $param) {
            $this->setParameter($param, '');
        }
    }

    /**
    * Send address data to carrier.
    * 
    * This function detects carrier and executes the 
    * carrier specific function.
    */
    function validate() {
        switch ($this->carrier) {
            case "UPS":
                return $this->inherited->getUPSValidate();
            case "FEDEX":
                return $this->inherited->getFEDEXValidate();
            case "STAMPS":
                return $this->inherited->getSTAMPSValidate();
            case "USPS":
                return $this->getUSPSValidate();
        }
    }

    //{{_USPS
    public function getUSPSValidate() {
        return array();
    }
    //}}

    function validateStreetLevel() {
        switch ($this->carrier) {
            case "UPS":
                $this->inherited->core->xmlSent = $this->inherited->buildUPSValidateStreetLevelXml();
                $this->inherited->core->xmlResponse = $this->inherited->core->request('XAV', $this->inherited->core->xmlSent);

                // Convert the xmlString to an array
                $xmlParser = new upsxmlParser();
                $xmlArray = $xmlParser->xmlparser($this->inherited->core->xmlResponse);
                $xmlArray = $xmlParser->getData();

                return $xmlArray;
        }
    }

    function debug() {
        return $this->inherited->core->debug();
    }

    // Function that allows parameters to be set
    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->inherited->{$param} = $value;
        $this->inherited->core->{$param} = $value;
    }
}
//{{/VALIDATE}}
?>
