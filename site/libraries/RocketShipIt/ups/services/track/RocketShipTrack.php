<?php
//{{TRACK
/**
* Main class for tracking shipments and packages
*
* This class is a wrapper for use with all carriers to track packages
* Valid carriers are: UPS, USPS, and FedEx.
*/
class RocketShipTrack {

    var $inheritied;

    function __Construct($carrier, $license='', $username='', $password='') {
        rocketshipit_validateCarrier($carrier);
        $this->OKparams = rocketshipit_getOKparams($carrier);
        $this->carrier = strtoupper($carrier);
        switch ($this->carrier) {
            case "UPS":
                $this->core = new ups($license, $username, $password); // This class depends on ups
                $this->inherited = new RocketShipUPSTrack($license, $username, $password);
                break;
            case "FEDEX":
                $this->core = new fedex();
                $this->inherited = new RocketShipFEDEXTrack($license, $username, $password);
                $this->setParameter('trackingIdType','');
                break;
            case "USPS":
                $this->core = new usps();
                $this->inherited = new RocketShipUSPSTrack($license, $username, $password);
                $this->setParameter('userid','');
                break;
            case "DHL":
                $this->core = new dhl();
                $this->inherited = new RocketShipDHLTrack();
                break;
            case "CANADA":
                $this->core = new canada();
                $this->inherited = new RocketShipCANADATrack();
                break;
            default:
                exit ("Unknown carrier $this->carrier in RocketShipTrack.");
        }
        foreach ($this->OKparams as $param) {
            $this->setParameter($param, '');
        }
    }

    function track($trackingNumber) {
        switch (strtoupper($this->carrier)) {
        case 'UPS':
            $retArr = $this->inherited->trackUPS($trackingNumber);
            $a = $retArr['TrackResponse'];
            if ($a['Response']['ResponseStatusCode']['VALUE'] != "1") {
                $this->result = "FAIL";
                $this->reason = $a['Response']['Error']['ErrorDescription']['VALUE'] .
                                    " (".$a['Response']['Error']['ErrorCode']['VALUE'].")";
            } else {
                if (array_key_exists("TrackingNumber",$a['Shipment']['Package'])) {
                    // single package
                    $p = $a['Shipment']['Package'];
                } else {
                    // multi-package
                    $p = $a['Shipment']['Package'][0];
                }
                $this->result = "OK";
                if (array_key_exists("Status",$p['Activity'])) {
                    // just the one
                    $this->status = $p['Activity']['Status']['StatusType']['Description']['VALUE'];
                } else {
                    // multiple activities - grab the most recent
                    $this->status = $p['Activity'][0]['Status']['StatusType']['Description']['VALUE'];
                }
            }
            return $retArr;
        case 'FEDEX':
            return $this->inherited->trackFEDEX($trackingNumber);
        case 'USPS':
            return $this->inherited->trackUSPS($trackingNumber);
        case 'DHL':
            return $this->inherited->trackDHL($trackingNumber);
        case 'CANADA':
            return $this->inherited->trackCANADA($trackingNumber);
        default:
            exit("Unknown carrier $this->carrier in RocketShipTrack");
        }
    }

    function trackByReference($referenceNumber) {
        switch (strtoupper($this->carrier)) {
        case 'UPS':
            $this->referenceNumber = $referenceNumber;
            $retArr = $this->inherited->trackUPS($referenceNumber);
            return $retArr;
        case 'FEDEX':
            break;
        case 'USPS':
            break;
        default:
            exit("Unknown carrier $this->carrier in RocketShipTrack");
        }
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

    function setParameter($param,$value) {
        $value = rocketshipit_getparameter($param, $value, $this->carrier);
        $this->inherited->{$param} = $value;
        $this->inherited->core->{$param} = $value;
    }

}
//{{/TRACK}}
?>
