<?php
/**
* Main class for getting time in transit information
*
*/
class RocketShipTimeInTransit {

    var $inherited;

    function __Construct($carrier,$license='',$username='',$password='') {
        rocketshipit_validateCarrier($carrier);

        $this->OKparams = rocketshipit_getOKparams($carrier);
        $this->carrier = strtoupper($carrier);
        switch (strtoupper($carrier)) {
            case "UPS":
                $this->core = new ups($license, $username, $password); // This class depends on ups
                $this->inherited = new RocketShipUPSTimeInTransit($license, $username, $password);
            break;
            case "FEDEX":
                $this->core = new fedex();
                $this->inherited = new RocketShipFEDEXTimeInTransit($license, $username, $password);
            break;
            case "USPS":
                $this->core = new usps();
            break;
            default:
                exit("Unknown carrier $carrier in RocketShipTimeInTransit.");

        }

        foreach ($this->OKparams as $param) {
            $this->setParameter($param, '');
        }

    }

    /**
    * Returns a Time in Transit resposne from the carrier.
    */
    function getTimeInTransit() {
        switch ($this->carrier) {
            case "UPS":
                return $this->inherited->getUPSTimeInTransit();
            case "USPS":
                return $this->inherited->getUSPSTimeInTransit();
            case "FEDEX":
                return $this->inherited->getFEDEXTimeInTransit();
        }
    }

    //{{_USPS
    function getUSPSTimeInTransit() {
        $xml = $this->core->xmlObject;
        
        $xml->push('ExpressMailCommitmentRequest',array('USERID' => $this->userid));
            $xml->element('OriginZIP', $this->shipCode);
            $xml->element('DestinationZIP', $this->toCode);
            $xml->element('Date', $this->pickupDate);
        $xml->pop();
        
        $xmlString = 'API=ExpressMailCommitment&XML='. $xml->getXml();
        
        $this->core->request('ShippingAPI.dll', $xmlString);
        
        // Convert the xmlString to an array
        $xmlParser = new upsxmlParser();
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();
        return $xmlArray; 
    }
    //}}

    function debug() {
        return $this->inherited->core->debug();
    }
    
    /**
    * Sets paramaters to be used in {@link RocketShipTimeinTransit()}.
    *
    * Only valid parameters are accepted.  
    * @see getOKparams()
    */
    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->inherited->{$param} = $value;
        $this->inherited->core->{$param} = $value;
    }

}
?>
