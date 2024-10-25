<?php
/**
 * Copyright RocketShipIt LLC All Rights Reserved
 * Author: Mark Sanborn
 * Version: 1.1.5.4
 * PHP Version 5
 * For Support email: support@rocketship.it
**/

// RocketShipIt Config
require_once('config.php');


function autoload_class_multiple_directory($class_name) {
    # List all the class directories in the array.
    $array_paths = array(
        '.',
        'carriers', 
        'helpers', 
        'services',
        'services/shipment',
        'services/rate',
        'services/pickup',
        'services/address_validate',
        'services/locator',
        'services/time_in_transit',
        'services/track',
        'services/void'
    );

    $main_path = (pathinfo(__FILE__));
    foreach($array_paths as $path) {
        $file = sprintf('%s/%s/%s.php', $main_path['dirname'], $path, $class_name);
        if(is_file($file)) {
            require_once $file;
        } 

    }
}

spl_autoload_register('autoload_class_multiple_directory');
//}}

/**
* Ensures that only settable paramaters are allowed.
*
* This function aids the setPramater() function in that it only
* allows known paramaters to be set.  This helps to avoid typos when
* setting parameters.
*/
function rocketshipit_getOKparams($carrier) {
    // Force fedex, FedEx, FEDEX to all read the same
    $carrier = strtoupper($carrier);

    // Generic parameters that are accessible in each class regardless of carrier
    $generic = array('shipper','enableRocketShipAPI','shipContact','shipPhone',
                     'accountNumber','shipAddr1','shipAddr2','shipAddr3',
                     'shipCity','shipState','shipCode','shipCountry',
                     'toCompany','toName','toPhone','toAddr1','toAddr2',
                     'toAddr3','toCity','toState','toCountry','toCode',
                     'service','weightUnit','length','width','height',
                     'weight','toExtendedCode', 'currency', 'toAttentionName',
                     'fromName', 'fromAddr1', 'fromAddr2', 'fromCity', 'fromState',
                     'fromCode', 'fromExtendedCode');

    // Carrier specific parameters
    switch ($carrier) {
        case "UPS":
            $specific = array('earliestTimeReady','latestTimeReady',
                              'httpUserAgent','labelPrintMethodCode',
                              'labelDescription','labelHeight','labelWidth',
                              'labelImageFormat','residentialAddressIndicator',
                              'PickupType', 'pickupDescription',
                              'shipmentDescription','packagingType',
                              'packageLength','packageWidth','packageHeight',
                              'packageWeight','referenceCode','referenceValue',
                              'insuredCurrency','monetaryValue',
                              'referenceCode2','referenceValue2','pickupDate',
                              'lengthUnit','serviceDescription','returnCode',
                              'fromAddr2','fromAddr3','fromCountry',
                              'fromAttentionName','fromPhoneNumber','fromFaxNumber',
                              'packageDescription','returnEmailAddress',
                              'returnUndeliverableEmailAddress',
                              'returnFromEmailAddress','returnEmailFromName',
                              'verifyAddress','negotiatedRates',
                              'saturdayDelivery','billThirdParty',
                              'thirdPartyAccount','codFundType',
                              'codAmount','flexibleAccess', 'signatureType',
                              'customerClassification', 'pickupAddr1',
                              'pickupCity', 'pickupState', 'pickupCode',
                              'pickupCountry', 'pickupResidential', 'pickupAlternative',
                              'closeTime', 'readyTime', 'pickupCompanyName', 'pickupContactName',
                              'pickupPhone','pickupServiceCode', 'pickupQuantity', 'pickupDestination',
                              'pickupContainerCode', 'pickupAlternative', 'pickupOverweight',
                              'paymentMethodCode', 'pickupCardHolder', 'pickupCardType', 
                              'pickupCardNumber', 'pickupCardExpiry', 'pickupCardSecurity',
                              'pickupCardAddress', 'pickupCardCountry', 'pickupPRN', 'trackingNumber',
                              'pickupRoom', 'pickupFloor', 'thirdPartyPostalCode',
                              'thirdPartyCountryCode','invoiceLineNumber', 'invoiceLineDescription',
							  'invoiceLineValue', 'invoiceLinePartNumber', 'invoiceLineOriginCountryCode',
							  'invoice', 'invoiceDate', 'invoiceReason', 'invoiceCurr', 'additionalDocs',
							  'soldName', 'soldCompany', 'soldTaxId', 'soldPhone', 'soldAddr1', 'soldAddr2',
							  'soldCity', 'soldState', 'soldCode', 'soldCountry',
                              'license', 'username', 'password', 'emailTo');
            break;
        case "USPS":
            $specific = array('userid','imageType','weightPounds',
                              'weightOunces','firstClassMailType',
                              'packagingType','pickupDate', 'permitNumber',
							  'permitIssuingPOCity', 'permitIssuingPOState',
							  'permitIssuingPOZip5', 'pduFirmName', 'pduPOBox',
							  'pduCity', 'pduState', 'pduZip5', 'pduZip4',
                              'returnEmailAddress', 'returnFromName',
                              'returnFromEmailAddress','returnEmailFromName',
                              'returnToName', 'referenceValue');
            break;
        case "FEDEX":
            $specific = array('key','packagingType','weightUnit','lengthUnit',
                              'dropoffType','residential','paymentType',
                              'labelFormatType','imageType','labelStockType',
                              'packageCount','sequenceNumber','trackingIdType',
                              'trackingNumber','shipmentIdentification',
                              'pickupDate','signatureType','referenceCode',
                              'referenceValue', 'smartPostIndicia', 'smartPostHubId',
                              'smartPostEndorsement', 'smartPostSpecialServices',
                              'insuredCurrency', 'insuredValue', 'saturdayDelivery',
                              'residentialAddressIndicator', 'customsDocumentContent',
                              'customsValue', 'customsNumberOfPieces',
                              'countryOfManufacture', 'customsWeight',
                              'customsCurrency', 'collectOnDelivery', 'codCollectionType', 
                              'codCollectionAmount', 'holdAtLocation', 'holdPhone', 'holdStreet',
                              'holdCity', 'holdState', 'holdCode', 'holdCountry', 'holdResidential',
                              'saturdayDelivery', 'futureDay', 'shipDate', 'nearPhone',
                              'nearCode', 'nearAddr1', 'nearCity', 'nearState', 'returnCode',
                              'referenceValue2', 'referenceCode2', 'referenceValue3', 'referenceCode3',
                              'emailMessage', 'emailRecipientType', 'emailTo', 'emailFormat',
                              'emailLanguage', 'thirdPartyAccount', 'key', 'password', 'meterNumber',
                              'notifyOnShipment', 'notifyOnException', 'notifyOnDelivery',
                              'customsQuantity', 'customsQuantityUnits', 'customsLineAmount',
                              'customsDescription', 'monetaryValue', 'notifyOnTender',
                              'codAccountNumber', 'codContactId', 'codPersonName',
                              'codTitle', 'codCompany', 'codPhone', 'codPhoneExtension',
                              'codPagerNumber', 'codFaxNumber', 'codEmailAddress', 'codAddr1',
                              'codCity', 'codState', 'codCode', 'codUrbanizationCode',
                              'codCountry', 'codResidential', 'generateDocs', 'paperlessCustoms',
                              'docImageType', 'docStockType');
            break;
        case "STAMPS":
            $specific = array('weightPounds', 'imageType', 'packagingType',
                              'declaredValue', 'customsContentType', 'customsComments',
                              'customsLicenseNumber', 'customsCertificateNumber',
                              'customsInvoiceNumber', 'customsOtherDescribe',
                              'customsDescription', 'customsQuantity', 'customsValue',
                              'customsWeight', 'customsHsTariff', 'customsOriginCountry',
                              'insuredValue', 'referenceValue', 'weightOunces', 'emailTo',
                              'shipDate');
            break;
        case "DHL":
            $specific = array('siteId', 'password', 'lengthUnit', 'trackingIdType');
            break;
        case "CANADA":
            $specific = array('username', 'password');
            break;
        default: 
            throw new RuntimeException("Invalid carrier '$carrier' in getOKparams");
    }
    return array_merge($generic, $specific);
}

/**
* Gets defaults
*
* This function will grab defaults from config.php
*/
function rocketshipit_getParameter($param, $value, $carrier) {
    // Force fedex, FedEx, FEDEX to all read the same
    $carrier = strtoupper($carrier);

    // If the default is not in the getOKparams function an exception is thrown
    if (!in_array($param, rocketshipit_getOKparams($carrier)) && $param != '') {
        throw new RuntimeException("Invalid parameter '$param' in setParameter");
    }

    if ($value == "") { // get the default, if set
        $value = getGenericDefault($param);
        if ($value == "") { // not in the generics? look in the specific carrier params
            switch ($carrier) {
                case "UPS":
                    $value = getUPSDefault($param);
                    break;
                case "USPS":
                    $value = getUSPSDefault($param);
                    break;
                case "FEDEX":
                    $value = getFEDEXDefault($param);
                    break;
                case "STAMPS":
                    $value = getSTAMPSDefault($param);
                    break;
                case "DHL":
                    $value = getDHLDefault($param);
                    break;
                case "CANADA":
                    $value = getCANADADefault($param);
                    break;
                default:
                    throw new RuntimeException("Unknown carrier in setParameter: '$carrier'");
            }
        }
    }
    return $value;
}

/**
* Validates carrier name
*
* This function will return true when given a proper
* carier name.
*/
function rocketshipit_validateCarrier($carrier) {
    switch (strtoupper($carrier)) {
        case "UPS":
            return true;
        case "FEDEX":
            return true;
        case "USPS":
            return true;
        case "STAMPS":
            return true;
        case "DHL":
            return true;
        case "CANADA":
            return true;
        default:
            throw new RuntimeException("Unknown carrier in RocketShipShipment: '$carrier'");
    }
}

/**
* Create html code for base64 embedded image
*
* This function will return valid html for an
* embedded base64 image.  This html does not
* work in all browsers.
*/
function rocketshipit_label_html($base64_encoded_label, $imageType) {
    return "<img src=\"data:image/$imageType;base64,$base64_encoded_label\" alt=\"Label\" />";
}

function rocketshipit_xmlPrettyPrint($xml) {
    $previous_value = libxml_use_internal_errors(TRUE);
    $doc = new DOMDocument();
    $dom->strictErrorChecking = FALSE;
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput   = true;
    $status = $doc->loadXML($xml, LIBXML_NOWARNING);
    $formatted_xml = $doc->saveXML();
    libxml_clear_errors();
    libxml_use_internal_errors($previous_value);
    if ($status) {
        return $formatted_xml;
    } else {
        return $xml;
    }
}

// Takes a multi-dimensional array and makes a nested bulleted list
function printArrayTree( $array ) {
    print "\n<ul>\n";
    foreach( $array as $key => $value ) {
        if ( is_array($value) ) {
            print "<li>$key</li>\n";
            printArrayTree( $value );
        } else { 
            //print "<li>$value</li>\n";
        }
    }
    print "</ul>\n";
}

require_once("QueryPath.php");

// Error if cURL is not present
if (!extension_loaded('curl')) {
    exit('The required php extension, cURL, was not found.  Please install the cURL module to continue using RocketShipIt.');
}
?>
