<?php
/**
* Main class for tracking shipments and packages
*
* This class is a wrapper for use with all carriers to track packages
* Valid carriers are: UPS, USPS, STAMPS and FedEx.
*/
class RocketShipUPSTrack {

    function __Construct($license='',$username='',$password='') {
        $carrier = 'UPS';
        rocketshipit_validateCarrier($carrier);
        $this->OKparams = rocketshipit_getOKparams($carrier);
        $this->carrier = strtoupper($carrier);
        switch ($this->carrier) {
            case "UPS":
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

                break;
            default:
                exit ("Unknown carrier $this->carrier in RocketShipTrack.");
        }
    }

    //{{_UPS
    // Builds xml for tracking and sends the xml string to the ups->request method
    // recieves a response from UPS and outputs an array.
    function trackUPS($trackingNumber){
        $this->core->access();
        $xml = $this->core->xmlObject;
        
        $xml->push('TrackRequest',array('xml:lang' => 'en-US'));
            $xml->push('Request');
                $xml->push('TransactionReference');
                    $xml->element('CustomerContext', 'RocketShipIt');
                $xml->pop(); // close TransactionReference
                $xml->element('RequestAction', 'Track');
                $xml->element('RequestOption', 'activity');
            $xml->pop(); // close Request
            if (!isset($this->referenceNumber)) {
                $xml->element('TrackingNumber', $trackingNumber);
            } else {
                $xml->element('ShipperNumber', getUPSDefault('accountNumber'));
                $xml->push('ReferenceNumber');
                    $xml->element('Value', $this->referenceNumber);
                $xml->pop(); // close ReferenceNumber
            }
        $xml->pop();

        // Convert xml object to a string
        $xmlString = $xml->getXml();

        // Send the xmlString to UPS and store the resonse in a class variable, xmlResponse.
        $this->core->request('Track', $xmlString);

        // Return response xml as an array
        $xmlParser = new upsxmlParser();
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();

        return $xmlArray; 
    }
    //}}

    function setParameter($param,$value) {
        $value = rocketshipit_getparameter($param, $value, $this->carrier);
        $this->{$param} = $value;
        $this->core->{$param} = $value;
    }

}
?>
