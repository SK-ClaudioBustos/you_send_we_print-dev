<?php
/**
* Main class for voiding shipments.
*
* This class is a wrapper for use with all carriers to cancel 
* shipments.  Valid carriers are: UPS, USPS, and FedEx.
* To create a shipment see {@link RocketShipShipment}.
*/
class RocketShipUPSVoid {
    
    var $OKparams;

    function __Construct($license='',$username='',$password='') {
        $carrier = 'UPS';
        rocketshipit_validateCarrier($carrier);
        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        $this->OKparams = rocketshipit_getOKparams($carrier);
        if ($carrier == "UPS") {
            $this->core = new ups($license, $username, $password); // This class depends on ups

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
        if ($carrier == 'FEDEX') {
            $this->core = new fedex(); // This class depends on fedex 
        }
        if ($carrier == 'STAMPS') {
            $this->core = new stamps();
        }
    }

    function voidUpsPackage() {
        $this->core->access();
        $accessXml = $this->core->xmlObject;    

        $xml = new xmlBuilder(false);
        
        $xml->push('VoidShipmentRequest');
            $xml->push('Request');
                $xml->element('RequestAction', '1');
            $xml->pop(); // end Request
        $xml->push('ExpandedVoidShipment');
            $xml->element('ShipmentIdentificationNumber', $this->shipmentIdentification);
            if (is_array($this->packageIdentification)) {
                foreach ($this->packageIdentification as $trackingNumber) {
                    $xml->element('TrackingNumber', $trackingNumber);
                }
            } else {
                    $xml->element('TrackingNumber', $this->packageIdentification);
            }
        $xml->pop(); // end ExpandedVoidShipment
        $xml->pop(); // end VoidShipmentRequest

        $xmlString = $accessXml->getXml(). $xml->getXml();
        
        $this->core->request('Void',$xmlString);

        $xmlParser = new upsxmlParser();
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();


        return $xmlArray;

    }

    function voidUpsShipment() {
        $this->core->access();
        $accessXml = $this->core->xmlObject;    

        $xml = new xmlBuilder(false);

        $xml->push('VoidShipmentRequest');
            $xml->push('Request');
                $xml->element('RequestAction', '1');
            $xml->pop(); // end Request
            $xml->element('ShipmentIdentificationNumber', $this->shipmentIdentification);
        $xml->pop(); // end VoidShipmentRequest

        $xmlString = $accessXml->getXml(). $xml->getXml();

        $this->core->request('Void',$xmlString);

        $xmlParser = new upsxmlParser();
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();


        return $xmlArray;
    }

    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->{$param} = $value;
        $this->core->{$param} = $value;
    }

}
?>
