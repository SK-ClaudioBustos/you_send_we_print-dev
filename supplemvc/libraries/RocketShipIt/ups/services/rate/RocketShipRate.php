<?php
/**
* Main Rate class for producing rates for various packages/shipments
*
* This class is a wrapper for use with all carriers to produce rates 
* Valid carriers are: UPS, USPS, STAMPS and FedEx.
*/
class RocketShipRate {

    var $OKparams;
    var $packageCount;
    var $inherited;
    
    function __Construct($carrier,$license='',$username='',$password='') {
        rocketshipit_validateCarrier($carrier);
        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        $this->OKparams = rocketshipit_getOKparams($carrier);
        $this->packageCount = 0;
        
        // Set up core class and grab carrier-specific defaults that are unique to the current carrier
        if ($carrier == "UPS") {
            $this->inherited = new RocketShipUPSRate($license, $username, $password);
        }

        if ($carrier == 'USPS') {
            $this->inherited = new RocketShipUSPSRate($license, $username, $password);
        }

        if ($carrier == 'FEDEX') {
            $this->inherited = new RocketShipFEDEXRate($license, $username, $password);
        }

        if ($carrier == 'STAMPS') {
            $this->inherited = new RocketShipSTAMPSRate($license, $username, $password);
        }

        if ($carrier == 'DHL') {
            $this->inherited = new RocketShipDHLRate();
        }

        if ($carrier == 'CANADA') {
            $this->inherited = new RocketShipCANADARate();
        }

        foreach ($this->OKparams as $param) {
            $this->setParameter($param, '');
        }
    }

    /**
    * Retruns a single rate from the carrier.
    */
    function getRate() {
        switch ($this->carrier) {
            case "UPS":
                return $this->inherited->getUPSRate();
            case "USPS":
                return $this->inherited->getUSPSRate();
            case "FEDEX":
                return $this->inherited->getFEDEXRate();
            case "DHL":
                return $this->inherited->getDHLRate();
        }
    }

    /**
    * Retruns all available rates from the carrier.
    */
    function getAllRates() {
        switch ($this->carrier) {
            case "UPS":
                return $this->inherited->getAllUPSRates();
            case 'FEDEX':
                return $this->inherited->getAllFEDEXRates();
            case 'USPS':
                return $this->inherited->getAllUSPSRates();
            case 'STAMPS':
                return $this->inherited->getAllSTAMPSRates();
            case 'DHL':
                return $this->inherited->getAllDHLRates();
            case 'CANADA':
                return $this->inherited->getAllCANADARates();
        }
    }

    /**
    * This is a wrapper to create a running package for each carrier.
    *
    * This is used to add packages to a shipment for any carrier.
    * You use the {@link RocketShipPackage} class to create a package
    * object.
    */
    function addPackageToShipment ($packageObj) {
        $this->packageCount++;
        switch ($this->carrier) {
            case "UPS":
                return $this->inherited->addPackageToUPSShipment($packageObj);
            case "USPS":
                return $this->inherited->addPackageToUSPSShipment($packageObj, $this->inherited->isInternational($this->inherited->toCountry));
            case 'FEDEX':
                return $this->inherited->addPackageToFEDEXShipment($packageObj);
            default:
                return false;
        }
    }

    /**
    * Return a simple rate from carrier.
    */
    function getSimpleRate() {
        switch($this->carrier) {
            case "UPS":
                return $this->inherited->simplifyUPSRate();
            case "FEDEX":
                return $this->inherited->simplifyFEDEXRate();
            case "USPS":
                return $this->inherited->simplifyUSPSRate();
        }
    }

    /**
    * Return all available rates from carrier in a simple array.
    */
    function getSimpleRates() {
        if ($this->carrier == 'UPS') {
            return $this->inherited->simplifyUPSRates();
        }
        if ($this->carrier == 'FEDEX') {
            return $this->inherited->simplifyFEDEXRates();
        }
        if ($this->carrier == 'USPS') {
            $usps = $this->inherited->getAllUSPSRates();
            return $this->inherited->simplifyUSPSRates($this->inherited->core->xmlResponse);
        }
        if ($this->carrier == 'STAMPS') {
            return $this->inherited->simplifySTAMPSRates();
        }
    }

    // In order to allow users to override defaults or specify obsecure UPS
    // data, this function allows you to set any of the variables that this class uses
    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->inherited->{$param} = $value;
        //$this->core->{$param} = $value;
    }
    
    // Checks the country to see if the request is International
    function isInternational($country) {
        if ($country == '' || $country == 'US' || $country == $this->inherited->core->getCountryName('US')) {
            return false;
        }
        return true;
    }

    function getXmlSent() {
        return $this->inherited->core->xmlSent;
    }

    function getXmlResponse() {
        return $this->inherited->core->xmlResponse;
    }

    function debug() {
        return $this->inherited->core->debug();
    }

}
?>
