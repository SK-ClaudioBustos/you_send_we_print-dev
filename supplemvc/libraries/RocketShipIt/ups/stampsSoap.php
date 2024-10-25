<?php

if (!class_exists("CreateIndicium")) {
/**
 * CreateIndicium
 */
class CreateIndicium {
    /**
     * @access public
     * @var sstring
     */
    //public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxID;
    /**
     * @access public
     * @var tnsstring0128
     */
    public $TrackingNumber;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
    /**
     * @access public
     * @var Address
     */
    public $From;
    /**
     * @access public
     * @var Address
     */
    public $To;
    /**
     * @access public
     * @var tnsstring164
     */
    public $CustomerID;
    /**
     * @access public
     * @var Customs
     */
    public $Customs;
    /**
     * @access public
     * @var sboolean
     */
    public $SampleOnly;
    /**
     * @access public
     * @var tnsImageType
     */
    public $ImageType;
    /**
     * @access public
     * @var tnsEltronPrinterDPIType
     */
    public $EltronPrinterDPIType;
    /**
     * @access public
     * @var sstring
     */
    public $memo;
    /**
     * @access public
     * @var sint
     */
    public $cost_code_id;
    /**
     * @access public
     * @var sstring
     */
    public $recipient_email;
    /**
     * @access public
     * @var sboolean
     */
    public $deliveryNotification;
    /**
     * @access public
     * @var sboolean
     */
    public $shipmentNotificationCC;
    /**
     * @access public
     * @var sboolean
     */
    public $shipmentNotificationCCToMain;
    /**
     * @access public
     * @var sboolean
     */
    public $shipmentNotificationFromCompany;
    /**
     * @access public
     * @var sboolean
     */
    public $shipmentNotificationCompanyInSubject;
    /**
     * @access public
     * @var sint
     */
    public $rotationDegrees;
    /**
     * @access public
     * @var sint
     */
    public $horizontalOffset;
    /**
     * @access public
     * @var sint
     */
    public $verticalOffset;
    /**
     * @access public
     * @var sint
     */
    public $printDensity;
    /**
     * @access public
     * @var sboolean
     */
    public $printMemo;
    /**
     * @access public
     * @var sboolean
     */
    public $printInstructions;
    /**
     * @access public
     * @var sboolean
     */
    public $requestPostageHash;
    /**
     * @access public
     * @var tnsNonDeliveryOption
     */
    public $nonDeliveryOption;
}}

if (!class_exists("Credentials")) {
/**
 * Credentials
 */
class Credentials {
    /**
     * @access public
     * @var s1guid
     */
    public $IntegrationID;
    /**
     * @access public
     * @var tnsstring040
     */
    public $Username;
    /**
     * @access public
     * @var sstring
     */
    public $Password;
}}

if (!class_exists("RateV9")) {
/**
 * RateV9
 */
class RateV9 {
    /**
     * @access public
     * @var tnsstring310
     */
    public $FromZIPCode;
    /**
     * @access public
     * @var tnsstring310
     */
    public $ToZIPCode;
    /**
     * @access public
     * @var tnsstring22
     */
    public $ToCountry;
    /**
     * @access public
     * @var sdecimal
     */
    public $Amount;
    /**
     * @access public
     * @var sdecimal
     */
    public $MaxAmount;
    /**
     * @access public
     * @var tnsServiceType
     */
    public $ServiceType;
    /**
     * @access public
     * @var sstring
     */
    public $PrintLayout;
    /**
     * @access public
     * @var sstring
     */
    public $DeliverDays;
    /**
     * @access public
     * @var sdouble
     */
    public $WeightLb;
    /**
     * @access public
     * @var sdouble
     */
    public $WeightOz;
    /**
     * @access public
     * @var tnsPackageTypeV6
     */
    public $PackageType;
    /**
     * @access public
     * @var ArrayOfArrayOfAddOnTypeV2
     */
    public $RequiresAllOf;
    /**
     * @access public
     * @var tnsdoublele999
     */
    public $Length;
    /**
     * @access public
     * @var tnsdoublele999
     */
    public $Width;
    /**
     * @access public
     * @var tnsdoublele999
     */
    public $Height;
    /**
     * @access public
     * @var sdate
     */
    public $ShipDate;
    /**
     * @access public
     * @var sdecimal
     */
    public $InsuredValue;
    /**
     * @access public
     * @var sdecimal
     */
    public $RegisteredValue;
    /**
     * @access public
     * @var sdecimal
     */
    public $CODValue;
    /**
     * @access public
     * @var sdecimal
     */
    public $DeclaredValue;
    /**
     * @access public
     * @var sboolean
     */
    public $NonMachinable;
    /**
     * @access public
     * @var sboolean
     */
    public $RectangularShaped;
    /**
     * @access public
     * @var sstring
     */
    public $Prohibitions;
    /**
     * @access public
     * @var sstring
     */
    public $Restrictions;
    /**
     * @access public
     * @var sstring
     */
    public $Observations;
    /**
     * @access public
     * @var sstring
     */
    public $Regulations;
    /**
     * @access public
     * @var sstring
     */
    public $GEMNotes;
    /**
     * @access public
     * @var sstring
     */
    public $MaxDimensions;
    /**
     * @access public
     * @var sstring
     */
    public $DimWeighting;
    /**
     * @access public
     * @var ArrayOfAddOnV2
     */
    public $AddOns;
    /**
     * @access public
     * @var sint
     */
    public $EffectiveWeightInOunces;
    /**
     * @access public
     * @var sboolean
     */
    public $IsIntraBMC;
    /**
     * @access public
     * @var sint
     */
    public $Zone;
    /**
     * @access public
     * @var sint
     */
    public $RateCategory;
    /**
     * @access public
     * @var sstring
     */
    public $ToState;
    /**
     * @access public
     * @var sboolean
     */
    public $CubicPricing;
}}

if (!class_exists("ServiceType")) {
/**
 * ServiceType
 */
class ServiceType {
}}

if (!class_exists("PackageTypeV6")) {
/**
 * PackageTypeV6
 */
class PackageTypeV6 {
}}

if (!class_exists("AddOnTypeV2")) {
/**
 * AddOnTypeV2
 */
class AddOnTypeV2 {
}}

if (!class_exists("AddOnV2")) {
/**
 * AddOnV2
 */
class AddOnV2 {
    /**
     * @access public
     * @var sdecimal
     */
    public $Amount;
    /**
     * @access public
     * @var tnsAddOnTypeV2
     */
    public $AddOnType;
    /**
     * @access public
     * @var ArrayOfArrayOfAddOnTypeV2
     */
    public $RequiresAllOf;
    /**
     * @access public
     * @var ArrayOfAddOnTypeV2
     */
    public $ProhibitedWithAnyOf;
    /**
     * @access public
     * @var sstring
     */
    public $MissingData;
}}

if (!class_exists("Address")) {
/**
 * Address
 */
class Address {
    /**
     * @access public
     * @var sstring
     */
    public $FullName;
    /**
     * @access public
     * @var sstring
     */
    public $NamePrefix;
    /**
     * @access public
     * @var sstring
     */
    public $FirstName;
    /**
     * @access public
     * @var sstring
     */
    public $MiddleName;
    /**
     * @access public
     * @var sstring
     */
    public $LastName;
    /**
     * @access public
     * @var sstring
     */
    public $NameSuffix;
    /**
     * @access public
     * @var sstring
     */
    public $Title;
    /**
     * @access public
     * @var sstring
     */
    public $Department;
    /**
     * @access public
     * @var tnsstring050
     */
    public $Company;
    /**
     * @access public
     * @var tnsstring12147483647
     */
    public $Address1;
    /**
     * @access public
     * @var tnsstring050
     */
    public $Address2;
    /**
     * @access public
     * @var sstring
     */
    public $Address3;
    /**
     * @access public
     * @var tnsstring150
     */
    public $City;
    /**
     * @access public
     * @var tnsstring02
     */
    public $State;
    /**
     * @access public
     * @var tnsstring05
     */
    public $ZIPCode;
    /**
     * @access public
     * @var tnsstring04
     */
    public $ZIPCodeAddOn;
    /**
     * @access public
     * @var sstring
     */
    public $DPB;
    /**
     * @access public
     * @var sstring
     */
    public $CheckDigit;
    /**
     * @access public
     * @var sstring
     */
    public $Province;
    /**
     * @access public
     * @var sstring
     */
    public $PostalCode;
    /**
     * @access public
     * @var tnsstring22
     */
    public $Country;
    /**
     * @access public
     * @var tnsstring028
     */
    public $Urbanization;
    /**
     * @access public
     * @var sstring
     */
    public $PhoneNumber;
    /**
     * @access public
     * @var sstring
     */
    public $Extension;
    /**
     * @access public
     * @var sstring
     */
    public $CleanseHash;
    /**
     * @access public
     * @var sstring
     */
    public $OverrideHash;
}}

if (!class_exists("Customs")) {
/**
 * Customs
 */
class Customs {
    /**
     * @access public
     * @var tnsContentType
     */
    public $ContentType;
    /**
     * @access public
     * @var tnsstring076
     */
    public $Comments;
    /**
     * @access public
     * @var tnsstring06
     */
    public $LicenseNumber;
    /**
     * @access public
     * @var tnsstring08
     */
    public $CertificateNumber;
    /**
     * @access public
     * @var tnsstring015
     */
    public $InvoiceNumber;
    /**
     * @access public
     * @var tnsstring020
     */
    public $OtherDescribe;
    /**
     * @access public
     * @var ArrayOfCustomsLine
     */
    public $CustomsLines;
}}

if (!class_exists("ContentType")) {
/**
 * ContentType
 */
class ContentType {
}}

if (!class_exists("CustomsLine")) {
/**
 * CustomsLine
 */
class CustomsLine {
    /**
     * @access public
     * @var tnsstring160
     */
    public $Description;
    /**
     * @access public
     * @var tnsdoublege1
     */
    public $Quantity;
    /**
     * @access public
     * @var tnsdecimalge0
     */
    public $Value;
    /**
     * @access public
     * @var sdouble
     */
    public $WeightLb;
    /**
     * @access public
     * @var sdouble
     */
    public $WeightOz;
    /**
     * @access public
     * @var tnsstring06
     */
    public $HSTariffNumber;
    /**
     * @access public
     * @var tnsstring22
     */
    public $CountryOfOrigin;
}}

if (!class_exists("ImageType")) {
/**
 * ImageType
 */
class ImageType {
}}

if (!class_exists("EltronPrinterDPIType")) {
/**
 * EltronPrinterDPIType
 */
class EltronPrinterDPIType {
}}

if (!class_exists("NonDeliveryOption")) {
/**
 * NonDeliveryOption
 */
class NonDeliveryOption {
}}

if (!class_exists("CreateIndiciumResponse")) {
/**
 * CreateIndiciumResponse
 */
class CreateIndiciumResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxID;
    /**
     * @access public
     * @var tnsstring0128
     */
    public $TrackingNumber;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
    /**
     * @access public
     * @var s1guid
     */
    public $StampsTxID;
    /**
     * @access public
     * @var sstring
     */
    public $URL;
    /**
     * @access public
     * @var PostageBalance
     */
    public $PostageBalance;
    /**
     * @access public
     * @var sstring
     */
    public $Mac;
    /**
     * @access public
     * @var sstring
     */
    public $PostageHash;
}}

if (!class_exists("PostageBalance")) {
/**
 * PostageBalance
 */
class PostageBalance {
    /**
     * @access public
     * @var sdecimal
     */
    public $AvailablePostage;
    /**
     * @access public
     * @var sdecimal
     */
    public $ControlTotal;
}}

if (!class_exists("CreateTestIndicium")) {
/**
 * CreateTestIndicium
 */
class CreateTestIndicium {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
    /**
     * @access public
     * @var Address
     */
    public $From;
    /**
     * @access public
     * @var Address
     */
    public $To;
    /**
     * @access public
     * @var Customs
     */
    public $Customs;
    /**
     * @access public
     * @var tnsImageType
     */
    public $ImageType;
    /**
     * @access public
     * @var tnsEltronPrinterDPIType
     */
    public $EltronPrinterDPIType;
    /**
     * @access public
     * @var sint
     */
    public $rotationDegrees;
}}

if (!class_exists("CreateTestIndiciumResponse")) {
/**
 * CreateTestIndiciumResponse
 */
class CreateTestIndiciumResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
    /**
     * @access public
     * @var sstring
     */
    public $URL;
}}

if (!class_exists("CreateEnvelopeIndicium")) {
/**
 * CreateEnvelopeIndicium
 */
class CreateEnvelopeIndicium {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxID;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
    /**
     * @access public
     * @var Address
     */
    public $From;
    /**
     * @access public
     * @var Address
     */
    public $To;
    /**
     * @access public
     * @var tnsstring164
     */
    public $CustomerID;
    /**
     * @access public
     * @var tnsCreateIndiciumModeV1
     */
    public $Mode;
    /**
     * @access public
     * @var tnsImageType
     */
    public $ImageType;
    /**
     * @access public
     * @var sint
     */
    public $CostCodeId;
    /**
     * @access public
     * @var sboolean
     */
    public $HideFIM;
}}

if (!class_exists("CreateIndiciumModeV1")) {
/**
 * CreateIndiciumModeV1
 */
class CreateIndiciumModeV1 {
}}

if (!class_exists("CreateEnvelopeIndiciumResponse")) {
/**
 * CreateEnvelopeIndiciumResponse
 */
class CreateEnvelopeIndiciumResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxID;
    /**
     * @access public
     * @var tnsstring0128
     */
    public $TrackingNumber;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
    /**
     * @access public
     * @var s1guid
     */
    public $StampsTxID;
    /**
     * @access public
     * @var sstring
     */
    public $URL;
    /**
     * @access public
     * @var PostageBalance
     */
    public $PostageBalance;
    /**
     * @access public
     * @var sstring
     */
    public $Mac;
    /**
     * @access public
     * @var sstring
     */
    public $PostageHash;
}}

if (!class_exists("CreateNetStampsIndicia")) {
/**
 * CreateNetStampsIndicia
 */
class CreateNetStampsIndicia {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxId;
    /**
     * @access public
     * @var tnsstring0128
     */
    public $Layout;
    /**
     * @access public
     * @var ArrayOfNetStampV5
     */
    public $NetStamps;
    /**
     * @access public
     * @var Address
     */
    public $From;
    /**
     * @access public
     * @var sboolean
     */
    public $SampleOnly;
    /**
     * @access public
     * @var tnsImageType
     */
    public $ImageType;
    /**
     * @access public
     * @var sint
     */
    public $cost_code_id;
    /**
     * @access public
     * @var sint
     */
    public $ImageId;
    /**
     * @access public
     * @var sboolean
     */
    public $ReturnIndiciaData;
}}

if (!class_exists("NetStampV5")) {
/**
 * NetStampV5
 */
class NetStampV5 {
    /**
     * @access public
     * @var sint
     */
    public $Row;
    /**
     * @access public
     * @var sint
     */
    public $Column;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
}}

if (!class_exists("CreateNetStampsIndiciaResponse")) {
/**
 * CreateNetStampsIndiciaResponse
 */
class CreateNetStampsIndiciaResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxId;
    /**
     * @access public
     * @var s1guid
     */
    public $StampsTxId;
    /**
     * @access public
     * @var sstring
     */
    public $URL;
    /**
     * @access public
     * @var PostageBalance
     */
    public $PostageBalance;
    /**
     * @access public
     * @var tnsNetstampsStatus
     */
    public $NetstampsStatus;
    /**
     * @access public
     * @var sint
     */
    public $NetstampsIssued;
    /**
     * @access public
     * @var sstring
     */
    public $ErrorReason;
    /**
     * @access public
     * @var sstring
     */
    public $Mac;
    /**
     * @access public
     * @var ArrayOfIndiciumData
     */
    public $IndiciaData;
}}

if (!class_exists("NetstampsStatus")) {
/**
 * NetstampsStatus
 */
class NetstampsStatus {
}}

if (!class_exists("IndiciumData")) {
/**
 * IndiciumData
 */
class IndiciumData {
    /**
     * @access public
     * @var sbase64Binary
     */
    public $IBI;
    /**
     * @access public
     * @var sbase64Binary
     */
    public $IBILite;
}}

if (!class_exists("CreateUnfundedIndicium")) {
/**
 * CreateUnfundedIndicium
 */
class CreateUnfundedIndicium {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxID;
    /**
     * @access public
     * @var tnsstring0128
     */
    public $TrackingNumber;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
    /**
     * @access public
     * @var Address
     */
    public $From;
    /**
     * @access public
     * @var Address
     */
    public $To;
    /**
     * @access public
     * @var tnsstring164
     */
    public $CustomerID;
    /**
     * @access public
     * @var Customs
     */
    public $Customs;
    /**
     * @access public
     * @var sboolean
     */
    public $SampleOnly;
    /**
     * @access public
     * @var tnsImageType
     */
    public $ImageType;
    /**
     * @access public
     * @var tnsEltronPrinterDPIType
     */
    public $EltronPrinterDPIType;
    /**
     * @access public
     * @var sstring
     */
    public $memo;
    /**
     * @access public
     * @var sint
     */
    public $cost_code_id;
    /**
     * @access public
     * @var sstring
     */
    public $recipient_email;
    /**
     * @access public
     * @var sboolean
     */
    public $deliveryNotification;
    /**
     * @access public
     * @var sboolean
     */
    public $shipmentNotificationCC;
    /**
     * @access public
     * @var sboolean
     */
    public $shipmentNotificationCCToMain;
    /**
     * @access public
     * @var sboolean
     */
    public $shipmentNotificationFromCompany;
    /**
     * @access public
     * @var sboolean
     */
    public $shipmentNotificationCompanyInSubject;
    /**
     * @access public
     * @var sint
     */
    public $rotationDegrees;
}}

if (!class_exists("CreateUnfundedIndiciumResponse")) {
/**
 * CreateUnfundedIndiciumResponse
 */
class CreateUnfundedIndiciumResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxID;
    /**
     * @access public
     * @var tnsstring0128
     */
    public $TrackingNumber;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
    /**
     * @access public
     * @var s1guid
     */
    public $StampsTxID;
    /**
     * @access public
     * @var sstring
     */
    public $URL;
    /**
     * @access public
     * @var PostageBalance
     */
    public $PostageBalance;
}}

if (!class_exists("GetRates")) {
/**
 * GetRates
 */
class GetRates {
    /**
     * @access public
     * @var sstring
     */
    //public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var RateV9
     */
    public $Rate;
}}

if (!class_exists("GetRatesResponse")) {
/**
 * GetRatesResponse
 */
class GetRatesResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var ArrayOfRateV9
     */
    public $Rates;
}}

if (!class_exists("ChangePassword")) {
/**
 * ChangePassword
 */
class ChangePassword {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $OldPassword;
    /**
     * @access public
     * @var sstring
     */
    public $NewPassword;
}}

if (!class_exists("ChangePasswordResponse")) {
/**
 * ChangePasswordResponse
 */
class ChangePasswordResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
}}

if (!class_exists("PriceOrder")) {
/**
 * PriceOrder
 */
class PriceOrder {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var ArrayOfSku
     */
    public $Skus;
    /**
     * @access public
     * @var sstring
     */
    public $PromoCode;
    /**
     * @access public
     * @var Address
     */
    public $ShippingAddress;
}}

if (!class_exists("Sku")) {
/**
 * Sku
 */
class Sku {
    /**
     * @access public
     * @var tnsstring1100
     */
    public $Id;
    /**
     * @access public
     * @var sint
     */
    public $Quantity;
    /**
     * @access public
     * @var sdecimal
     */
    public $SkuSubTotal;
}}

if (!class_exists("PriceOrderResponse")) {
/**
 * PriceOrderResponse
 */
class PriceOrderResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var ArrayOfStoreShippingMethodOption
     */
    public $StoreShippingMethodOptions;
}}

if (!class_exists("StoreShippingMethodOption")) {
/**
 * StoreShippingMethodOption
 */
class StoreShippingMethodOption {
    /**
     * @access public
     * @var tnsStoreShippingMethodType
     */
    public $StoreShippingMethod;
    /**
     * @access public
     * @var sint
     */
    public $StoreDeliveryTimeMinimum;
    /**
     * @access public
     * @var sint
     */
    public $StoreDeliveryTimeMaximum;
    /**
     * @access public
     * @var ArrayOfSku
     */
    public $Skus;
    /**
     * @access public
     * @var sdecimal
     */
    public $StoreProductTotal;
    /**
     * @access public
     * @var sdecimal
     */
    public $StoreProductDiscount;
    /**
     * @access public
     * @var sdecimal
     */
    public $StoreShippingAmount;
    /**
     * @access public
     * @var sdecimal
     */
    public $StoreTaxTotal;
    /**
     * @access public
     * @var sdecimal
     */
    public $StoreOrderTotal;
}}

if (!class_exists("StoreShippingMethodType")) {
/**
 * StoreShippingMethodType
 */
class StoreShippingMethodType {
}}

if (!class_exists("PlaceOrder")) {
/**
 * PlaceOrder
 */
class PlaceOrder {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var ArrayOfSku
     */
    public $Skus;
    /**
     * @access public
     * @var sstring
     */
    public $PromoCode;
    /**
     * @access public
     * @var Address
     */
    public $ShippingAddress;
    /**
     * @access public
     * @var tnsStoreShippingMethodType
     */
    public $StoreShippingMethod;
}}

if (!class_exists("PlaceOrderResponse")) {
/**
 * PlaceOrderResponse
 */
class PlaceOrderResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsstring050
     */
    public $StoreOrderId;
    /**
     * @access public
     * @var sdecimal
     */
    public $StoreOrderTotal;
}}

if (!class_exists("CleanseAddress")) {
/**
 * CleanseAddress
 */
class CleanseAddress {
    /**
     * @access public
     * @var sstring
     */
    //public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var Address
     */
    public $Address;
}}

if (!class_exists("CleanseAddressResponse")) {
/**
 * CleanseAddressResponse
 */
class CleanseAddressResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Address
     */
    public $Address;
    /**
     * @access public
     * @var sboolean
     */
    public $AddressMatch;
    /**
     * @access public
     * @var sboolean
     */
    public $CityStateZipOK;
    /**
     * @access public
     * @var tnsResidentialDeliveryIndicatorType
     */
    public $ResidentialDeliveryIndicator;
    /**
     * @access public
     * @var sboolean
     */
    public $IsPOBox;
    /**
     * @access public
     * @var ArrayOfAddress
     */
    public $CandidateAddresses;
}}

if (!class_exists("ResidentialDeliveryIndicatorType")) {
/**
 * ResidentialDeliveryIndicatorType
 */
class ResidentialDeliveryIndicatorType {
}}

if (!class_exists("GetNetStampsImages")) {
/**
 * GetNetStampsImages
 */
class GetNetStampsImages {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
}}

if (!class_exists("GetNetStampsImagesResponse")) {
/**
 * GetNetStampsImagesResponse
 */
class GetNetStampsImagesResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var ArrayOfNetStampsImage
     */
    public $NetStampsImages;
}}

if (!class_exists("NetStampsImage")) {
/**
 * NetStampsImage
 */
class NetStampsImage {
    /**
     * @access public
     * @var sstring
     */
    public $ImageName;
    /**
     * @access public
     * @var sint
     */
    public $ImageID;
    /**
     * @access public
     * @var sstring
     */
    public $ImageCategory;
    /**
     * @access public
     * @var sstring
     */
    public $ImageDescription;
    /**
     * @access public
     * @var sstring
     */
    public $ImageUrl;
    /**
     * @access public
     * @var sint
     */
    public $ImageIndex;
    /**
     * @access public
     * @var tnsNetStampsImageType
     */
    public $ImageType;
    /**
     * @access public
     * @var sboolean
     */
    public $PreviewOnly;
    /**
     * @access public
     * @var ArrayOfPlan
     */
    public $PlansUpgradeToPrintImage;
}}

if (!class_exists("NetStampsImageType")) {
/**
 * NetStampsImageType
 */
class NetStampsImageType {
}}

if (!class_exists("Plan")) {
/**
 * Plan
 */
class Plan {
    /**
     * @access public
     * @var sint
     */
    public $PlanId;
    /**
     * @access public
     * @var sstring
     */
    public $PlanName;
    /**
     * @access public
     * @var sdecimal
     */
    public $MonthlyBaseFee;
}}

if (!class_exists("ChangePlan")) {
/**
 * ChangePlan
 */
class ChangePlan {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sint
     */
    public $PlanId;
}}

if (!class_exists("ChangePlanResponse")) {
/**
 * ChangePlanResponse
 */
class ChangePlanResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsPurchaseStatus
     */
    public $PurchaseStatus;
    /**
     * @access public
     * @var sint
     */
    public $TransactionID;
    /**
     * @access public
     * @var sstring
     */
    public $RejectionReason;
}}

if (!class_exists("PurchaseStatus")) {
/**
 * PurchaseStatus
 */
class PurchaseStatus {
}}

if (!class_exists("GetChangePlanStatus")) {
/**
 * GetChangePlanStatus
 */
class GetChangePlanStatus {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sint
     */
    public $TransactionID;
}}

if (!class_exists("GetChangePlanStatusResponse")) {
/**
 * GetChangePlanStatusResponse
 */
class GetChangePlanStatusResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsPurchaseStatus
     */
    public $PurchaseStatus;
    /**
     * @access public
     * @var sstring
     */
    public $RejectionReason;
}}

if (!class_exists("CreateScanForm")) {
/**
 * CreateScanForm
 */
class CreateScanForm {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var ArrayOfGuid
     */
    public $StampsTxIDs;
    /**
     * @access public
     * @var from_address_v1
     */
    public $FromAddress;
    /**
     * @access public
     * @var tnsImageType
     */
    public $ImageType;
    /**
     * @access public
     * @var sboolean
     */
    public $PrintInstructions;
    /**
     * @access public
     * @var sdate
     */
    public $ShipDate;
}}

if (!class_exists("from_address_v1")) {
/**
 * from_address_v1
 */
class from_address_v1 {
    /**
     * @access public
     * @var sstring
     */
    public $name_;
    /**
     * @access public
     * @var sstring
     */
    public $title_;
    /**
     * @access public
     * @var sstring
     */
    public $dept_;
    /**
     * @access public
     * @var sstring
     */
    public $company_;
    /**
     * @access public
     * @var sstring
     */
    public $address_1_;
    /**
     * @access public
     * @var sstring
     */
    public $address_2_;
    /**
     * @access public
     * @var sstring
     */
    public $urbanization_;
    /**
     * @access public
     * @var sstring
     */
    public $city_;
    /**
     * @access public
     * @var sstring
     */
    public $state_;
    /**
     * @access public
     * @var sstring
     */
    public $zip_code_;
    /**
     * @access public
     * @var sstring
     */
    public $zip_code_add_on_;
    /**
     * @access public
     * @var sstring
     */
    public $phone_number_;
}}

if (!class_exists("CreateScanFormResponse")) {
/**
 * CreateScanFormResponse
 */
class CreateScanFormResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sstring
     */
    public $ScanFormId;
    /**
     * @access public
     * @var sstring
     */
    public $Url;
}}

if (!class_exists("PurchasePostage")) {
/**
 * PurchasePostage
 */
class PurchasePostage {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    //public $Authenticator;
    /**
     * @access public
     * @var sdecimal
     */
    public $PurchaseAmount;
    /**
     * @access public
     * @var sdecimal
     */
    public $ControlTotal;
    /**
     * @access public
     * @var MachineInfo
     */
    public $MI;
    /**
     * @access public
     * @var tnsstring1128
     */
    public $IntegratorTxID;
}}

if (!class_exists("MachineInfo")) {
/**
 * MachineInfo
 */
class MachineInfo {
    /**
     * @access public
     * @var tnsstring015
     */
    public $IPAddress;
    /**
     * @access public
     * @var tnsstring012
     */
    public $MacAddress;
    /**
     * @access public
     * @var FP
     */
    public $FP;
}}

if (!class_exists("FP")) {
/**
 * FP
 */
class FP {
    /**
     * @access public
     * @var sbase64Binary
     */
    public $FP1;
    /**
     * @access public
     * @var sbase64Binary
     */
    public $FP2;
    /**
     * @access public
     * @var sbase64Binary
     */
    public $FP3;
    /**
     * @access public
     * @var sbase64Binary
     */
    public $FP4;
    /**
     * @access public
     * @var sbase64Binary
     */
    public $FP5;
}}

if (!class_exists("PurchasePostageResponse")) {
/**
 * PurchasePostageResponse
 */
class PurchasePostageResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsPurchaseStatus
     */
    public $PurchaseStatus;
    /**
     * @access public
     * @var sint
     */
    public $TransactionID;
    /**
     * @access public
     * @var PostageBalance
     */
    public $PostageBalance;
    /**
     * @access public
     * @var sstring
     */
    public $RejectionReason;
    /**
     * @access public
     * @var sboolean
     */
    public $MIRequired;
}}

if (!class_exists("ResubmitPurchase")) {
/**
 * ResubmitPurchase
 */
class ResubmitPurchase {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sstring
     */
    public $ResubmitCookie;
}}

if (!class_exists("ResubmitPurchaseResponse")) {
/**
 * ResubmitPurchaseResponse
 */
class ResubmitPurchaseResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sint
     */
    public $TransactionID;
    /**
     * @access public
     * @var sdecimal
     */
    public $ChargedAmount;
    /**
     * @access public
     * @var sdecimal
     */
    public $PendingAmount;
    /**
     * @access public
     * @var sint
     */
    public $WaitIntervalSeconds;
    /**
     * @access public
     * @var tnsPurchaseStatus
     */
    public $PurchaseStatus;
    /**
     * @access public
     * @var sstring
     */
    public $RejectionReason;
}}

if (!class_exists("CarrierPickup")) {
/**
 * CarrierPickup
 */
class CarrierPickup {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var tnsstring150
     */
    public $FirstName;
    /**
     * @access public
     * @var tnsstring150
     */
    public $LastName;
    /**
     * @access public
     * @var tnsstring050
     */
    public $Company;
    /**
     * @access public
     * @var tnsstring150
     */
    public $Address;
    /**
     * @access public
     * @var tnsstring010
     */
    public $SuiteOrApt;
    /**
     * @access public
     * @var tnsstring130
     */
    public $City;
    /**
     * @access public
     * @var tnsstring22
     */
    public $State;
    /**
     * @access public
     * @var tnsstring55
     */
    public $ZIP;
    /**
     * @access public
     * @var tnsstring04
     */
    public $ZIP4;
    /**
     * @access public
     * @var tnsstring1010
     */
    public $PhoneNumber;
    /**
     * @access public
     * @var tnsstring06
     */
    public $PhoneExt;
    /**
     * @access public
     * @var sint
     */
    public $NumberOfExpressMailPieces;
    /**
     * @access public
     * @var sint
     */
    public $NumberOfPriorityMailPieces;
    /**
     * @access public
     * @var sint
     */
    public $NumberOfInternationalPieces;
    /**
     * @access public
     * @var sint
     */
    public $NumberOfOtherPieces;
    /**
     * @access public
     * @var sint
     */
    public $TotalWeightOfPackagesLbs;
    /**
     * @access public
     * @var tnsCarrierPickupLocationV1
     */
    public $PackageLocation;
    /**
     * @access public
     * @var sstring
     */
    public $SpecialInstruction;
}}

if (!class_exists("CarrierPickupLocationV1")) {
/**
 * CarrierPickupLocationV1
 */
class CarrierPickupLocationV1 {
}}

if (!class_exists("CarrierPickupResponse")) {
/**
 * CarrierPickupResponse
 */
class CarrierPickupResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sstring
     */
    public $ErrorMsg;
    /**
     * @access public
     * @var sstring
     */
    public $PickupDate;
    /**
     * @access public
     * @var sstring
     */
    public $PickUpDayOfWeek;
    /**
     * @access public
     * @var sstring
     */
    public $ConfirmationNumber;
}}

if (!class_exists("GetURL")) {
/**
 * GetURL
 */
class GetURL {
    /**
     * @access public
     * @var sstring
     */
    //public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var tnsUrlType
     */
    public $URLType;
    /**
     * @access public
     * @var sstring
     */
    public $ApplicationContext;
}}

if (!class_exists("UrlType")) {
/**
 * UrlType
 */
class UrlType {
}}

if (!class_exists("GetURLResponse")) {
/**
 * GetURLResponse
 */
class GetURLResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sstring
     */
    public $URL;
}}

if (!class_exists("EnumNetStampsLayouts")) {
/**
 * EnumNetStampsLayouts
 */
class EnumNetStampsLayouts {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
}}

if (!class_exists("EnumNetStampsLayoutsResponse")) {
/**
 * EnumNetStampsLayoutsResponse
 */
class EnumNetStampsLayoutsResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var ArrayOfNetStampsLayout
     */
    public $Layouts;
}}

if (!class_exists("NetStampsLayout")) {
/**
 * NetStampsLayout
 */
class NetStampsLayout {
    /**
     * @access public
     * @var sstring
     */
    public $Name;
    /**
     * @access public
     * @var sstring
     */
    public $Description;
    /**
     * @access public
     * @var sstring
     */
    public $SerialNumberPattern;
    /**
     * @access public
     * @var sint
     */
    public $NumRows;
    /**
     * @access public
     * @var sint
     */
    public $NumColumns;
    /**
     * @access public
     * @var sstring
     */
    public $BackgroundImageURL;
    /**
     * @access public
     * @var sint
     */
    public $BackgroundImageWidthPx;
    /**
     * @access public
     * @var sint
     */
    public $BackgroundImageHeightPx;
    /**
     * @access public
     * @var sstring
     */
    public $EmptyNetStampImageURL;
    /**
     * @access public
     * @var sstring
     */
    public $UsedNetStampImageURL;
    /**
     * @access public
     * @var sstring
     */
    public $PrintedNetStampImageURL;
    /**
     * @access public
     * @var sint
     */
    public $NetStampImageWidthPx;
    /**
     * @access public
     * @var sint
     */
    public $NetStampImageHeightPx;
    /**
     * @access public
     * @var sint
     */
    public $Row1StartsAtPx;
    /**
     * @access public
     * @var sint
     */
    public $Column1StartsAtPx;
    /**
     * @access public
     * @var sint
     */
    public $HorizontalSpaceBetweenNetStampsPx;
    /**
     * @access public
     * @var sint
     */
    public $VerticalSpaceBetweenNetStampsPx;
}}

if (!class_exists("EnumCostCodes")) {
/**
 * EnumCostCodes
 */
class EnumCostCodes {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
}}

if (!class_exists("EnumCostCodesResponse")) {
/**
 * EnumCostCodesResponse
 */
class EnumCostCodesResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var ArrayOfCost_code_info_v1
     */
    public $CostCodes;
}}

if (!class_exists("cost_code_info_v1")) {
/**
 * cost_code_info_v1
 */
class cost_code_info_v1 {
    /**
     * @access public
     * @var sunsignedInt
     */
    public $id;
    /**
     * @access public
     * @var tnsstring030
     */
    public $name;
}}

if (!class_exists("AuthenticateWithTransferAuthenticator")) {
/**
 * AuthenticateWithTransferAuthenticator
 */
class AuthenticateWithTransferAuthenticator {
    /**
     * @access public
     * @var s1guid
     */
    public $integrationID;
    /**
     * @access public
     * @var sstring
     */
    public $transferAuthenticator;
}}

if (!class_exists("AuthenticateWithTransferAuthenticatorResponse")) {
/**
 * AuthenticateWithTransferAuthenticatorResponse
 */
class AuthenticateWithTransferAuthenticatorResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
}}

if (!class_exists("CancelIndicium")) {
/**
 * CancelIndicium
 */
class CancelIndicium {
    /**
     * @access public
     * @var sstring
     */
    //public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var s1guid
     */
    public $StampsTxID;
    /**
     * @access public
     * @var sstring
     */
    public $TrackingNumber;
}}

if (!class_exists("CancelIndiciumResponse")) {
/**
 * CancelIndiciumResponse
 */
class CancelIndiciumResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
}}

if (!class_exists("StartPasswordReset")) {
/**
 * StartPasswordReset
 */
class StartPasswordReset {
    /**
     * @access public
     * @var tnsstring040
     */
    public $Username;
    /**
     * @access public
     * @var tnsstring040
     */
    public $Codeword1;
    /**
     * @access public
     * @var tnsstring040
     */
    public $Codeword2;
    /**
     * @access public
     * @var s1guid
     */
    public $IntegrationId;
}}

if (!class_exists("StartPasswordResetResponse")) {
/**
 * StartPasswordResetResponse
 */
class StartPasswordResetResponse {
}}

if (!class_exists("FinishPasswordReset")) {
/**
 * FinishPasswordReset
 */
class FinishPasswordReset {
    /**
     * @access public
     * @var tnsstring140
     */
    public $Username;
    /**
     * @access public
     * @var sstring
     */
    public $TempPassword;
    /**
     * @access public
     * @var sstring
     */
    public $NewPassword;
    /**
     * @access public
     * @var s1guid
     */
    public $IntegrationId;
}}

if (!class_exists("FinishPasswordResetResponse")) {
/**
 * FinishPasswordResetResponse
 */
class FinishPasswordResetResponse {
}}

if (!class_exists("GetCodewordQuestions")) {
/**
 * GetCodewordQuestions
 */
class GetCodewordQuestions {
    /**
     * @access public
     * @var tnsstring040
     */
    public $Username;
    /**
     * @access public
     * @var s1guid
     */
    public $IntegrationId;
}}

if (!class_exists("GetCodewordQuestionsResponse")) {
/**
 * GetCodewordQuestionsResponse
 */
class GetCodewordQuestionsResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Codeword1Question;
    /**
     * @access public
     * @var sstring
     */
    public $Codeword2Question;
}}

if (!class_exists("RegisterAccount")) {
/**
 * RegisterAccount
 */
class RegisterAccount {
    /**
     * @access public
     * @var s1guid
     */
    public $IntegrationID;
    /**
     * @access public
     * @var tnsstring040
     */
    public $UserName;
    /**
     * @access public
     * @var tnsstring620
     */
    public $Password;
    /**
     * @access public
     * @var tnsCodewordType
     */
    public $Codeword1Type;
    /**
     * @access public
     * @var tnsstring22147483647
     */
    public $Codeword1;
    /**
     * @access public
     * @var tnsCodewordType
     */
    public $Codeword2Type;
    /**
     * @access public
     * @var tnsstring22147483647
     */
    public $Codeword2;
    /**
     * @access public
     * @var Address
     */
    public $PhysicalAddress;
    /**
     * @access public
     * @var Address
     */
    public $MailingAddress;
    /**
     * @access public
     * @var MachineInfo
     */
    public $MachineInfo;
    /**
     * @access public
     * @var tnsstring041
     */
    public $Email;
    /**
     * @access public
     * @var tnsAccountType
     */
    public $AccountType;
    /**
     * @access public
     * @var tnsstring050
     */
    public $PromoCode;
    /**
     * @access public
     * @var CreditCard
     */
    public $CreditCard;
    /**
     * @access public
     * @var AchAccount
     */
    public $AchAccount;
}}

if (!class_exists("CodewordType")) {
/**
 * CodewordType
 */
class CodewordType {
}}

if (!class_exists("AccountType")) {
/**
 * AccountType
 */
class AccountType {
}}

if (!class_exists("CreditCard")) {
/**
 * CreditCard
 */
class CreditCard {
    /**
     * @access public
     * @var tnsCreditCardType
     */
    public $CreditCardType;
    /**
     * @access public
     * @var sstring
     */
    public $AccountNumber;
    /**
     * @access public
     * @var sstring
     */
    public $CVN;
    /**
     * @access public
     * @var sdateTime
     */
    public $ExpirationDate;
    /**
     * @access public
     * @var Address
     */
    public $BillingAddress;
}}

if (!class_exists("CreditCardType")) {
/**
 * CreditCardType
 */
class CreditCardType {
}}

if (!class_exists("AchAccount")) {
/**
 * AchAccount
 */
class AchAccount {
    /**
     * @access public
     * @var tnsAchAccountType
     */
    public $AchAccountType;
    /**
     * @access public
     * @var sstring
     */
    public $BankName;
    /**
     * @access public
     * @var sstring
     */
    public $AccountNumber;
    /**
     * @access public
     * @var sstring
     */
    public $RouteID;
    /**
     * @access public
     * @var sstring
     */
    public $AccountHolderName;
}}

if (!class_exists("AchAccountType")) {
/**
 * AchAccountType
 */
class AchAccountType {
}}

if (!class_exists("RegisterAccountResponse")) {
/**
 * RegisterAccountResponse
 */
class RegisterAccountResponse {
    /**
     * @access public
     * @var tnsRegistrationStatus
     */
    public $RegistrationStatus;
    /**
     * @access public
     * @var sstring
     */
    public $SuggestedUserName;
    /**
     * @access public
     * @var sint
     */
    public $UserId;
    /**
     * @access public
     * @var sstring
     */
    public $PromoUrl;
}}

if (!class_exists("RegistrationStatus")) {
/**
 * RegistrationStatus
 */
class RegistrationStatus {
}}

if (!class_exists("VoidUnfundedIndicium")) {
/**
 * VoidUnfundedIndicium
 */
class VoidUnfundedIndicium {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var s1guid
     */
    public $StampsTxID;
}}

if (!class_exists("VoidUnfundedIndiciumResponse")) {
/**
 * VoidUnfundedIndiciumResponse
 */
class VoidUnfundedIndiciumResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
}}

if (!class_exists("FundUnfundedIndicium")) {
/**
 * FundUnfundedIndicium
 */
class FundUnfundedIndicium {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var s1guid
     */
    public $StampsTxID;
}}

if (!class_exists("FundUnfundedIndiciumResponse")) {
/**
 * FundUnfundedIndiciumResponse
 */
class FundUnfundedIndiciumResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
}}

if (!class_exists("AuthenticateUser")) {
/**
 * AuthenticateUser
 */
class AuthenticateUser {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
}}

if (!class_exists("AuthenticateUserResponse")) {
/**
 * AuthenticateUserResponse
 */
class AuthenticateUserResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sdateTime
     */
    public $LastLoginTime;
    /**
     * @access public
     * @var sboolean
     */
    public $ClearCredential;
    /**
     * @access public
     * @var sstring
     */
    public $LoginBannerText;
    /**
     * @access public
     * @var sboolean
     */
    public $PasswordExpired;
}}

if (!class_exists("GetAccountInfo")) {
/**
 * GetAccountInfo
 */
class GetAccountInfo {
    /**
     * @access public
     * @var sstring
     */
    //public $Authenticator;
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
}}

if (!class_exists("GetAccountInfoResponse")) {
/**
 * GetAccountInfoResponse
 */
class GetAccountInfoResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var AccountInfo
     */
    public $AccountInfo;
    /**
     * @access public
     * @var Address
     */
    public $Address;
    /**
     * @access public
     * @var sstring
     */
    public $CustomerEmail;
}}

if (!class_exists("AccountInfo")) {
/**
 * AccountInfo
 */
class AccountInfo {
    /**
     * @access public
     * @var sint
     */
    public $CustomerID;
    /**
     * @access public
     * @var sint
     */
    public $MeterNumber;
    /**
     * @access public
     * @var sint
     */
    public $UserID;
    /**
     * @access public
     * @var PostageBalance
     */
    public $PostageBalance;
    /**
     * @access public
     * @var sdecimal
     */
    public $MaxPostageBalance;
    /**
     * @access public
     * @var tnsstring029
     */
    public $LPOCity;
    /**
     * @access public
     * @var tnsstring03
     */
    public $LPOState;
    /**
     * @access public
     * @var tnsstring06
     */
    public $LPOZip;
    /**
     * @access public
     * @var slong
     */
    public $AccountId;
    /**
     * @access public
     * @var sint
     */
    public $CorpID;
    /**
     * @access public
     * @var sstring
     */
    public $StoreID;
    /**
     * @access public
     * @var sint
     */
    public $CostCodeLimit;
    /**
     * @access public
     * @var sint
     */
    public $MeterBalanceLimit;
    /**
     * @access public
     * @var sint
     */
    public $MonthlyPostagePurchaseLimit;
    /**
     * @access public
     * @var sint
     */
    public $MaxUsers;
    /**
     * @access public
     * @var CapabilitiesV5
     */
    public $Capabilities;
    /**
     * @access public
     * @var Address
     */
    public $MeterPhysicalAddress;
    /**
     * @access public
     * @var tnsResubmissionStatus
     */
    public $ResubmitStatus;
    /**
     * @access public
     * @var sstring
     */
    public $ResubmitCookie;
    /**
     * @access public
     * @var sint
     */
    public $PlanID;
    /**
     * @access public
     * @var sint
     */
    public $PendingPlanId;
}}

if (!class_exists("Capabilities")) {
/**
 * Capabilities
 */
class Capabilities {
    /**
     * @access public
     * @var sboolean
     */
    public $CanPrintShipping;
    /**
     * @access public
     * @var sboolean
     */
    public $CanUseCostCodes;
    /**
     * @access public
     * @var sboolean
     */
    public $CanUseHiddenPostage;
    /**
     * @access public
     * @var sboolean
     */
    public $CanPurchaseSDCInsurance;
    /**
     * @access public
     * @var sboolean
     */
    public $CanPrintMemoOnShippingLabel;
    /**
     * @access public
     * @var sboolean
     */
    public $CanPrintInternational;
    /**
     * @access public
     * @var sboolean
     */
    public $CanPurchasePostage;
    /**
     * @access public
     * @var sboolean
     */
    public $CanEditCostCodes;
    /**
     * @access public
     * @var sboolean
     */
    public $MustUseCostCodes;
    /**
     * @access public
     * @var sboolean
     */
    public $CanViewOnlineReports;
    /**
     * @access public
     * @var sdecimal
     */
    public $PerPrintLimit;
}}

if (!class_exists("ResubmissionStatus")) {
/**
 * ResubmissionStatus
 */
class ResubmissionStatus {
}}

if (!class_exists("GetPurchaseStatus")) {
/**
 * GetPurchaseStatus
 */
class GetPurchaseStatus {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sint
     */
    public $TransactionID;
}}

if (!class_exists("GetPurchaseStatusResponse")) {
/**
 * GetPurchaseStatusResponse
 */
class GetPurchaseStatusResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var tnsPurchaseStatus
     */
    public $PurchaseStatus;
    /**
     * @access public
     * @var PostageBalance
     */
    public $PostageBalance;
    /**
     * @access public
     * @var sstring
     */
    public $RejectionReason;
    /**
     * @access public
     * @var sboolean
     */
    public $MIRequired;
}}

if (!class_exists("TrackShipment")) {
/**
 * TrackShipment
 */
class TrackShipment {
    /**
     * @access public
     * @var Credentials
     */
    public $Credentials;
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var sstring
     */
    public $TrackingNumber;
    /**
     * @access public
     * @var s1guid
     */
    public $StampsTxID;
}}

if (!class_exists("TrackShipmentResponse")) {
/**
 * TrackShipmentResponse
 */
class TrackShipmentResponse {
    /**
     * @access public
     * @var sstring
     */
    public $Authenticator;
    /**
     * @access public
     * @var ArrayOfTrackingEvent
     */
    public $TrackingEvents;
}}

if (!class_exists("TrackingEvent")) {
/**
 * TrackingEvent
 */
class TrackingEvent {
    /**
     * @access public
     * @var sdateTime
     */
    public $Timestamp;
    /**
     * @access public
     * @var sstring
     */
    public $Event;
    /**
     * @access public
     * @var tnsTrackingEventType
     */
    public $TrackingEventType;
    /**
     * @access public
     * @var sstring
     */
    public $City;
    /**
     * @access public
     * @var sstring
     */
    public $State;
    /**
     * @access public
     * @var sstring
     */
    public $Zip;
    /**
     * @access public
     * @var sstring
     */
    public $Country;
    /**
     * @access public
     * @var sstring
     */
    public $SignedBy;
    /**
     * @access public
     * @var sboolean
     */
    public $AuthorizedAgent;
}}

if (!class_exists("TrackingEventType")) {
/**
 * TrackingEventType
 */
class TrackingEventType {
}}

if (!class_exists("string1128")) {
/**
 * string1128
 */
class string1128 {
}}

if (!class_exists("string0128")) {
/**
 * string0128
 */
class string0128 {
}}

if (!class_exists("string310")) {
/**
 * string310
 */
class string310 {
}}

if (!class_exists("string22")) {
/**
 * string22
 */
class string22 {
}}

if (!class_exists("doublele999")) {
/**
 * doublele999
 */
class doublele999 {
}}

if (!class_exists("string050")) {
/**
 * string050
 */
class string050 {
}}

if (!class_exists("string12147483647")) {
/**
 * string12147483647
 */
class string12147483647 {
}}

if (!class_exists("string150")) {
/**
 * string150
 */
class string150 {
}}

if (!class_exists("string02")) {
/**
 * string02
 */
class string02 {
}}

if (!class_exists("string05")) {
/**
 * string05
 */
class string05 {
}}

if (!class_exists("string04")) {
/**
 * string04
 */
class string04 {
}}

if (!class_exists("string028")) {
/**
 * string028
 */
class string028 {
}}

if (!class_exists("string164")) {
/**
 * string164
 */
class string164 {
}}

if (!class_exists("string076")) {
/**
 * string076
 */
class string076 {
}}

if (!class_exists("string06")) {
/**
 * string06
 */
class string06 {
}}

if (!class_exists("string08")) {
/**
 * string08
 */
class string08 {
}}

if (!class_exists("string015")) {
/**
 * string015
 */
class string015 {
}}

if (!class_exists("string020")) {
/**
 * string020
 */
class string020 {
}}

if (!class_exists("string160")) {
/**
 * string160
 */
class string160 {
}}

if (!class_exists("doublege1")) {
/**
 * doublege1
 */
class doublege1 {
}}

if (!class_exists("decimalge0")) {
/**
 * decimalge0
 */
class decimalge0 {
}}

if (!class_exists("string029")) {
/**
 * string029
 */
class string029 {
}}

if (!class_exists("string03")) {
/**
 * string03
 */
class string03 {
}}

if (!class_exists("string1100")) {
/**
 * string1100
 */
class string1100 {
}}

if (!class_exists("string012")) {
/**
 * string012
 */
class string012 {
}}

if (!class_exists("string010")) {
/**
 * string010
 */
class string010 {
}}

if (!class_exists("string130")) {
/**
 * string130
 */
class string130 {
}}

if (!class_exists("string55")) {
/**
 * string55
 */
class string55 {
}}

if (!class_exists("string1010")) {
/**
 * string1010
 */
class string1010 {
}}

if (!class_exists("string030")) {
/**
 * string030
 */
class string030 {
}}

if (!class_exists("string040")) {
/**
 * string040
 */
class string040 {
}}

if (!class_exists("string140")) {
/**
 * string140
 */
class string140 {
}}

if (!class_exists("string620")) {
/**
 * string620
 */
class string620 {
}}

if (!class_exists("string22147483647")) {
/**
 * string22147483647
 */
class string22147483647 {
}}

if (!class_exists("string041")) {
/**
 * string041
 */
class string041 {
}}

if (!class_exists("guid")) {
/**
 * guid
 */
class guid {
}}

if (!class_exists("CapabilitiesV2")) {
/**
 * CapabilitiesV2
 */
class CapabilitiesV2 extends Capabilities {
    /**
     * @access public
     * @var sboolean
     */
    public $AllowAllMailClasses;
}}

if (!class_exists("CapabilitiesV3")) {
/**
 * CapabilitiesV3
 */
class CapabilitiesV3 extends CapabilitiesV2 {
    /**
     * @access public
     * @var sboolean
     */
    public $CanPrintReturnShippingLabel;
    /**
     * @access public
     * @var sboolean
     */
    public $CanManageUsers;
    /**
     * @access public
     * @var sboolean
     */
    public $CanPrintNetStamps;
    /**
     * @access public
     * @var sboolean
     */
    public $CanEmailNotifications;
    /**
     * @access public
     * @var sboolean
     */
    public $CanViewReports;
    /**
     * @access public
     * @var sboolean
     */
    public $CanCreateSCANForm;
    /**
     * @access public
     * @var sboolean
     */
    public $AllowRestrictedSheets;
    /**
     * @access public
     * @var sboolean
     */
    public $HideUnavailableFeatures;
    /**
     * @access public
     * @var sboolean
     */
    public $WebPostage;
    /**
     * @access public
     * @var sboolean
     */
    public $CanViewInsuranceHistory;
    /**
     * @access public
     * @var sboolean
     */
    public $CanChangeServicePlan;
    /**
     * @access public
     * @var sboolean
     */
    public $HideEstimatedDeliveryTime;
    /**
     * @access public
     * @var sboolean
     */
    public $CanPurchaseFromStore;
    /**
     * @access public
     * @var sboolean
     */
    public $CanChangePhysicalAddress;
    /**
     * @access public
     * @var sboolean
     */
    public $CanChangePaymentMethod;
    /**
     * @access public
     * @var sboolean
     */
    public $CanChangeContactInfo;
    /**
     * @access public
     * @var sboolean
     */
    public $CanViewAdvancedReporting;
}}

if (!class_exists("CapabilitiesV4")) {
/**
 * CapabilitiesV4
 */
class CapabilitiesV4 extends CapabilitiesV3 {
    /**
     * @access public
     * @var sboolean
     */
    public $IsIBIPEnabled;
}}

if (!class_exists("CapabilitiesV5")) {
/**
 * CapabilitiesV5
 */
class CapabilitiesV5 extends CapabilitiesV4 {
    /**
     * @access public
     * @var sboolean
     */
    public $CanCreateCriticalMail;
}}

if (!class_exists("SwsimV24")) {
/**
 * SwsimV24
 * @author WSDLInterpreter
 */
class SwsimV24 extends SoapClient {
    /**
     * Default class map for wsdl=>php
     * @access private
     * @var array
     */
    private static $classmap = array(
        "CreateIndicium" => "CreateIndicium",
        "Credentials" => "Credentials",
        "RateV9" => "RateV9",
        "ServiceType" => "ServiceType",
        "PackageTypeV6" => "PackageTypeV6",
        "AddOnTypeV2" => "AddOnTypeV2",
        "AddOnV2" => "AddOnV2",
        "Address" => "Address",
        "Customs" => "Customs",
        "ContentType" => "ContentType",
        "CustomsLine" => "CustomsLine",
        "ImageType" => "ImageType",
        "EltronPrinterDPIType" => "EltronPrinterDPIType",
        "NonDeliveryOption" => "NonDeliveryOption",
        "CreateIndiciumResponse" => "CreateIndiciumResponse",
        "PostageBalance" => "PostageBalance",
        "CreateTestIndicium" => "CreateTestIndicium",
        "CreateTestIndiciumResponse" => "CreateTestIndiciumResponse",
        "CreateEnvelopeIndicium" => "CreateEnvelopeIndicium",
        "CreateIndiciumModeV1" => "CreateIndiciumModeV1",
        "CreateEnvelopeIndiciumResponse" => "CreateEnvelopeIndiciumResponse",
        "CreateNetStampsIndicia" => "CreateNetStampsIndicia",
        "NetStampV5" => "NetStampV5",
        "CreateNetStampsIndiciaResponse" => "CreateNetStampsIndiciaResponse",
        "NetstampsStatus" => "NetstampsStatus",
        "IndiciumData" => "IndiciumData",
        "CreateUnfundedIndicium" => "CreateUnfundedIndicium",
        "CreateUnfundedIndiciumResponse" => "CreateUnfundedIndiciumResponse",
        "GetRates" => "GetRates",
        "GetRatesResponse" => "GetRatesResponse",
        "ChangePassword" => "ChangePassword",
        "ChangePasswordResponse" => "ChangePasswordResponse",
        "PriceOrder" => "PriceOrder",
        "Sku" => "Sku",
        "PriceOrderResponse" => "PriceOrderResponse",
        "StoreShippingMethodOption" => "StoreShippingMethodOption",
        "StoreShippingMethodType" => "StoreShippingMethodType",
        "PlaceOrder" => "PlaceOrder",
        "PlaceOrderResponse" => "PlaceOrderResponse",
        "CleanseAddress" => "CleanseAddress",
        "CleanseAddressResponse" => "CleanseAddressResponse",
        "ResidentialDeliveryIndicatorType" => "ResidentialDeliveryIndicatorType",
        "GetNetStampsImages" => "GetNetStampsImages",
        "GetNetStampsImagesResponse" => "GetNetStampsImagesResponse",
        "NetStampsImage" => "NetStampsImage",
        "NetStampsImageType" => "NetStampsImageType",
        "Plan" => "Plan",
        "ChangePlan" => "ChangePlan",
        "ChangePlanResponse" => "ChangePlanResponse",
        "PurchaseStatus" => "PurchaseStatus",
        "GetChangePlanStatus" => "GetChangePlanStatus",
        "GetChangePlanStatusResponse" => "GetChangePlanStatusResponse",
        "CreateScanForm" => "CreateScanForm",
        "from_address_v1" => "from_address_v1",
        "CreateScanFormResponse" => "CreateScanFormResponse",
        "PurchasePostage" => "PurchasePostage",
        "MachineInfo" => "MachineInfo",
        "FP" => "FP",
        "PurchasePostageResponse" => "PurchasePostageResponse",
        "ResubmitPurchase" => "ResubmitPurchase",
        "ResubmitPurchaseResponse" => "ResubmitPurchaseResponse",
        "CarrierPickup" => "CarrierPickup",
        "CarrierPickupLocationV1" => "CarrierPickupLocationV1",
        "CarrierPickupResponse" => "CarrierPickupResponse",
        "GetURL" => "GetURL",
        "UrlType" => "UrlType",
        "GetURLResponse" => "GetURLResponse",
        "EnumNetStampsLayouts" => "EnumNetStampsLayouts",
        "EnumNetStampsLayoutsResponse" => "EnumNetStampsLayoutsResponse",
        "NetStampsLayout" => "NetStampsLayout",
        "EnumCostCodes" => "EnumCostCodes",
        "EnumCostCodesResponse" => "EnumCostCodesResponse",
        "cost_code_info_v1" => "cost_code_info_v1",
        "AuthenticateWithTransferAuthenticator" => "AuthenticateWithTransferAuthenticator",
        "AuthenticateWithTransferAuthenticatorResponse" => "AuthenticateWithTransferAuthenticatorResponse",
        "CancelIndicium" => "CancelIndicium",
        "CancelIndiciumResponse" => "CancelIndiciumResponse",
        "StartPasswordReset" => "StartPasswordReset",
        "StartPasswordResetResponse" => "StartPasswordResetResponse",
        "FinishPasswordReset" => "FinishPasswordReset",
        "FinishPasswordResetResponse" => "FinishPasswordResetResponse",
        "GetCodewordQuestions" => "GetCodewordQuestions",
        "GetCodewordQuestionsResponse" => "GetCodewordQuestionsResponse",
        "RegisterAccount" => "RegisterAccount",
        "CodewordType" => "CodewordType",
        "AccountType" => "AccountType",
        "CreditCard" => "CreditCard",
        "CreditCardType" => "CreditCardType",
        "AchAccount" => "AchAccount",
        "AchAccountType" => "AchAccountType",
        "RegisterAccountResponse" => "RegisterAccountResponse",
        "RegistrationStatus" => "RegistrationStatus",
        "VoidUnfundedIndicium" => "VoidUnfundedIndicium",
        "VoidUnfundedIndiciumResponse" => "VoidUnfundedIndiciumResponse",
        "FundUnfundedIndicium" => "FundUnfundedIndicium",
        "FundUnfundedIndiciumResponse" => "FundUnfundedIndiciumResponse",
        "AuthenticateUser" => "AuthenticateUser",
        "AuthenticateUserResponse" => "AuthenticateUserResponse",
        "GetAccountInfo" => "GetAccountInfo",
        "GetAccountInfoResponse" => "GetAccountInfoResponse",
        "AccountInfo" => "AccountInfo",
        "CapabilitiesV5" => "CapabilitiesV5",
        "CapabilitiesV4" => "CapabilitiesV4",
        "CapabilitiesV3" => "CapabilitiesV3",
        "CapabilitiesV2" => "CapabilitiesV2",
        "Capabilities" => "Capabilities",
        "ResubmissionStatus" => "ResubmissionStatus",
        "GetPurchaseStatus" => "GetPurchaseStatus",
        "GetPurchaseStatusResponse" => "GetPurchaseStatusResponse",
        "TrackShipment" => "TrackShipment",
        "TrackShipmentResponse" => "TrackShipmentResponse",
        "TrackingEvent" => "TrackingEvent",
        "TrackingEventType" => "TrackingEventType",
        "string1128" => "string1128",
        "string0128" => "string0128",
        "string310" => "string310",
        "string22" => "string22",
        "doublele999" => "doublele999",
        "string050" => "string050",
        "string12147483647" => "string12147483647",
        "string150" => "string150",
        "string02" => "string02",
        "string05" => "string05",
        "string04" => "string04",
        "string028" => "string028",
        "string164" => "string164",
        "string076" => "string076",
        "string06" => "string06",
        "string08" => "string08",
        "string015" => "string015",
        "string020" => "string020",
        "string160" => "string160",
        "doublege1" => "doublege1",
        "decimalge0" => "decimalge0",
        "string029" => "string029",
        "string03" => "string03",
        "string1100" => "string1100",
        "string012" => "string012",
        "string010" => "string010",
        "string130" => "string130",
        "string55" => "string55",
        "string1010" => "string1010",
        "string030" => "string030",
        "string040" => "string040",
        "string140" => "string140",
        "string620" => "string620",
        "string22147483647" => "string22147483647",
        "string041" => "string041",
        "guid" => "guid",
    );

    /**
     * Constructor using wsdl location and options array
     * @param string $wsdl WSDL location for this service
     * @param array $options Options for the SoapClient
     */
    public function __construct($wsdl="stamps.wsdl", $options=array('trace'=>1, 'cache_wsdl'=> WSDL_CACHE_NONE)) {
        $wsdl = dirname(__FILE__). "/". $wsdl;
        foreach(self::$classmap as $wsdlClassName => $phpClassName) {
            if(!isset($options['classmap'][$wsdlClassName])) {
                $options['classmap'][$wsdlClassName] = $phpClassName;
            }
        }
        // If proxy is specified as enviornment variable pass it in.
        if (getenv('PROXY_HOST')) {
            $options['proxy_host'] = getenv('PROXY_HOST'); 
        }
        if (getenv('PROXY_PORT')) {
            $options['proxy_port'] = getenv('PROXY_PORT'); 
        }
        parent::__construct($wsdl, $options);
    }

    /**
     * Checks if an argument list matches against a valid argument type list
     * @param array $arguments The argument list to check
     * @param array $validParameters A list of valid argument types
     * @return boolean true if arguments match against validParameters
     * @throws Exception invalid function signature message
     */
    public function _checkArguments($arguments, $validParameters) {
        if(empty($arguments) && empty($validParameters)) {
            return true;
        }
        $variables = "";
        foreach ($arguments as $arg) {
            $type = gettype($arg);
            if ($type == "object") {
                $type = get_class($arg);
            }
            $variables .= "(".$type.")";
        }
        if (!in_array($variables, $validParameters)) {
            throw new Exception("Invalid parameter types: ".str_replace(")(", ", ", $variables));
        }
        return true;
    }

    /**
     * Service Call: CreateIndicium
     * Parameter options:
     * (CreateIndicium) parameters
     * (CreateIndicium) parameters
     * @param mixed,... See function description for parameter options
     * @return CreateIndiciumResponse
     * @throws Exception invalid function signature message
     */
    public function CreateIndicium($mixed = null) {
        $validParameters = array(
            "(CreateIndicium)",
            "(CreateIndicium)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CreateIndicium", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: CreateTestIndicium
     * Parameter options:
     * (CreateTestIndicium) parameters
     * (CreateTestIndicium) parameters
     * @param mixed,... See function description for parameter options
     * @return CreateTestIndiciumResponse
     * @throws Exception invalid function signature message
     */
    public function CreateTestIndicium($mixed = null) {
        $validParameters = array(
            "(CreateTestIndicium)",
            "(CreateTestIndicium)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CreateTestIndicium", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: CreateEnvelopeIndicium
     * Parameter options:
     * (CreateEnvelopeIndicium) parameters
     * (CreateEnvelopeIndicium) parameters
     * @param mixed,... See function description for parameter options
     * @return CreateEnvelopeIndiciumResponse
     * @throws Exception invalid function signature message
     */
    public function CreateEnvelopeIndicium($mixed = null) {
        $validParameters = array(
            "(CreateEnvelopeIndicium)",
            "(CreateEnvelopeIndicium)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CreateEnvelopeIndicium", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: CreateNetStampsIndicia
     * Parameter options:
     * (CreateNetStampsIndicia) parameters
     * (CreateNetStampsIndicia) parameters
     * @param mixed,... See function description for parameter options
     * @return CreateNetStampsIndiciaResponse
     * @throws Exception invalid function signature message
     */
    public function CreateNetStampsIndicia($mixed = null) {
        $validParameters = array(
            "(CreateNetStampsIndicia)",
            "(CreateNetStampsIndicia)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CreateNetStampsIndicia", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: CreateUnfundedIndicium
     * Parameter options:
     * (CreateUnfundedIndicium) parameters
     * (CreateUnfundedIndicium) parameters
     * @param mixed,... See function description for parameter options
     * @return CreateUnfundedIndiciumResponse
     * @throws Exception invalid function signature message
     */
    public function CreateUnfundedIndicium($mixed = null) {
        $validParameters = array(
            "(CreateUnfundedIndicium)",
            "(CreateUnfundedIndicium)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CreateUnfundedIndicium", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: GetRates
     * Parameter options:
     * (GetRates) parameters
     * (GetRates) parameters
     * @param mixed,... See function description for parameter options
     * @return GetRatesResponse
     * @throws Exception invalid function signature message
     */
    public function GetRates($mixed = null) {
        $validParameters = array(
            "(GetRates)",
            "(GetRates)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        
        try {
            return $this->__soapCall("GetRates", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: ChangePassword
     * Parameter options:
     * (ChangePassword) parameters
     * (ChangePassword) parameters
     * @param mixed,... See function description for parameter options
     * @return ChangePasswordResponse
     * @throws Exception invalid function signature message
     */
    public function ChangePassword($mixed = null) {
        $validParameters = array(
            "(ChangePassword)",
            "(ChangePassword)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("ChangePassword", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: PriceOrder
     * Parameter options:
     * (PriceOrder) parameters
     * (PriceOrder) parameters
     * @param mixed,... See function description for parameter options
     * @return PriceOrderResponse
     * @throws Exception invalid function signature message
     */
    public function PriceOrder($mixed = null) {
        $validParameters = array(
            "(PriceOrder)",
            "(PriceOrder)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("PriceOrder", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: PlaceOrder
     * Parameter options:
     * (PlaceOrder) parameters
     * (PlaceOrder) parameters
     * @param mixed,... See function description for parameter options
     * @return PlaceOrderResponse
     * @throws Exception invalid function signature message
     */
    public function PlaceOrder($mixed = null) {
        $validParameters = array(
            "(PlaceOrder)",
            "(PlaceOrder)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("PlaceOrder", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: CleanseAddress
     * Parameter options:
     * (CleanseAddress) parameters
     * (CleanseAddress) parameters
     * @param mixed,... See function description for parameter options
     * @return CleanseAddressResponse
     * @throws Exception invalid function signature message
     */
    public function CleanseAddress($mixed = null) {
        $validParameters = array(
            "(CleanseAddress)",
            "(CleanseAddress)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CleanseAddress", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: GetNetStampsImages
     * Parameter options:
     * (GetNetStampsImages) parameters
     * (GetNetStampsImages) parameters
     * @param mixed,... See function description for parameter options
     * @return GetNetStampsImagesResponse
     * @throws Exception invalid function signature message
     */
    public function GetNetStampsImages($mixed = null) {
        $validParameters = array(
            "(GetNetStampsImages)",
            "(GetNetStampsImages)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("GetNetStampsImages", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: ChangePlan
     * Parameter options:
     * (ChangePlan) parameters
     * (ChangePlan) parameters
     * @param mixed,... See function description for parameter options
     * @return ChangePlanResponse
     * @throws Exception invalid function signature message
     */
    public function ChangePlan($mixed = null) {
        $validParameters = array(
            "(ChangePlan)",
            "(ChangePlan)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("ChangePlan", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: GetChangePlanStatus
     * Parameter options:
     * (GetChangePlanStatus) parameters
     * (GetChangePlanStatus) parameters
     * @param mixed,... See function description for parameter options
     * @return GetChangePlanStatusResponse
     * @throws Exception invalid function signature message
     */
    public function GetChangePlanStatus($mixed = null) {
        $validParameters = array(
            "(GetChangePlanStatus)",
            "(GetChangePlanStatus)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("GetChangePlanStatus", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: CreateScanForm
     * Parameter options:
     * (CreateScanForm) parameters
     * (CreateScanForm) parameters
     * @param mixed,... See function description for parameter options
     * @return CreateScanFormResponse
     * @throws Exception invalid function signature message
     */
    public function CreateScanForm($mixed = null) {
        $validParameters = array(
            "(CreateScanForm)",
            "(CreateScanForm)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CreateScanForm", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: PurchasePostage
     * Parameter options:
     * (PurchasePostage) parameters
     * (PurchasePostage) parameters
     * @param mixed,... See function description for parameter options
     * @return PurchasePostageResponse
     * @throws Exception invalid function signature message
     */
    public function PurchasePostage($mixed = null) {
        $validParameters = array(
            "(PurchasePostage)",
            "(PurchasePostage)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("PurchasePostage", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: ResubmitPurchase
     * Parameter options:
     * (ResubmitPurchase) parameters
     * (ResubmitPurchase) parameters
     * @param mixed,... See function description for parameter options
     * @return ResubmitPurchaseResponse
     * @throws Exception invalid function signature message
     */
    public function ResubmitPurchase($mixed = null) {
        $validParameters = array(
            "(ResubmitPurchase)",
            "(ResubmitPurchase)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("ResubmitPurchase", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: CarrierPickup
     * Parameter options:
     * (CarrierPickup) parameters
     * (CarrierPickup) parameters
     * @param mixed,... See function description for parameter options
     * @return CarrierPickupResponse
     * @throws Exception invalid function signature message
     */
    public function CarrierPickup($mixed = null) {
        $validParameters = array(
            "(CarrierPickup)",
            "(CarrierPickup)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CarrierPickup", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: GetURL
     * Parameter options:
     * (GetURL) parameters
     * (GetURL) parameters
     * @param mixed,... See function description for parameter options
     * @return GetURLResponse
     * @throws Exception invalid function signature message
     */
    public function GetURL($mixed = null) {
        $validParameters = array(
            "(GetURL)",
            "(GetURL)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("GetURL", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: EnumNetStampsLayouts
     * Parameter options:
     * (EnumNetStampsLayouts) parameters
     * (EnumNetStampsLayouts) parameters
     * @param mixed,... See function description for parameter options
     * @return EnumNetStampsLayoutsResponse
     * @throws Exception invalid function signature message
     */
    public function EnumNetStampsLayouts($mixed = null) {
        $validParameters = array(
            "(EnumNetStampsLayouts)",
            "(EnumNetStampsLayouts)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("EnumNetStampsLayouts", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: EnumCostCodes
     * Parameter options:
     * (EnumCostCodes) parameters
     * (EnumCostCodes) parameters
     * @param mixed,... See function description for parameter options
     * @return EnumCostCodesResponse
     * @throws Exception invalid function signature message
     */
    public function EnumCostCodes($mixed = null) {
        $validParameters = array(
            "(EnumCostCodes)",
            "(EnumCostCodes)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("EnumCostCodes", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: AuthenticateWithTransferAuthenticator
     * Parameter options:
     * (AuthenticateWithTransferAuthenticator) parameters
     * (AuthenticateWithTransferAuthenticator) parameters
     * @param mixed,... See function description for parameter options
     * @return AuthenticateWithTransferAuthenticatorResponse
     * @throws Exception invalid function signature message
     */
    public function AuthenticateWithTransferAuthenticator($mixed = null) {
        $validParameters = array(
            "(AuthenticateWithTransferAuthenticator)",
            "(AuthenticateWithTransferAuthenticator)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("AuthenticateWithTransferAuthenticator", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: CancelIndicium
     * Parameter options:
     * (CancelIndicium) parameters
     * (CancelIndicium) parameters
     * @param mixed,... See function description for parameter options
     * @return CancelIndiciumResponse
     * @throws Exception invalid function signature message
     */
    public function CancelIndicium($mixed = null) {
        $validParameters = array(
            "(CancelIndicium)",
            "(CancelIndicium)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("CancelIndicium", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: StartPasswordReset
     * Parameter options:
     * (StartPasswordReset) parameters
     * (StartPasswordReset) parameters
     * @param mixed,... See function description for parameter options
     * @return StartPasswordResetResponse
     * @throws Exception invalid function signature message
     */
    public function StartPasswordReset($mixed = null) {
        $validParameters = array(
            "(StartPasswordReset)",
            "(StartPasswordReset)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("StartPasswordReset", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: FinishPasswordReset
     * Parameter options:
     * (FinishPasswordReset) parameters
     * (FinishPasswordReset) parameters
     * @param mixed,... See function description for parameter options
     * @return FinishPasswordResetResponse
     * @throws Exception invalid function signature message
     */
    public function FinishPasswordReset($mixed = null) {
        $validParameters = array(
            "(FinishPasswordReset)",
            "(FinishPasswordReset)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("FinishPasswordReset", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: GetCodewordQuestions
     * Parameter options:
     * (GetCodewordQuestions) parameters
     * (GetCodewordQuestions) parameters
     * @param mixed,... See function description for parameter options
     * @return GetCodewordQuestionsResponse
     * @throws Exception invalid function signature message
     */
    public function GetCodewordQuestions($mixed = null) {
        $validParameters = array(
            "(GetCodewordQuestions)",
            "(GetCodewordQuestions)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("GetCodewordQuestions", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: RegisterAccount
     * Parameter options:
     * (RegisterAccount) parameters
     * (RegisterAccount) parameters
     * @param mixed,... See function description for parameter options
     * @return RegisterAccountResponse
     * @throws Exception invalid function signature message
     */
    public function RegisterAccount($mixed = null) {
        $validParameters = array(
            "(RegisterAccount)",
            "(RegisterAccount)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("RegisterAccount", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: VoidUnfundedIndicium
     * Parameter options:
     * (VoidUnfundedIndicium) parameters
     * (VoidUnfundedIndicium) parameters
     * @param mixed,... See function description for parameter options
     * @return VoidUnfundedIndiciumResponse
     * @throws Exception invalid function signature message
     */
    public function VoidUnfundedIndicium($mixed = null) {
        $validParameters = array(
            "(VoidUnfundedIndicium)",
            "(VoidUnfundedIndicium)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("VoidUnfundedIndicium", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: FundUnfundedIndicium
     * Parameter options:
     * (FundUnfundedIndicium) parameters
     * (FundUnfundedIndicium) parameters
     * @param mixed,... See function description for parameter options
     * @return FundUnfundedIndiciumResponse
     * @throws Exception invalid function signature message
     */
    public function FundUnfundedIndicium($mixed = null) {
        $validParameters = array(
            "(FundUnfundedIndicium)",
            "(FundUnfundedIndicium)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("FundUnfundedIndicium", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: AuthenticateUser
     * Parameter options:
     * (AuthenticateUser) parameters
     * (AuthenticateUser) parameters
     * @param mixed,... See function description for parameter options
     * @return AuthenticateUserResponse
     * @throws Exception invalid function signature message
     */
    public function AuthenticateUser($mixed = null) {
        $validParameters = array(
            "(AuthenticateUser)",
            "(AuthenticateUser)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("AuthenticateUser", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: GetAccountInfo
     * Parameter options:
     * (GetAccountInfo) parameters
     * (GetAccountInfo) parameters
     * @param mixed,... See function description for parameter options
     * @return GetAccountInfoResponse
     * @throws Exception invalid function signature message
     */
    public function GetAccountInfo($mixed = null) {
        $validParameters = array(
            "(GetAccountInfo)",
            "(GetAccountInfo)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("GetAccountInfo", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: GetPurchaseStatus
     * Parameter options:
     * (GetPurchaseStatus) parameters
     * (GetPurchaseStatus) parameters
     * @param mixed,... See function description for parameter options
     * @return GetPurchaseStatusResponse
     * @throws Exception invalid function signature message
     */
    public function GetPurchaseStatus($mixed = null) {
        $validParameters = array(
            "(GetPurchaseStatus)",
            "(GetPurchaseStatus)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("GetPurchaseStatus", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


    /**
     * Service Call: TrackShipment
     * Parameter options:
     * (TrackShipment) parameters
     * (TrackShipment) parameters
     * @param mixed,... See function description for parameter options
     * @return TrackShipmentResponse
     * @throws Exception invalid function signature message
     */
    public function TrackShipment($mixed = null) {
        $validParameters = array(
            "(TrackShipment)",
            "(TrackShipment)",
        );
        $args = func_get_args();
        $this->_checkArguments($args, $validParameters);
        try {
            return $this->__soapCall("TrackShipment", $args);
        } catch (SoapFault $e) {
            return $e->faultstring;
        }
    }


}}

?>

