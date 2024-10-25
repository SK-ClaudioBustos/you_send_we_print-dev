<?php
//{{PACKAGE
/**
* Main class for producing package objects that are later inserted into a shipment
* @see RocketShipShipment::addPackageToShipment()
*/
class RocketShipPackage {

    var $ups;

    function __Construct($carrier,$license='',$username='',$password='') {
        rocketshipit_validateCarrier($carrier);

        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        $this->OKparams = rocketshipit_getOKparams($carrier);

        // Grab defaults package attributes

        if ($carrier == 'UPS') {
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
        if ($carrier == 'FEDEX') {
            $this->core = new fedex(); // This class depends on fedex
            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }

        }

        if ($carrier == 'USPS') {
            $this->core = new usps(); // This class depends on usps
            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }
        }
    }

    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->{$param} = $value;
    }

}
//{{/PACKAGE}}
?>
