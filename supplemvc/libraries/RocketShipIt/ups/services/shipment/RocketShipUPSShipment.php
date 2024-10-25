<?php
//{{SHIPMENT
/**
* Main Shipping class for producing labels and notifying carriers of pickups.
*
* This class is a wrapper for use with all carriers to produce labels for
* shipments.  Valid carriers are: UPS, USPS, and FedEx.
*/
class RocketShipUPSShipment {
    
    var $OKparams;
    var $customsLines;

    function __Construct($license='', $username='', $password='') {
        $carrier = 'UPS';
        rocketshipit_validateCarrier($carrier);
        $carrier = strtoupper($carrier);
        $this->carrier = $carrier;
        $this->OKparams = rocketshipit_getOKparams($carrier);
        $this->customsLines = Array();
        
        // Set up core class and grab carrier-specific defaults that are 
        // unique to the current carrier
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

    }

    //{{_UPS
    function addPackageToUPSshipment($packageObj) {

        $package = $packageObj;
        
        if (!isset($this->core->packagesObject)) {
            $this->core->packagesObject = new xmlBuilder(true);
        }

        $xml = $this->core->packagesObject;

        if (!isset($this->core->customsObject)) {
            $this->core->customsObject = new xmlBuilder(true);
        } else {
	    //Paperless Invoice
	    $xml->append($this->core->customsObject->getXML());
	    ///////////////
	}

        $xml->push('Package');
            if ($this->packageDescription != '') {
                $xml->element('Description', $this->packageDescription);
            }
            if ($package->packagingType != '') {
                $xml->push('PackagingType');
                    $xml->element('Code', $package->packagingType);
                $xml->pop(); // end PackagingType
            }
            if ($package->length != '') {
                if ($package->packagingType != '01') {
                    $xml->push('Dimensions');
                        $xml->push('UnitOfMeasurement');
                            if ($this->lengthUnit != '') {
                                $xml->element('Code', $package->lengthUnit);
                            }
                        $xml->pop(); // end UnitOfMeasurement
                        if ($package->length != '') {
                            $xml->element('Length', $package->length);
                        }
                        if ($package->width != '') {
                            $xml->element('Width', $package->width);
                        }
                        if ($package->height != '') {
                            $xml->element('Height', $package->height);
                        }
                    $xml->pop(); // end Dimensions
                }
            }
            if ($package->weight != '') {
                $xml->push('PackageWeight');
                    $xml->push('UnitOfMeasurement');
                        $xml->element('Code', $package->weightUnit);
                    $xml->pop(); // close UnitOfMeasurement
                    $xml->element('Weight', $package->weight);
                $xml->pop(); // end PackageWeight
            }

            if ($package->referenceValue && $package->referenceCode != '') {
                $xml->push('ReferenceNumber');
                    $xml->element('Code', $package->referenceCode);
                    $xml->element('Value', $package->referenceValue);
                $xml->pop(); // end ReferenceNumber
            }

            if ($package->referenceValue2 && $package->referenceCode2 != '') {
                $xml->push('ReferenceNumber');
                    $xml->element('Code', $package->referenceCode2);
                    $xml->element('Value', $package->referenceValue2);
                $xml->pop(); // end ReferenceNumber
            }

            if ($package->monetaryValue != '' || $package->flexibleAccess != '' || $package->signatureType != '' || $package->codAmount != '') {
                $xml->push('PackageServiceOptions');
                    if ($package->flexibleAccess != '') {
                        $xml->element('ReturnsFlexibleAccessIndicator', '1');
                    }
                    if ($package->signatureType != '') {
                        $xml->push('DeliveryConfirmation');
                            $xml->element('DCISType', $package->signatureType);
                        $xml->pop(); // end DeliveryConfirmation
                    }
                    if ($package->monetaryValue != '') {
                        $xml->push('InsuredValue');
                            $xml->element('CurrencyCode', $package->insuredCurrency);
                            $xml->element('MonetaryValue', $package->monetaryValue);
                        $xml->pop(); // End Insured Value
                    }
                    if ($package->codAmount != '') {
                        $xml->push('COD');
                            $xml->element('CODCode', '3');
                            $xml->element('CODFundsCode', $package->codFundType);
                            $xml->push('CODAmount');
                                $xml->element('CurrencyCode', $package->insuredCurrency);
                                $xml->element('MonetaryValue', $package->codAmount);
                            $xml->pop(); // end CODAmount
                        $xml->pop(); // end COD
                    }
                $xml->pop(); // end PackageServiceOptions
            }

        $xml->pop(); // end Package

        $this->core->packagesObject = $xml;

        return true;
    }
    //}}


    //{{_UPS
    function addCustomsLineToUPSshipment($customs) {
        if (!isset($this->core->customsObject)) {
            $this->core->customsObject = new xmlBuilder(true);
        }
	$xml = $this->core->customsObject;
	$xml->push('Product');
		$xml->element('Description', substr($customs->invoiceLineDescription,0,35));
		$xml->push('Unit');
			$xml->element('Number', $customs->invoiceLineNumber); 
			$xml->element('Value', $customs->invoiceLineValue); 
			$xml->push('UnitOfMeasurement');
				$xml->element('Code', 'EA'); 
			$xml->pop(); //End UOM
		$xml->pop(); //end Unit
		//$xml->element('CommodityCode', '920992');
		$xml->element('PartNumber', $customs->invoiceLinePartNumber); 
		$xml->element('OriginCountryCode', $customs->invoiceLineOriginCountryCode);
	$xml->pop(); // end Product 

        return $this->core->customsObject = $xml;
    }
    //}}
    
    //{{_UPS
    function buildUPSshipmentXML() {
        $this->core->access();
        $xml = $this->core->xmlObject;

        $xml->push('ShipmentConfirmRequest');
        $xml->push('Request');
        $xml->push('TransactionReference');
            $xml->element('CustomerContext', 'RocketShipIt');
            $xml->element('XpciVersion', '1.0001');
        $xml->pop();
        $xml->element('RequestAction', 'ShipConfirm');
        if ($this->verifyAddress != '') {
            $xml->element('RequestOption', $this->verifyAddress);
        }
        $xml->pop(); // end Request
        $xml->push('Shipment');
            if ($this->shipmentDescription != '') {
                $xml->element('Description', $this->shipmentDescription);
            }
        if ($this->returnCode != '' && $this->fromCity != '') {
            $xml->push('ReturnService');
                $xml->element('Code', $this->returnCode);
            $xml->pop(); // end ReturnService
        }
        if ($this->returnCode == '8' || $this->codAmount != '' || $this->emailTo != '' || $this->signatureType != '') {
            $xml->push('ShipmentServiceOptions');
                if ($this->signatureType != '') {
                    $xml->push('DeliveryConfirmation');
                        $xml->element('DCISType', $this->signatureType);
                    $xml->pop(); // end DeliveryConfirmation
                }
                if ($this->emailTo != '') {
                    $xml->push('Notification');
                        $xml->element('NotificationCode', '6');
                        $xml->push('EMailMessage');
                            $xml->element('EMailAddress', $this->emailTo);
                        $xml->pop(); // end EMailMessage
                    $xml->pop(); //end Notification
                }
                if ($this->codAmount != '') {
                    $xml->push('COD');
                        $xml->element('CODCode', '3');
                        $xml->element('CODFundsCode', $this->codFundType);
                        $xml->push('CODAmount');
                            $xml->element('CurrencyCode', $this->insuredCurrency);
                            $xml->element('MonetaryValue', $this->codAmount);
                        $xml->pop(); // end CODAmount
                    $xml->pop(); // end COD
                }
                if ($this->returnCode == '8' && $this->fromCity != '') {
                    $xml->push('LabelDelivery');
                        $xml->push('EMailMessage');
                            $xml->element('EMailAddress', $this->returnEmailAddress);
                            $xml->element('UndeliverableEMailAddress', $this->returnUndeliverableEmailAddress);
                            $xml->element('FromEMailAddress', $this->returnFromEmailAddress);
                            $xml->element('FromName', $this->returnEmailFromName);
                        $xml->pop(); // end EMailMessage
                    $xml->pop(); // end LabelDelivery
                }
            $xml->pop(); // end ShipmentServiceOptions
        }
        $xml->append($this->buildShipperXml());
        $xml->append($this->buildShipToXml());
        if ($this->fromName!= '') {
            $xml->append($this->buildShipFromXml());
        }
        if ($this->referenceValue && $this->referenceCode != '') {
            $xml->push('ReferenceNumber');
                $xml->element('Code', $this->referenceCode);
                $xml->element('Value', $this->referenceValue);
            $xml->pop(); // end ReferenceNumber
        }
        $xml->push('Service');
            if ($this->service != '') {
                $xml->element('Code', $this->service);
            }
            if ($this->serviceDescription != '') {
                $xml->element('Description', $this->serviceDescription);
            }
        $xml->pop(); // end Service 
        $xml->push('PaymentInformation');
            if ($this->billThirdParty) {
                $xml->push('BillThirdParty');
                    $xml->push('BillThirdPartyShipper');
                        $xml->element('AccountNumber', $this->thirdPartyAccount);
                        if ($this->thirdPartyPostalCode != '' && $this->thirdPartyCountryCode != '') {
                            $xml->push('ThirdParty');
                                $xml->push('Address');
                                    $xml->element('PostalCode', $this->thirdPartyPostalCode);
                                    $xml->element('CountryCode', $this->thirdPartyCountryCode);
                                $xml->pop(); // end Address
                            $xml->pop(); //end ThirdParty
                        }
                    $xml->pop(); // end BillThirdPartyShipper
                $xml->pop(); // end BillThirdParty
            } else {
                $xml->push('Prepaid');
                    $xml->push('BillShipper');
                        $xml->element('AccountNumber', $this->accountNumber);   
                    $xml->pop(); // end BillShipper 
                $xml->pop(); // end Prepaid
            }
        $xml->pop(); // end PaymentInformation
        if ($this->monetaryValue != '') {
            $xml->push('InvoiceLineTotal');
                $xml->element('MonetaryValue', $this->monetaryValue);
            $xml->pop(); // end InvoiceLineTotal
        }
        if ($this->saturdayDelivery != '') {
        $xml->push('ShipmentServiceOptions');
            $xml->element('SaturdayDelivery', $this->saturdayDelivery);
        $xml->pop(); // end ShipmentServiceOptions
        }

		//Paperless Invoice
			if ($this->invoice) {
				$xml->push('ShipmentServiceOptions');
					$xml->push('InternationalForms');
						$xml->element('FormType', '01');
						if ($this->additionalDocs) {
							$xml->push('AdditionalDocumentIndicator');
							$xml->pop();
						}
						
					$xmlString = $xml->getXml();
			
					$xmlString .= $this->core->customsObject->getXml();
					
					$xml = new xmlBuilder(true);
			
					$xml->element('InvoiceNumber', $this->invoice);
					$xml->element('InvoiceDate', $this->invoiceDate);
					//$xml->element('ReasonForExport', $this->invoiceReason);
					$xml->element('ReasonForExport', 'SALE');
					$xml->element('DeclarationStatement', 'I hereby certify that the information on this invoice is true and correct and the contents and value of this shipment is as stated above.');
					$xml->element('CurrencyCode', 'USD');					

					$xmlString .= $xml->getXml();
					
					$xmlString .= "</InternationalForms>
					";
					$xmlString .= "</ShipmentServiceOptions>
					";
					$xml = new xmlBuilder(true);
					
			}

		//Paperless Invoice
		    $xml->push('SoldTo');
				$xml->element('CompanyName', $this->soldCompany);
				$xml->element('AttentionName', $this->soldName);
				$xml->element('TaxIdentificationNumber', $this->soldTaxId);
				$xml->element('PhoneNumber', $this->soldPhone);
				$xml->push('Address');
					$xml->element('AddressLine1', $this->soldAddr1);
					$xml->element('AddressLine2', $this->soldAddr2);
					$xml->element('City', $this->soldCity);
					$xml->element('StateProvinceCode', $this->soldState);
					$xml->element('PostalCode', $this->soldCode);
					$xml->element('CountryCode', $this->soldCountry);
				$xml->pop(); // end Address
			$xml->pop();
		///////////////

        // If negotiated rates have been requested
        if ($this->negotiatedRates == '1') {
            $xml->push('RateInformation');
                $xml->element('NegotiatedRatesIndicator', '1');
            $xml->pop(); // close RateInformation
        }
        
		if (isset($xmlString)) {
			$xmlString .= $xml->getXml();
		} else {
			$xmlString = $xml->getXml();
		}

        $xmlString .= $this->core->packagesObject->getXml();

        $xmlString .= '</Shipment>'. "\n";

        $xml = new xmlBuilder(true);

        $xml->push('LabelSpecification');
            $xml->push('LabelPrintMethod');
                if ($this->labelPrintMethodCode != '') {
                    $xml->element('Code', $this->labelPrintMethodCode);
                }
                    if ($this->labelDescription != '') {
                        $xml->element('Description', $this->labelDescription);
                    }
            $xml->pop(); // end LabelPrintMethod
            if ($this->httpUserAgent != '') {
                $xml->element('HTTPUserAgent', $this->httpUserAgent);
            }
                $xml->push('LabelStockSize');
                    if ($this->lengthUnit != '') {
                        $xml->element('UnitOfMeasurement', $this->lengthUnit);
                    }
                    if ($this->labelHeight != '') {
                        $xml->element('Height', $this->labelHeight);
                    }
                    if ($this->labelWidth != '') {
                        $xml->element('Width', $this->labelWidth);
                    }
                $xml->pop(); // end LabelStockSize
            $xml->push('LabelImageFormat');
                if ($this->labelImageFormat != '') {
                    $xml->element('Code', $this->labelImageFormat);
                }
            $xml->pop(); // end LabelImageFormat
        $xml->pop(); // end LabelSpecification

        $labelXmlString = $xml->getXml();
        
        $xmlString .= $labelXmlString;

        $xmlString .= '</ShipmentConfirmRequest>';
        return $xmlString;
    }
    //}}

    function buildShipperXml() {
        $xml = new xmlBuilder(true);
        $xml->push('Shipper');
            if ($this->shipper != '') {
                $xml->element('Name', $this->shipper);
            }
            if ($this->shipContact != '') {
                $xml->element('AttentionName', $this->shipContact);
            }
            if ($this->accountNumber != '') {
                $xml->element('ShipperNumber', $this->accountNumber);
            }
            if ($this->shipPhone != '') {
                $xml->element('PhoneNumber', $this->shipPhone);
            }
            $xml->push('Address');
                if ($this->shipAddr1 != '') {
                    $xml->element('AddressLine1', $this->shipAddr1);
                }
                if ($this->shipAddr2 != '') {
                    $xml->element('AddressLine2',$this->shipAddr2);
                }
                if ($this->shipCity != '') {
                    $xml->element('City', $this->shipCity);
                }
                if ($this->shipState != '') {
                    $xml->element('StateProvinceCode', $this->shipState);
                }
                if ($this->shipCode != '') {
                    $xml->element('PostalCode', $this->shipCode);
                }
                if ($this->shipCountry != '') {
                    $xml->element('CountryCode', $this->shipCountry);
                }
            $xml->pop(); // end Address
        $xml->pop(); // end Shipper 
        return $xml->getXml();
    }

    function buildShipToXml() {
        $xml = new xmlBuilder(true);
        $xml->push('ShipTo');
            if ($this->toCompany == "" && $this->toName == "") {
                exit("Must have either name or company set for shipping address");
            }
            if ($this->toCompany != '') {
                $xml->element('CompanyName', $this->toCompany);
            } else {
                $xml->element('CompanyName', $this->toName);
            }
            if ($this->toAttentionName != '') {
                $xml->element('AttentionName', $this->toAttentionName);
            } else {
                $xml->element('AttentionName', $this->toName);
            }
            if ($this->toPhone != '') {
                $xml->element('PhoneNumber', $this->toPhone);
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
                $xml->element('City', $this->toCity);
                if ($this->toState != '') {
                    $xml->element('StateProvinceCode', $this->toState);
                }
                if ($this->toCountry != '') {
                    $xml->element('CountryCode', $this->toCountry);
                }
                if ($this->toCode != '') {
                    $xml->element('PostalCode', $this->toCode);
                }
                if ($this->residentialAddressIndicator == '1') {
                    $xml->emptyelement('ResidentialAddress');
                }
            $xml->pop(); // end Address
        $xml->pop(); // end ShipTo
        return $xml->getXml();
    }

    function buildShipFromXml() {
        $xml = new xmlBuilder(true);
        $xml->push('ShipFrom');
            $xml->element('CompanyName', $this->fromName);
            $xml->push('Address');
                $xml->element('AddressLine1', $this->fromAddr1);
                if ($this->fromAddr2 != '') {
                    $xml->element('AddressLine2', $this->fromAddr2);
                }
                if ($this->fromAddr3 != '') {
                    $xml->element('AddressLine3', $this->fromAddr3);
                }
                $xml->element('City', $this->fromCity);
                $xml->element('StateProvinceCode', $this->fromState);
                $xml->element('CountryCode', $this->fromCountry);
                $xml->element('PostalCode', $this->fromCode);
            $xml->pop(); // end Address
        $xml->pop(); // end ShipFrom
        return $xml->getXml();
    }

    //{{_UPS
    function simplifyUPSResponse($xmlArray) {
        if ($xmlArray['ShipmentConfirmResponse']['Response']['ResponseStatusCode']['VALUE'] != "1") {
            return ("Error confirming shipment: ".
                    $xmlArray['ShipmentConfirmResponse']['Response']['Error']['ErrorDescription']['VALUE'].
                    " (".$xmlArray['ShipmentConfirmResponse']['Response']['Error']['ErrorCode']['VALUE'].")");
        }


        $labelArray = $this->getUPSlabels();
        $a = $labelArray['ShipmentAcceptResponse']['ShipmentResults'];
        $outArr = "";
        $outArr['charges']  = $a['ShipmentCharges']['TotalCharges']['MonetaryValue']['VALUE'];
        
        // If negotiated rates have been requested
        if ($this->negotiatedRates == '1') {
            if (isset($a['NegotiatedRates']['NetSummaryCharges']['GrandTotal']['MonetaryValue']['VALUE'])) {
                $outArr['negotiated_charges'] = $a['NegotiatedRates']['NetSummaryCharges']['GrandTotal']['MonetaryValue']['VALUE'];
            }
        }
        
        $outArr['trk_main'] = $a['ShipmentIdentificationNumber']['VALUE'];
        if (array_key_exists('TrackingNumber',$a['PackageResults'])) {  
            // just a single label
            $outArr['pkgs'][0]['pkg_trk_num']   = $a['PackageResults']['TrackingNumber']['VALUE'];
            $outArr['pkgs'][0]['label_fmt'] = $a['PackageResults']['LabelImage']['LabelImageFormat']['Code']['VALUE'];
            $outArr['pkgs'][0]['label_img'] = $a['PackageResults']['LabelImage']['GraphicImage']['VALUE'];
            $outArr['pkgs'][0]['label_html'] = $a['PackageResults']['LabelImage']['HTMLImage']['VALUE'];
        } else {
            // multiple labels
            for ($i=0; $i<count($a['PackageResults']); $i++) {
                $pkg = $a['PackageResults'][$i];
                $outArr['pkgs'][$i]['pkg_trk_num']  = $pkg['TrackingNumber']['VALUE'];
                $outArr['pkgs'][$i]['label_fmt']    = $pkg['LabelImage']['LabelImageFormat']['Code']['VALUE'];
                $outArr['pkgs'][$i]['label_img']    = $pkg['LabelImage']['GraphicImage']['VALUE'];
                $outArr['pkgs'][$i]['label_html']  = $pkg['LabelImage']['HTMLImage']['VALUE'];
            }
        }
        if (array_key_exists('ControlLogReceipt',$a)) {
            $outArr['high_value_report'] = $a['ControlLogReceipt']['GraphicImage']['VALUE'];
        }
        if (array_key_exists('CodeTurnInPage',$a)) {
            $outArr['cod_html'] = $a['CodeTurnInPage']['Image']['GraphicImage']['VALUE'];     
        }
		if (array_key_exists('Form', $a)) {
			$outArr['customs'] = $a['Form']['Image']['GraphicImage']['VALUE'];
		}
        return $outArr;
    }
    //}}
    
    function sendShipment () {
        switch ($this->carrier) {
            case "UPS":
                return $this->sendUPSshipment();
            default:
                return false;
        }
    }
        
    //{{_UPS
    function sendUPSshipment () {
        $xml = $this->buildUPSshipmentXML();

        $responseXml = $this->core->request('ShipConfirm', $xml);

        // This is kind of wierd, normally we dont have to reuse the xmlObject in other UPS 
        // services; however, the shipping service requires you to make two seperate XML
        // requests before you get a lablel.  To prepare for the next XML request (see getLabel)
        // we need to reset the object so nothing is in it.
        $this->core->xmlObject = new xmlBuilder(false); // reset the object so getLabel can start a new one

        $xmlParser = new upsxmlParser();
        
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();

        return $xmlArray; 
    }
    //}}
    
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
    
    //{{_UPS
    function getUPSlabels() {
    
        $xmlParser = new upsxmlParser();
        $responseArray = $xmlParser->xmlParser($this->core->xmlResponse);
        $responseArray = $xmlParser->getData();

        $shipmentDigest = $responseArray['ShipmentConfirmResponse']['ShipmentDigest']['VALUE'];

        $this->core->access(); // populate the ups->xmlObject with access xml

        $xml = $this->core->xmlObject;
        $xml->push('ShipmentAcceptRequest');
            $xml->push('Request');
                $xml->push('TransactionReference');
                    $xml->element('CustomerContext', 'guidlikesubstance');
                    $xml->element('XpciVersion', '1.0001');
                $xml->pop(); // end TransactionReference
            $xml->element('RequestAction', 'ShipAccept');
            $xml->pop(); // end Request
        $xml->element('ShipmentDigest', $shipmentDigest);
        $xml->pop(); // end ShipmentAcceptRequest

        $xmlString = $xml->getXml();

        // Store previous xmlSent before putting in new one
        $this->core->xmlPrevSent = $this->core->xmlSent;

        // Put the xml that is sent do UPS into a variable so we can call it later for debugging.
        $this->core->xmlSent = $xmlString;

        // Store previous xml response
        $this->core->xmlPrevResponse = $this->core->xmlResponse;

        $this->core->xmlResponse = $this->core->request('ShipAccept', $xmlString);

        $xmlParser = new upsxmlParser();
        $xmlArray = $xmlParser->xmlparser($this->core->xmlResponse);
        $xmlArray = $xmlParser->getData();
        return $xmlArray; 
    }
    //}}
    
    /**
     * Creates random string of alphanumeric characters
     * 
     * @return string
     */
    function generateRandomString() {
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
