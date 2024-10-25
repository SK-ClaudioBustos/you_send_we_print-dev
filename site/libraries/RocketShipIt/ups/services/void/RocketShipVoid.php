<?php
/**
* Main class for voiding shipments.
*
* This class is a wrapper for use with all carriers to cancel 
* shipments.  Valid carriers are: UPS, USPS, and FedEx.
* To create a shipment see {@link RocketShipShipment}.
*/
class RocketShipVoid {
    
    var $OKparams;
    var $inherited;

    function __Construct($carrier,$license='',$username='',$password='') {
        rocketshipit_validateCarrier($carrier);
        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        $this->OKparams = rocketshipit_getOKparams($carrier);
        if ($carrier == "UPS") {
            $this->core = new ups($license, $username, $password); // This class depends on ups
            $this->inherited = new RocketShipUPSVoid($license, $username, $password);

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
            $this->inherited = new RocketShipFEDEXVoid($license, $username, $password);
        }
        if ($carrier == 'STAMPS') {
            $this->core = new stamps();
            $this->inherited = new RocketShipSTAMPSVoid($license, $username, $password);
        }
    }

    /**
    * Void (cancel) a shipment at the shipment level.  I.e. all packages.
    *
    * This will void all packages linked to the ShipmentIdentification 
    * number.  Often times this is the first tracking number in a set
    * of packages.
    */
    function voidShipment($shipmentIdentification) {
        switch ($this->carrier) {
            case "UPS":
                $this->inherited->shipmentIdentification = $shipmentIdentification;
                return $this->inherited->voidUpsShipment();    
                $xmlArray = $this->inherited->voidUpsPackage();
                $a = $xmlArray['VoidShipmentResponse'];
                $outArr = "";
                if ($a['Response']['ResponseStatusCode']['VALUE'] == "1") {
                    $outArr['result'] =  "voided";
                    $outArr['trackingNumber'] = $a['PackageLevelResults']['TrackingNumber']['VALUE'];
                } else {
                    $outArr['result'] = "fail";
                    $outArr['reason'] = $a['Response']['Error']['ErrorDescription']['VALUE'] .
                                        " (".$a['Response']['Error']['ErrorCode']['VALUE'].")";
                }
                $outArr['xmlArray'] = $xmlArray;
                return $outArr;
            case "FEDEX":
                $this->inherited->shipmentIdentification = $shipmentIdentification;
                return $this->inherited->voidFedexShipment();
            case "STAMPS":
                $this->inherited->shipmentIdentification = $shipmentIdentification;
                return $this->inherited->voidStampsShipment();
            default:
                return false;
        }
    }

    /**
    * Void (cancel) a shipment at the package level.  I.e. one package.
    *
    * This will void a single package identified by a specific
    * tracking number.
    */
    function voidPackage($shipmentIdentification, $packageIdentification) {
        switch ($this->carrier) {
            case "UPS":
                $this->shipmentIdentification = $shipmentIdentification;
                $this->packageIdentification = $packageIdentification;
                $xmlArray = $this->inherited->voidUpsPackage();
                $a = $xmlArray['VoidShipmentResponse'];
                $outArr = "";
                if ($a['Response']['ResponseStatusCode']['VALUE'] == "1") {
                    $outArr['result'] =  "voided";
                    $outArr['shipmentNumber'] = $shipmentIdentification;
                } else {
                    $outArr['result'] = "fail";
                    $outArr['reason'] = $a['Response']['Error']['ErrorDescription']['VALUE'] .
                                        " (".$a['Response']['Error']['ErrorCode']['VALUE'].")";
                }
                $outArr['xmlArray'] = $xmlArray;
                return $outArr;
            default:
                return false;
        }
    }

    function debug() {
        return $this->inherited->core->debug();
    }

    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->inherited->{$param} = $value;
        $this->inherited->core->{$param} = $value;
    }

}
?>
