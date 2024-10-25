<?php
//{{CUSTOMS
/**
* Main class for creating detailed lines for customs documents
*
* This class is a wrapper for use with all carriers to produce customs 
* documents.  Valid carriers are: UPS, USPS, and FedEx.
*/
class RocketShipCustoms {
    var $OKparams;
    function __Construct($carrier,$license='',$username='',$password='') {
        rocketshipit_validateCarrier($carrier);
        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        $this->OKparams = rocketshipit_getOKparams($carrier);

        if ($carrier == 'STAMPS') {
            $this->core = new stamps(); // This class depends on stamps

            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }
        }

        if ($carrier == 'FEDEX') {
            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }
        }

        if ($carrier == 'UPS') {
            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }
        }
    }

    /**
    * Sets paramaters to be used in {@link RocketShipShipment() RocketShipShipment}.
    *
    * Only valid parameters are accepted.  
    * @see getOKparams()
    */
    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->{$param} = $value;
    }
}
