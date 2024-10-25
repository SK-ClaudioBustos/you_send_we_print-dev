<?php
//{{RATE
/**
* Main Rate class for producing rates for various packages/shipments
*
* This class is a wrapper for use with all carriers to produce rates 
* Valid carriers are: UPS, USPS, and FedEx.
*/
class RocketShipUPSRate {

    var $OKparams;

    var $packageCount;
    
    function __Construct($license='',$username='',$password='') {
        $carrier = 'UPS';
        rocketshipit_validateCarrier($carrier);
        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        $this->OKparams = rocketshipit_getOKparams($carrier);
        $this->packageCount = 0;
        
        // Set up core class and grab carrier-specific defaults that are unique to the current carrier
        if ($carrier == "UPS") {
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
        if ($carrier == 'USPS') {
            $this->core = new usps(); // This class depends on usps

            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }

        }

        if ($carrier == 'FEDEX') {
            $this->core = new fedex(); // This class depends on fedex

            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }
        }
        if ($carrier == 'STAMPS') {
            $this->core = new stamps(); // This class depends on stamps

            foreach ($this->OKparams as $param) {
                $this->setParameter($param, '');
            }
        }
    }

    //{{_UPS
    function getUPSRate($requestOption='Rate') {

        $xmlString = $this->buildUPSRateXml($requestOption);

        $this->core->request('Rate', $xmlString);

        // Convert the xmlString to an array
        $xmlParser = new upsxmlParser();
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();
        return $xmlArray; 
    }
    //}}

    //{{_UPS
    function addPackageToUPSShipment($package) {

        if (!isset($this->core->packagesObject)) {
            $this->core->packagesObject = new xmlBuilder(true);
        }

        $xml = $this->core->packagesObject;

        $xml->push('Package');
            $xml->push('PackagingType');
                $xml->element('Code', $package->packagingType);
                //$xml->element('Description', $this->packageTypeDescription);
            $xml->pop(); // close PacakgeType
                if ($package->length != '') {
                    $xml->push('Dimensions');
                        $xml->push('UnitOfMeasurement');
                            $xml->element('Code', $package->lengthUnit);
                        $xml->pop(); // close UnitOfMeasurement
                            $xml->element('Length', $package->length);
                            $xml->element('Width', $package->width);
                            $xml->element('Height', $package->height);
                    $xml->pop(); // close Dimensions
                }
            //$xml->element('Description', $this->packageDescription);
            $xml->push('PackageWeight');
                $xml->push('UnitOfMeasurement');
                    $xml->element('Code', $package->weightUnit);
                $xml->pop(); // close UnitOfMeasurement
                $xml->element('Weight', $package->weight);
            $xml->pop(); // close PackageWeight
            if ($package->monetaryValue != '' || $package->insuredCurrency != '' || $package->signatureType != '') {// Change for COD
                $xml->push('PackageServiceOptions');
                    if ($package->monetaryValue != '') {
                        $xml->push('InsuredValue');
                            $xml->element('CurrencyCode',$package->insuredCurrency);
                            $xml->element('MonetaryValue',$package->monetaryValue);
                        $xml->pop(); // close InsuredValue
                    }
                    if ($package->signatureType != '') {
                        $xml->push('DeliveryConfirmation');
                            $xml->element('DCISType', $package->signatureType);
                        $xml->pop(); // end DeliveryConfirmation
                    }
                $xml->pop(); // close PackageServiceOptions
            }
        $xml->pop(); // close Package

        $this->core->packagesObject = $xml;

        return true;
    }
    //}}

    //{{_UPS
    function buildUPSRateXml($requestOption='Rate') {
        $this->core->access();
        $xml = $this->core->xmlObject;
        
        $xml->push('RatingServiceSelectionRequest');
            $xml->push('Request');
                $xml->element('RequestAction', 'Rate');
                $xml->element('RequestOption', $requestOption);
                $xml->push('TransactionReference'); // Not required
                    $xml->element('CustomerContext', 'RocketShipIt'); // Not required
                    //$xml->element('XpciVersion', '1.0'); // Not required
                $xml->pop(); // close TransactionReference, not required
            $xml->pop(); // close Request
            $xml->push('PickupType');
                $xml->element('Code', $this->PickupType); // TODO: insert link to code values
                if ($this->pickupDescription != '') {
                    //$xml->element('Description', $this->pickupDescription);
                }
            $xml->pop(); // close PickupType
            if ($this->customerClassification != '') {
                $xml->push('CustomerClassification');
                    $xml->element('Code', $this->customerClassification);
                $xml->pop(); //end CustomerClassification
            }
            $xml->push('Shipment');
                //$xml->element('Description', $this->shipmentDescription);
                $xml->push('Shipper');
                    $xml->element('ShipperNumber', $this->accountNumber);
                    $xml->push('Address');
                        $xml->element('AddressLine1', $this->shipAddr1);
                        if ($this->shipAddr2 != '') {
                            $xml->element('AddressLine2', $this->shipAddr2);
                        }
                        if ($this->shipAddr3 != '') {
                            $xml->element('AddressLine3', $this->shipAddr3);
                        }
                        if ($this->shipCity != '') {
                            $xml->element('City', $this->shipCity);
                        }
                        $xml->element('StateProvinceCode', $this->shipState);
                        $xml->element('PostalCode', $this->shipCode);
                        if ($this->shipCountry != '') {
                            $xml->element('CountryCode', $this->shipCountry);
                        } else {
                            $xml->element('CountryCode', 'US');
                        }
                    $xml->pop(); // close Address
                $xml->pop(); // close Shipper
                $xml->push('ShipTo');
                    if ($this->toCompany != '') {
                        $xml->element('CompanyName', $this->toCompany);
                    }
                    $xml->push('Address');
                        if ($this->toAddr1 != '') {
                            $xml->element('AddressLine1', $this->toAddr1);
                        }
                        if ($this->toAddr2 != '') {
                            $xml->element('AddressLine2', $this->toAddr2);
                        }
                        if ($this->toAddr3 != '') {
                            $xml->element('AddressLine3', $this->toAddr3);
                        }
                        if ($this->toCity != '') {
                            $xml->element('City', $this->toCity);
                        }
                        if ($this->toState != '') {
                            $xml->element('StateProvinceCode', $this->toState);
                        }
                        $xml->element('PostalCode', $this->toCode);
                        if ($this->toCountry != '') {
                            $xml->element('CountryCode', $this->toCountry);
                        } else {
                            $xml->element('CountryCode', 'US');
                        }
                        if ($this->residentialAddressIndicator == '1') {
                            $xml->element('ResidentialAddressIndicator', '1');
                        }
                    $xml->pop(); // close Address
                $xml->pop(); // close ShipTo
            if ($this->fromName != '') {
                $xml->push('ShipFrom');
                    $xml->element('CompanyName', $this->fromName);
                    //$xml->element('AttentionName', $this->fromAttentionName);
                    //$xml->element('PhoneNumber', $this->fromPhoneNumber);
                    //$xml->element('FaxNumber', $this->fromFaxNumber);
                    $xml->push('Address');
                        $xml->element('AddressLine1', $this->fromAddr1);
                        $xml->element('AddressLine2', $this->fromAddr2);
                        $xml->element('AddressLine3', $this->fromAddr3);
                        $xml->element('City', $this->fromCity);
                        $xml->element('PostalCode', $this->fromCode);
                        if ($this->fromCountry != '') {
                            $xml->element('CountryCode', $this->fromCountry);
                        } else {
                            $xml->element('CountryCode', 'US');
                        }
                    $xml->pop(); // close Address
                $xml->pop(); // close ShipFrom
            }
            if ($this->service != '') {
                $xml->push('Service');
                    $xml->element('Code', $this->service);
                $xml->pop(); // close Service
            }
            if (!isset($this->core->packagesObject)) {
                $xml->push('Package');
                    $xml->push('PackagingType');
                        $xml->element('Code', $this->packagingType);
                        //$xml->element('Description', $this->packageTypeDescription);
                    $xml->pop(); // close PacakgeType
                        if ($this->length != '' && $this->width != '' && $this->height != '') {
                            $xml->push('Dimensions');
                                $xml->push('UnitOfMeasurement');
                                    $xml->element('Code', $this->lengthUnit);
                                $xml->pop(); // close UnitOfMeasurement
                                    $xml->element('Length', $this->length);
                                    $xml->element('Width', $this->width);
                                    $xml->element('Height', $this->height);
                            $xml->pop(); // close Dimensions
                        }
                    //$xml->element('Description', $this->packageDescription);
                    if (isset($this->weightUnit)) {
                        $xml->push('PackageWeight');
                            $xml->push('UnitOfMeasurement');
                                $xml->element('Code', $this->weightUnit);
                            $xml->pop(); // close UnitOfMeasurement
                            if ($this->weight != '') {
                                $xml->element('Weight', $this->weight);
                            } else {
                                $xml->element('Weight', '0');
                            }
                        $xml->pop(); // close PackageWeight
                    }
                    if ($this->monetaryValue != '' || $this->insuredCurrency != '' || $this->signatureType != '') {// Change for COD
                        $xml->push('PackageServiceOptions');
                            if ($this->monetaryValue != '') {
                                $xml->push('InsuredValue');
                                    $xml->element('CurrencyCode', $this->insuredCurrency);
                                    $xml->element('MonetaryValue', $this->monetaryValue);
                                $xml->pop(); // close InsuredValue
                            }
                            if ($this->signatureType != '') {
                                $xml->push('DeliveryConfirmation');
                                    $xml->element('DCISType', $this->signatureType);
                                $xml->pop(); // end DeliveryConfirmation
                            }
                        $xml->pop(); // close PackageServiceOptions
                    }
                $xml->pop(); // close Package
            } else {
                $xmlString = $xml->getXml();
                $xmlString .= $this->core->packagesObject->getXml();
                $negotiatedXml = new xmlBuilder(true);
                if ($this->negotiatedRates == '1') {
                    $negotiatedXml->push('RateInformation');
                        $negotiatedXml->element('NegotiatedRatesIndicator','1');
                    $negotiatedXml->pop(); // close RateInformation
                }
                $xmlString .= $negotiatedXml->getXml();
                $xmlString .= '</Shipment>'."\n";
                $xmlString .= '</RatingServiceSelectionRequest>'."\n";
                return $xmlString;
            }
            if ($this->negotiatedRates == '1') {
                $xml->push('RateInformation');
                    $xml->element('NegotiatedRatesIndicator','1');
                $xml->pop(); // close RateInformation
            }
            //$xml->push('ShipmentServiceOptions');
            //$xml->pop(); // close ShipmentServiceOptions
            $xml->pop(); // close Shipment
        $xml->pop();

        // Convert xml object to a string
        $xmlString = $xml->getXml();
        return $xmlString;
    }
    //}}

    function simplifyUPSRate() {
        $upsArray = $this->getUPSRate();
        $status = $upsArray['RatingServiceSelectionResponse']['Response']['ResponseStatusCode']['VALUE'];
        if ($status == '1') {
            $rate = $upsArray['RatingServiceSelectionResponse']['RatedShipment']['TotalCharges']['MonetaryValue']['VALUE'];
            return $rate;
        } else {
            $errorMessage = $upsArray['RatingServiceSelectionResponse']['Response']['Error']['ErrorDescription']['VALUE'];
            return $errorMessage;
        }
    }

    function simplifyUPSRates() {
        $upsArray = $this->getAllUPSRates();
        $status = $upsArray['RatingServiceSelectionResponse']['Response']['ResponseStatusCode']['VALUE'];

        if ($status == '1') {
            $rate = $upsArray['RatingServiceSelectionResponse']['RatedShipment'][0]['TotalCharges']['MonetaryValue']['VALUE'];
            $service = $upsArray['RatingServiceSelectionResponse']['RatedShipment'];

            $rates = Array();
            if (array_key_exists('Service', $service)) {
                $r = $service['Service']['Code']['VALUE'];
                $desc = $this->core->getServiceDescriptionFromCode($r);
                $rates["$desc"] = $service['TotalCharges']['MonetaryValue']['VALUE'];
            } else {
                foreach ($service as $s) {
                    $r = $s['Service']['Code']['VALUE'];
                    $desc = $this->core->getServiceDescriptionFromCode($r);
                    $rates["$desc"] = $s['TotalCharges']['MonetaryValue']['VALUE'];
                    if(isset($s['NegotiatedRates'])) {
                        $rates["$desc"] = array(
                            'Rate' => $s['TotalCharges']['MonetaryValue']['VALUE'],
                            'Negotiated' => $s['NegotiatedRates']['NetSummaryCharges']['GrandTotal']['MonetaryValue']['VALUE']
                        );
                    }
                }
            }

            return $rates;
        } else {
            $errorMessage = $upsArray['RatingServiceSelectionResponse']['Response']['Error']['ErrorDescription']['VALUE'];
            $errorArray['error'] = $errorMessage; 
            if (isset($upsArray['RatingServiceSelectionResponse']['Response']['Error']['ErrorLocation']['ErrorLocationElementName']['VALUE'])) {
                $errorArray['error_location'] = $upsArray['RatingServiceSelectionResponse']['Response']['Error']['ErrorLocation']['ErrorLocationElementName']['VALUE'];
            }
; 
            return $errorArray;
        }
    }

    function getAllUPSRates() {
        return $this->getUPSRate('Shop');
    }

    // In order to allow users to override defaults or specify obsecure UPS
    // data, this function allows you to set any of the variables that this class uses
    function setParameter($param,$value) {
        $value = rocketshipit_getParameter($param, $value, $this->carrier);
        $this->{$param} = $value;
        $this->core->{$param} = $value;
    }
    
    // Checks the country to see if the request is International
    function isInternational($country) {
        if ($country == '' || $country == 'US' || $country == $this->core->getCountryName('US')) {
            return false;
        }
        return true;
    }

    function strip_html($text) {
        $no_html = strip_tags(html_entity_decode($text));
        // Strip html special chars
        return preg_replace("/&#?[a-z0-9]{2,8};/i","",$no_html);
    }

}
//{{/RATE}}
?>
