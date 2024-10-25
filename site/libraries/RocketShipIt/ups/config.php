<?php
//Copyright RocketShipIt LLC All Rights Reserved
// For Support email: support@rocketship.it

// Feel free to modify the following defaults:

// You can find out which timezones are available here:
// http://php.net/manual/en/timezones.php
date_default_timezone_set('America/Denver');

// If __DIR__ is not defiened (PHP version < 5.3)
if(!defined('__DIR__')) {
    $iPos = strrpos(__FILE__, "/");
    define("__DIR__", substr(__FILE__, 0, $iPos) . "/");
}

/**
* This function is used to set generic defaults.  I.e. They are not carrier-specific.
*
* These defaults will be used across all carriers.  They can be overwritten on the
* shipment/package level.
*/
function getGenericDefault($def) {
    $a = array();

    // 1 for Debug mode; 0 for normal operations
    // This also changes from testing to production mode
    $a['debugMode'] = 1;

    // Your company name
    $a['shipper'] = 'Blix Graphics';

    // Key shipping contact individual at your company
    $a['shipContact'] = "Diego Bussano";

    $a['shipAddr1'] = '1352 NW 78th Ave';
    $a['shipAddr2'] = '';
    $a['shipCity'] = 'Doral';

    // the two-letter State or Province code
    // ex. MT = Montana, ON = Ontario
    $a['shipState'] = 'FL';

    // The Zip or Postal code
    $a['shipCode'] = '33126';

    // The two-letter country code
    $a['shipCountry'] = 'US';

    // Phone number in this format: 1234567890
    $a['shipPhone'] = '3055729001';
    $a['toCountry'] = 'US';

    if (array_key_exists($def, $a)) {
        return $a[$def];
    } else {
        return '';
    }
}




/**
* This function is used to set UPS specfic defaults.
*
* These defaults will be used for UPS calls only.  They can be overwritten on the
* shipment/package level using the setParameter() function.
*/
function getUPSDefault($def) {
    $a = array();

    // Your UPS Developer license
    // your UPS XML Access Key TODO: Insert link to get one
    $a['license'] = 'ACACB6B6E5A91A6A';

    // your UPS Developer username
    $a['username'] = 'blix33137';

    // your ups Developer password
    $a['password'] = 'Miami!2016'; //'Miami!3048';
    //$a['password'] = 'Roraima-23'; //'Miami!3048';

    // Make sure addresses are valid before label creation
    // validate, nonvalidate
    $a['verifyAddress'] = 'nonvalidate';

    // The following variables govern the way the system functions
    // Options
    // ZPL - Zebra UPS Thermal Printers
    // EPL - Eltron UPS Thermal Printers
    // GIF - Image based, desktop inkjet printers
    // STARPL
    // SPL
    $a['labelPrintMethodCode'] = 'ZPL';

    // Used when printing GIF images
    $a['httpUserAgent'] = 'Mozilla/4.5';

    // Only valid option for ZPL, EPL, STARPL, and SPL is 4
    // When using inches use whole numbers only
    $a['labelHeight'] = '';

    // Options are 6 or 8 inches
    $a['labelWidth'] = '6';

    // Options
    // GIF - A gif image
    $a['labelImageFormat'] = '';

    // The following variables are for your UPS account
    // They typically don't change from shipment to shipment; although,
    // you may set any of them directly.
    // Your UPS Account number
    $a['accountNumber'] = '3V880E'; //'87772R';

    // Options
    // 01 - Daily Pickup
    // 03 - Customer Counter
    // 06 - One Time Pickup
    // 07 - On Call Air
    // 11 - Suggested Retail Rates
    // 19 - Letter Center
    // 20 - Air Service Center
    $a['PickupType'] = '01';

    // LBS or KGS
    $a['weightUnit'] = 'LBS';

    // IN, or CM
    $a['lengthUnit'] = 'IN';

    // See the ups manual for a list of all currency types
    $a['insuredCurrency'] = 'USD';

    // two-letter country code
    $a['toCountryCode'] = 'US';

    // The following variables set the defaults for individual shipments
    // you may set them here to save time, or you may set them explicitly
    // each time you use the classes.
    $a['shipmentDescription'] = 'BlixGraphics Shipment';

    // Options
    // 01 - UPS Next Day Air
    // 02 - UPS Second Day Air
    // 03 - UPS Ground
    // 07 - UPS Worldwide Express
    // 08 - UPS Worldwide Expedited
    // 11 - UPS Standard
    // 12 - UPS Three-Day Select
    // 13 - Next Day Air Saver
    // 14 - UPS Next Day Air Early AM
    // 54 - UPS Worldwide Express Plus
    // 59 - UPS Second Day Air AM
    // 65 - UPS Saver
    $a['service'] = '01';

    // Options
    // 01 - UPS Letter
    // 02 - Your Packaging
    // 03 - Tube
    // 04 - PAK
    // 21 - Express Box
    // 24 - 25KG Box
    // 25 - 10KG Box
    // 30 - Pallet
    // 2a - Small Express Box
    // 2b - Medium Express Box
    // 2c - Large Express Box
    $a['packagingType'] = '02';

    $a['packageDescription'] = 'Rate';

    // Set '0' for commercial '1' for residential
    $a['residentialAddressIndicator'] = '0';

    // Set '0' for retail rates '1' for negotiated
    // You must turn this on with your UPS account rep
    $a['negotiatedRates'] = '0';

    // Options
    // AJ Accounts Receivable Customer Account
    // AT Appropriation Number
    // BM Bill of Lading Number
    // 9V Collect on Delivery (COD) Number
    // ON Dealer Order Number
    // DP Department Number
    // 3Q Food and Drug Administration (FDA) Product Code
    // IK Invoice Number
    // MK Manifest Key Number
    // MJ Model Number
    // PM Part Number
    // PC Production Code
    // PO Purchase Order Number
    // RQ Purchase Request Number
    // RZ Return Authorization Number
    // SA Salesperson Number
    // SE Serial Number
    // ST Store Number
    // TN Transaction Reference Number
    $a['referenceCode'] = 'IK';

    // Options
    // 2 - UPS Print and Mail (PNM)
    // 3 - UPS Return Service 1-Attempt (RS1)
    // 5 - UPS Return Service 3-Attempt (RS3)
    // 8 - UPS Electronic Return Label (ERL)
    // 9 - UPS Print Return Label (PRL)
    $a['returnCode'] = '';

    // Options
    // 00 - Rates Associated with Shipper Number
    // 01 - Daily Rates
    // 04 - Retail Rates
    // 53 - Standard List Rates
    $a['customerClassification'] = '';

    // If default doesn't exist it needs to be set to blank.
    if (array_key_exists($def, $a)) {
        return $a[$def];
    } else {
        return '';
    }
}









?>
