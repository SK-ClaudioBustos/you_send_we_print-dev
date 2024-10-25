<?php
/**
* Main class for getting time in transit information
*
*/
class RocketShipUPSTimeInTransit {
    function __Construct($license='',$username='',$password='') {
        $carrier = 'UPS';
        rocketshipit_validateCarrier($carrier);

        $this->OKparams = rocketshipit_getOKparams($carrier);
        $this->carrier = strtoupper($carrier);
        switch (strtoupper($carrier)) {
            case "UPS":
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

            break;
            default:
                exit("Unknown carrier $carrier in RocketShipTimeInTransit.");
        }

    }

    //{{_UPS
    function getUPSTimeInTransit() {
        $this->core->access();
        $accessXml = $this->core->xmlObject;

        $xml = new xmlBuilder();
        $xml->push('TimeInTransitRequest',array('xml:lang' => 'en-US'));
            $xml->push('Request');
                $xml->push('TransactionReference'); // Not required
                    $xml->element('CustomerContext', 'RocketShipIt'); // Not required
                $xml->pop(); // close TransactionReference, not required
                $xml->element('RequestAction', 'TimeInTransit');
            $xml->pop(); // end Request;
            $xml->push('TransitFrom');
                $xml->push('AddressArtifactFormat');
                    $xml->element('PoliticalDivision2',$this->shipCity);
                    $xml->element('CountryCode',$this->shipCountry);
                    $xml->element('PostcodePrimaryLow',$this->shipCode);
                $xml->pop(); // end AddressArtifactFormat
            $xml->pop(); // end TransitFrom
            $xml->push('TransitTo');
                $xml->push('AddressArtifactFormat');
                    $xml->element('PoliticalDivision2',$this->toCity);
                    $xml->element('CountryCode',$this->toCountry);
                    $xml->element('PostcodePrimaryLow',$this->toCode);
                $xml->pop(); // end AddressArtifactFormat
            $xml->pop(); // end TransitTo
            if ($this->weight != '') {
                $xml->push('ShipmentWeight');
                    $xml->push('UnitOfMeasurement');
                        $xml->element('Code',$this->weightUnit);
                        $xml->element('Description','Pounds');
                    $xml->pop(); //end UnitOfMeasurement
                    $xml->element('Weight',$this->weight);
                $xml->pop(); //end ShipmentWeight
            }
            $xml->element('TotalPackagesInShipment','1');
            // $xml->push('InvoiceLineTotal');
            //     $xml->element('CurrencyCode',$this->insuredCurrency);
            //     $xml->element('MonetaryValue',$this->monetaryValue);
            // $xml->pop(); // end InvoiceLineTotal
            $xml->element('PickupDate',$this->pickupDate);
            //$xml->element('DocumentsOnlyIndicator','');
            if ($this->monetaryValue != '') {
                $xml->push('InvoiceLineTotal');
                    $xml->element('CurrencyCode', $this->insuredCurrency);
                    $xml->element('MonetaryValue', $this->monetaryValue);
                $xml->pop();
            }
        $xml->pop(); // end TimeInTransitRequest

        // Convert xml object to a string
        $accessXmlString = $accessXml->getXml();
        $requestXmlString = $xml->getXml();

        $xmlString = $accessXmlString. $requestXmlString;

        $this->core->request('TimeInTransit', $xmlString);

        // Convert the xmlString to an array
        $xmlParser = new upsxmlParser();
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();
        return $xmlArray; 
    }
    //}}

    /**
    * Sets paramaters to be used in {@link RocketShipTimeinTransit()}.
    *
    * Only valid parameters are accepted.  
    * @see getOKparams()
    */
    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->{$param} = $value;
        $this->core->{$param} = $value;
    }

}
?>
