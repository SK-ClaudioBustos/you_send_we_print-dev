<?php
//{{SHIPMENT
/**
* Main Shipping class for producing labels and notifying carriers of pickups.
*
* This class is a wrapper for use with all carriers to produce labels for
* shipments.  Valid carriers are: UPS, USPS, Stamps, and FedEx.
*/
class RocketShipShipment {
    
    var $OKparams;
    var $inherited;

    function __Construct($carrier,$license='',$username='',$password='') {
        rocketshipit_validateCarrier($carrier);
        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        $this->OKparams = rocketshipit_getOKparams($carrier);
        
        // Set up core class and grab carrier-specific defaults that are 
        // unique to the current carrier
        if ($carrier == "UPS") {
            $this->inherited = new RocketShipUPSShipment($license, $username, $password);
        }

        if ($carrier == "USPS") {
            $this->inherited = new RocketShipUSPSShipment();
        }

        if ($carrier == 'FEDEX') {
            $this->core = new fedex(); // This class depends on fedex
            $this->inherited = new RocketShipFEDEXShipment();
        }

        if ($carrier == 'STAMPS') {
            $this->inherited = new RocketShipSTAMPSShipment();
        }

        foreach ($this->OKparams as $param) {
            $this->setParameter($param, '');
        }
    }

    
    /**
    * Sets paramaters to be used in {@link RocketShipShipment() RocketShipShipment}.
    *
    * Only valid parameters are accepted.  
    * @see getOKparams()
    */
    function setParameter($param, $value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->inherited->{$param} = $value;
        //$this->core->{$param} = $value;
    }
    
    /**
    * This is a wrapper to create a running package for each carrier.
    *
    * This is used to add packages to a shipment for any carrier.
    * You use the {@link RocketShipPackage} class to create a package
    * object.
    */
    function addPackageToShipment($packageObj) {
        switch ($this->carrier) {
            case "UPS":
                return $this->inherited->addPackageToUPSshipment($packageObj);
            case "USPS":
                return $this->addPackageToUSPSshipment($packageObj);
            case 'FEDEX':
                return $this->addPackageToFEDEXshipment($packageObj);
            case 'STAMPS':
                return $this->inherited->addPackageToSTAMPSshipment($packageObj);
            default:
                return false;
        }
    }

    /**
    * This is a wrapper to create a running customs document for each carrier.
    */
    function addCustomsLineToShipment($packageObj) {
        switch ($this->carrier) {
            case 'STAMPS':
                return $this->inherited->addCustomsLineToSTAMPSshipment($packageObj);
            case 'FEDEX':
                return $this->inherited->addCustomsLineToFEDEXshipment($packageObj);
            case 'UPS':
                return $this->inherited->addCustomsLineToUPSshipment($packageObj);
            default:
                return false;
        }
    }
    
    /**
    * Sends the shipment data to the carrier.
    * 
    * After the shipment data is sent it returns a simplified array of
    * the data sent back from the carrier.
    */
    function submitShipment() {
        switch ($this->carrier) {
            case "UPS":
                $shipResponse = $this->inherited->sendUPSshipment();
                $simpleArray = $this->inherited->simplifyUPSResponse($shipResponse);
                return $simpleArray;
            case 'USPS':
                $shipResponse = $this->inherited->sendUSPSshipment();
                $simpleArray = $this->inherited->simplifyUSPSResponse($shipResponse);
				return $simpleArray;
            case 'FEDEX':
                $shipResponse = $this->inherited->sendFEDEXshipment();
                $simpleArray = $this->inherited->simplifyFEDEXResponse($shipResponse);
                return $simpleArray;
            case 'STAMPS':
                return $this->inherited->sendSTAMPSshipment();
            default:
                return false;
        }
    }
    
    function sendShipment () {
        switch ($this->carrier) {
            case "UPS":
                return $this->sendUPSshipment();
            default:
                return false;
        }
    }
        
    // To the end user this will just show the array (or label)
    // In actuality it is doing the final request to UPS approval process.
    // In this function we are approving the shipment in the sendShipment() function.  
    // In other words it is a two step process.
    // TODO: rename this method and create a new one that only displays the label.
    function getLabels() {
        switch ($this->carrier) {
            case "UPS":
                return $this->getUPSlabels();
            default:
                return false;
        }
    }

    function getXmlPrevSent() {
        return $this->inherited->core->xmlPrevSent;
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
    
    /**
     * Creates random string of alphanumeric characters
     * 
     * @return string
     */
    private function generateRandomString() {
        $length = 128;
        $characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = "";
        
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, strlen($characters));
            $string .= substr($characters, $index, 1);
        }
        return $string;
    }
}
//{{/SHIPMENT}}
?>
