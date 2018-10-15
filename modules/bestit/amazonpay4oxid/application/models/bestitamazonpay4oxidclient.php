<?php
/**
 * This file is part of best it GmbH & Co. KG Amazon Pay module.
 *
 * best it GmbH & Co. KG Amazon Pay module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * best it GmbH & Co. KG Amazon Pay module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with best it GmbH & Co. KG Amazon Pay module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.bestit-online.de
 * @copyright (C) 2018 best it GmbH & Co. KG
 */

$sVendorAutoloader = realpath(dirname(__FILE__).'/../../').'/vendor/autoload.php';

if (file_exists($sVendorAutoloader) === true) {
    require_once(realpath(dirname(__FILE__).'/../../').'/vendor/autoload.php');
}

use AmazonPay\Client;
use AmazonPay\ResponseParser;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class bestitAmazonPay4OxidModel
 */
class bestitAmazonPay4OxidClient extends bestitAmazonPay4OxidContainer
{
    /**
     * Log directory
     */
    const LOG_DIR = 'log/bestitamazon/';

    /**
     * Amazon Widget URL
     *
     * @var string
     */
    protected $_sAmazonWidgetUrlDE = 'https://static-eu.payments-amazon.com/OffAmazonPayments/de/js/Widgets.js';
    protected $_sAmazonWidgetUrlDESandbox = 'https://static-eu.payments-amazon.com/OffAmazonPayments/de/sandbox/js/Widgets.js';
    protected $_sAmazonWidgetUrlUK = 'https://static-eu.payments-amazon.com/OffAmazonPayments/uk/js/Widgets.js';
    protected $_sAmazonWidgetUrlUKSandbox = 'https://static-eu.payments-amazon.com/OffAmazonPayments/uk/sandbox/js/Widgets.js';
    protected $_sAmazonWidgetUrlUS = 'https://static-na.payments-amazon.com/OffAmazonPayments/us/js/Widgets.js';
    protected $_sAmazonWidgetUrlUSSandbox = 'https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js';

    /**
     * Amazon Login Widget URL
     *
     * @var string
     */
    protected $_sAmazonLoginWidgetUrlDE = 'https://static-eu.payments-amazon.com/OffAmazonPayments/de/lpa/js/Widgets.js';
    protected $_sAmazonLoginWidgetUrlDESandbox = 'https://static-eu.payments-amazon.com/OffAmazonPayments/de/sandbox/lpa/js/Widgets.js';
    protected $_sAmazonLoginWidgetUrlUK = 'https://static-eu.payments-amazon.com/OffAmazonPayments/uk/lpa/js/Widgets.js';
    protected $_sAmazonLoginWidgetUrlUKSandbox = 'https://static-eu.payments-amazon.com/OffAmazonPayments/uk/sandbox/lpa/js/Widgets.js';
    protected $_sAmazonLoginWidgetUrlUS = 'https://static-na.payments-amazon.com/OffAmazonPayments/us/lpa/js/Widgets.js';
    protected $_sAmazonLoginWidgetUrlUSSandbox = 'https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/lpa/js/Widgets.js';

    /**
     * Amazon Button URL
     *
     * @var string
     */
    protected $_sAmazonButtonUrlDE = 'https://payments.amazon.de/gp/widgets/button';
    protected $_sAmazonButtonUrlDESandbox = 'https://payments-sandbox.amazon.de/gp/widgets/button';
    protected $_sAmazonButtonUrlUK = 'https://payments.amazon.co.uk/gp/widgets/button';
    protected $_sAmazonButtonUrlUKSandbox = 'https://payments-sandbox.amazon.co.uk/gp/widgets/button';
    protected $_sAmazonButtonUrlUS = 'https://payments.amazon.com/gp/widgets/button';
    protected $_sAmazonButtonUrlUSSandbox = 'https://payments-sandbox.amazon.com/gp/widgets/button';

    /**
     * @var bestitAmazonPay4OxidClient
     */
    private static $_instance = null;

    /**
     * @var null|Logger
     */
    protected $_oLogger = null;
    
    /**
     * @var null|Client
     */
    protected $_oAmazonClient = null;

    /**
     * Singleton instance
     *
     * @return bestitAmazonPay4OxidClient
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = oxNew(__CLASS__);
        }

        return self::$_instance;
    }

    /**
     * Returns the logger.
     *
     * @return Logger
     */
    protected function _getLogger()
    {
        if ($this->_oLogger === null) {
            $this->_oLogger = new Logger('AmazonPayment');
            $sLogFile = $this->getConfig()->getConfigParam('sShopDir').self::LOG_DIR.'client.log';
            $this->_oLogger->pushHandler(new StreamHandler($sLogFile));
        }

        return $this->_oLogger;
    }

    /**
     * Returns the amazon api client.
     *
     * @param array $aConfig
     *
     * @return Client
     */
    protected function _getAmazonClient($aConfig = array())
    {
        if ($this->_oAmazonClient === null) {
            $aConfig = array_merge(
                $aConfig,
                array(
                    'merchant_id' => $this->getConfig()->getConfigParam('sAmazonSellerId'),
                    'access_key' => $this->getConfig()->getConfigParam('sAmazonAWSAccessKeyId'),
                    'secret_key' => $this->getConfig()->getConfigParam('sAmazonSignature'),
                    'client_id' => $this->getConfig()->getConfigParam('sAmazonLoginClientId'),
                    'region' => $this->getConfig()->getConfigParam('sAmazonLocale')
                )
            );

            $this->_oAmazonClient = new Client($aConfig);
            $this->_oAmazonClient->setSandbox((bool)$this->getConfig()->getConfigParam('blAmazonSandboxActive'));
            $this->_oAmazonClient->setLogger($this->_getLogger());
        }

        return $this->_oAmazonClient;
    }

    /**
     * @param ResponseParser $response
     *
     * @return stdClass
     */
    protected function _convertResponse(ResponseParser $response)
    {
        return json_decode($response->toJson());
    }

    /**
     * Amazon add sandbox simulation params
     *
     * @param string $sMethod
     * @param array  $aParams
     */
    protected function _addSandboxSimulationParams($sMethod, array &$aParams)
    {
        //If Sandbox mode is inactive or Sandbox Simulation is not selected don't add any Simulation Params
        if ((bool) $this->getConfig()->getConfigParam('blAmazonSandboxActive') !== true
            || (bool) $this->getConfig()->getConfigParam('sSandboxSimulation') === false
        ) {
            return;
        }

        $sSandboxSimulation = (string) $this->getConfig()->getConfigParam('sSandboxSimulation');

        $aMap = array(
            'setOrderReferenceDetails' => array(
                'SetOrderReferenceDetailsPaymentMethodNotAllowed' => array(
                    'OrderReferenceAttributes.SellerNote' => '{"SandboxSimulation":{"Constraint":"PaymentMethodNotAllowed"}}'
                )
            ),
            'closeOrderReference' => array(
                'CloseOrderReferenceAmazonClosed' => array(
                    'ClosureReason' => '{"SandboxSimulation": {"State":"Closed","ReasonCode":"AmazonClosed"}}'
                )
            ),
            'authorize' => array(
                'AuthorizeInvalidPaymentMethod' => array(
                    'SellerAuthorizationNote' => '{"SandboxSimulation": {"State":"Declined","ReasonCode":"InvalidPaymentMethod","PaymentMethodUpdateTimeInMins":5}}'
                ),
                'AuthorizeAmazonRejected' => array(
                    'SellerAuthorizationNote' => '{"SandboxSimulation": {"State":"Declined","ReasonCode":"AmazonRejected"}}'
                ),
                'AuthorizeTransactionTimedOut' => array(
                    'SellerAuthorizationNote' => '{"SandboxSimulation": {"State":"Declined","ReasonCode":"TransactionTimedOut"}}'
                ),
                'AuthorizeExpiredUnused' => array(
                    'SellerAuthorizationNote' => '{"SandboxSimulation": {"State":"Closed","ReasonCode":"ExpiredUnused","ExpirationTimeInMins":1}}'
                ),
                'AuthorizeAmazonClosed' => array(
                    'SellerAuthorizationNote' => '{"SandboxSimulation": {"State":"Closed","ReasonCode":"AmazonClosed"}}'
                )
            ),
            'capture' => array(
                'CapturePending' => array(
                    'SellerCaptureNote' => '{"SandboxSimulation": {"State":"Pending"}}'
                ),
                'CaptureAmazonRejected' => array(
                    'SellerCaptureNote' => '{"SandboxSimulation": {"State":"Declined","ReasonCode":"AmazonRejected"}}'
                ),
                'CaptureAmazonClosed' => array(
                    'SellerCaptureNote' => '{"SandboxSimulation": {"State":"Closed","ReasonCode":"AmazonClosed"}}'
                )
            ),
            'refund' => array(
                'CaptureAmazonClosed' => array(
                    'SellerRefundNote' => '{"SandboxSimulation": {"State":"Declined","ReasonCode":"AmazonRejected"}}'
                )
            )
        );

        if (isset($aMap[$sMethod][$sSandboxSimulation])) {
            $aParams = array_merge($aParams, $aMap[$sMethod][$sSandboxSimulation]);
        }
    }

    /**
     * Returns class property by given property name and other params
     *
     * @param string  $sPropertyName Property name
     * @param boolean $blCommon      Include 'Sandbox' in property name or not
     *
     * @return mixed
     */
    public function getAmazonProperty($sPropertyName, $blCommon = false)
    {
        $sSandboxPrefix = '';

        if ($blCommon === false && (bool)$this->getConfig()->getConfigParam('blAmazonSandboxActive') === true) {
            $sSandboxPrefix = 'Sandbox';
        }

        $sAmazonLocale = $this->getConfig()->getConfigParam('sAmazonLocale');
        $sPropertyName = '_'.$sPropertyName.$sAmazonLocale.$sSandboxPrefix;

        if (property_exists($this, $sPropertyName)) {
            return $this->$sPropertyName;
        }

        return null;
    }

    /**
     * Process order reference.
     *
     * @param oxOrder  $oOrder
     * @param stdClass $oOrderReference
     */
    public function processOrderReference(oxOrder $oOrder, $oOrderReference)
    {
        $sOrderReferenceStatus = $oOrderReference
            ->OrderReferenceStatus
            ->State;

        //Do re-authorization if order was suspended and now it's opened
        if ($oOrder->getFieldData('oxtransstatus') == 'AMZ-Order-Suspended'
            && $sOrderReferenceStatus === 'Open'
        ) {
            $this->authorize($oOrder);
        } else {
            $oOrder->assign(array('oxtransstatus' => 'AMZ-Order-'.$sOrderReferenceStatus));
            $oOrder->save();
        }
    }

    /**
     * Amazon GetOrderReferenceDetails method
     *
     * @param oxOrder $oOrder
     * @param array   $aParams    Custom parameters to send
     * @param bool    $blReadonly
     *
     * @return object response XML
     */
    public function getOrderReferenceDetails($oOrder = null, array $aParams = array(), $blReadonly = false)
    {
        $aRequestParameters = array();
        $sAmazonOrderReferenceId = ($oOrder === null) ?
            (string)$this->getSession()->getVariable('amazonOrderReferenceId') : '';

        if ($oOrder !== null) {
            $aRequestParameters['amazon_order_reference_id'] = $oOrder->getFieldData('bestitamazonorderreferenceid');
        } elseif ($sAmazonOrderReferenceId !== '') {
            $aRequestParameters['amazon_order_reference_id'] = $sAmazonOrderReferenceId;
            $sLoginToken = (string)$this->getSession()->getVariable('amazonLoginToken');

            if ($sLoginToken !== '') {
                $aRequestParameters['address_consent_token'] = $sLoginToken;
            }
        }

        //Make request
        $aRequestParameters = array_merge($aRequestParameters, $aParams);

        $oData = $this->_convertResponse($this->_getAmazonClient()->getOrderReferenceDetails($aRequestParameters));

        //Update Order info
        if ($blReadonly === false
            && $oOrder !== null
            && isset($oData->GetOrderReferenceDetailsResult->OrderReferenceDetails->OrderReferenceStatus->State)
        ) {
            $this->processOrderReference(
                $oOrder,
                $oData->GetOrderReferenceDetailsResult->OrderReferenceDetails
            );
        }

        return $oData;
    }


    /**
     * Amazon SetOrderReferenceDetails method
     *
     * @param oxBasket $oBasket            OXID Basket object
     * @param array    $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function setOrderReferenceDetails($oBasket = null, array $aRequestParameters = array())
    {
        //Set default params
        $aRequestParameters['amazon_order_reference_id'] = $this->getSession()->getVariable('amazonOrderReferenceId');

        if ($oBasket !== null) {
            $aRequestParameters = array_merge(
                $aRequestParameters,
                array(
                    'amount' => $oBasket->getPrice()->getBruttoPrice(),
                    'currency_code' => $oBasket->getBasketCurrency()->name,
                    'platform_id' => 'A26EQAZK19E0U2',
                    'store_name' => $this->getConfig()->getActiveShop()->getFieldData('oxname')
                )
            );
        }

        $this->_addSandboxSimulationParams('setOrderReferenceDetails', $aRequestParameters);
        return $this->_convertResponse($this->_getAmazonClient()->setOrderReferenceDetails($aRequestParameters));
    }


    /**
     * Amazon ConfirmOrderReference method
     *
     * @param array $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function confirmOrderReference(array $aRequestParameters = array())
    {
        //Set params
        $aRequestParameters['amazon_order_reference_id'] = $this->getSession()->getVariable('amazonOrderReferenceId');
        return $this->_convertResponse($this->_getAmazonClient()->confirmOrderReference($aRequestParameters));
    }

    /**
     * Sets the order status
     *
     * @param oxOrder  $oOrder
     * @param stdClass $oData
     * @param string   $sStatus
     *
     * @return bool
     */
    protected function _setOrderTransactionErrorStatus(oxOrder $oOrder, $oData, $sStatus = null)
    {
        if (isset($oData->Error->Code) && (bool) $oData->Error->Code !== false) {
            if ($sStatus === null) {
                $sStatus = 'AMZ-Error-'.$oData->Error->Code;
            }

            $oOrder->assign(array('oxtransstatus' => $sStatus));
            $oOrder->save();
            return true;
        }

        return false;
    }


    /**
     * @param oxOrder $oOrder
     * @param array   $aRequestParameters
     * @param array   $aFields
     */
    protected function _mapOrderToRequestParameters(oxOrder $oOrder, array &$aRequestParameters, array $aFields)
    {
        $aMap = array(
            'amazon_order_reference_id' => 'bestitamazonorderreferenceid',
            'closure_reason' => 'oxordernr',
            'authorization_amount' => 'oxtotalordersum',
            'currency_code' => 'oxcurrency',
            'authorization_reference_id' => 'bestitamazonorderreferenceid',
            'seller_authorization_note' => 'oxordernr',
            'amazon_authorization_id' => 'bestitamazonauthorizationid',
            'capture_amount' => 'oxtotalordersum',
            'capture_reference_id' => 'bestitamazonorderreferenceid',
            'seller_capture_note' => 'oxordernr',
            'amazon_capture_id' => 'bestitamazoncaptureid',
            'refund_reference_id' => 'bestitamazonorderreferenceid',
            'seller_refund_note' => 'oxordernr'
        );

        $aPrependMap = array(
            'closure_reason' => 'Authorization%20Close%20Order%20#',
            'seller_authorization_note' => 'Authorization%20Order%20#',
            'seller_refund_note' => 'Refund%20Order%20#',
            'seller_capture_note' => $this->getConfig()->getActiveShop()->getFieldData('oxname').' '
                .$this->getLanguage()->translateString('BESTITAMAZONPAY_ORDER_NO').': '
        );

        $aAppendMap = array(
            'authorization_reference_id' => '_'.$this->getUtilsDate()->getTime(),
            'capture_reference_id' => '_'.$this->getUtilsDate()->getTime(),
            'refund_reference_id' => '_'.$this->getUtilsDate()->getTime()
        );

        foreach ($aFields as $sField) {
            if (isset($aRequestParameters[$sField])) {
                continue;
            }

            if (isset($aMap[$sField])) {
                $aRequestParameters[$sField] = $oOrder->getFieldData($aMap[$sField]);
            }

            if (isset($aPrependMap[$sField])) {
                $aRequestParameters[$sField] = $aPrependMap[$sField].$aRequestParameters[$sField];
            }

            if (isset($aAppendMap[$sField])) {
                $aRequestParameters[$sField] .= $aAppendMap[$sField];
            }
        }
    }

    /**
     * @param string  $sRequestFunction
     * @param oxOrder $oOrder
     * @param array   $aRequestParameters
     * @param array   $aFields
     * @param bool    $blProcessable
     * @param null    $sErrorCode
     *
     * @return stdClass
     */
    protected function _callOrderRequest(
        $sRequestFunction,
        $oOrder,
        array $aRequestParameters,
        array $aFields,
        &$blProcessable = false,
        $sErrorCode = null
    ) {
        $blProcessable = false;

        //Set default params
        if ($oOrder !== null) {
            $this->_mapOrderToRequestParameters($oOrder, $aRequestParameters, $aFields);
        }

        //Make request and return result
        $this->_addSandboxSimulationParams($sRequestFunction, $aRequestParameters);
        $oData = $this->_convertResponse($this->_getAmazonClient()->{$sRequestFunction}($aRequestParameters));

        //Update Order info
        if ($oOrder !== null) {
            $blProcessable = $this->_setOrderTransactionErrorStatus($oOrder, $oData, $sErrorCode) === false;
        }

        return $oData;
    }

    /**
     * Amazon CancelOrderReference method
     *
     * @param oxOrder $oOrder             OXID Order object
     * @param array   $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function cancelOrderReference($oOrder = null, array $aRequestParameters = array())
    {
        return $this->_callOrderRequest(
            'cancelOrderReference',
            $oOrder,
            $aRequestParameters,
            array('amazon_order_reference_id'),
            $blProcessable,
            'AMZ-Order-Canceled'
        );
    }

    /**
     * Amazon CloseOrderReference method
     *
     * @param oxOrder $oOrder             OXID Order object
     * @param array   $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function closeOrderReference($oOrder = null, $aRequestParameters = array())
    {
        return $this->_callOrderRequest(
            'closeOrderReference',
            $oOrder,
            $aRequestParameters,
            array('amazon_order_reference_id'),
            $blProcessable,
            'AMZ-Order-Closed'
        );
    }

    /**
     * Amazon CloseAuthorization method
     *
     * @param oxOrder $oOrder             OXID Order object
     * @param array   $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function closeAuthorization($oOrder = null, $aRequestParameters = array())
    {
        return $this->_callOrderRequest(
            'closeAuthorization',
            $oOrder,
            $aRequestParameters,
            array('amazon_authorization_id', 'closure_reason'),
            $blProcessable,
            'AMZ-Authorize-Closed'
        );
    }

    /**
     * Amazon Authorize method
     *
     * @param oxOrder $oOrder             OXID Order object
     * @param array   $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function authorize($oOrder = null, $aRequestParameters = array())
    {
        $aRequestParameters['transaction_timeout'] = ($this->getConfig()->getConfigParam('sAmazonMode') === 'Sync') ?
            0 : 1440;

        $oData = $this->_callOrderRequest(
            'authorize',
            $oOrder,
            $aRequestParameters,
            array(
                'amazon_order_reference_id',
                'authorization_amount',
                'currency_code',
                'authorization_reference_id',
                'seller_authorization_note'
            ),
            $blProcessable
        );

        //Update Order info
        if ($blProcessable === true
            && isset($oData->AuthorizeResult->AuthorizationDetails->AuthorizationStatus->State)
        ) {
            $oDetails = $oData->AuthorizeResult->AuthorizationDetails;
            $oOrder->assign(array(
                'bestitamazonauthorizationid' => $oDetails->AmazonAuthorizationId,
                'oxtransstatus' => 'AMZ-Authorize-'.$oDetails->AuthorizationStatus->State
            ));
            $oOrder->save();
        }

        return $oData;
    }

    /**
     * Processes the authorization
     *
     * @param oxOrder  $oOrder
     * @param stdClass $oAuthorizationDetails
     */
    public function processAuthorization(oxOrder $oOrder, $oAuthorizationDetails)
    {
        $oAuthorizationStatus = $oAuthorizationDetails->AuthorizationStatus;

        //Update Order with primary response info
        $oOrder->assign(array('oxtransstatus' => 'AMZ-Authorize-'.$oAuthorizationStatus->State));
        $oOrder->save();

        // Handle Declined response
        if ($oAuthorizationStatus->State === 'Declined'
            && $this->getConfig()->getConfigParam('sAmazonMode') === 'Async'
        ) {
            switch ($oAuthorizationStatus->ReasonCode) {
                case "InvalidPaymentMethod":
                    /** @var bestitAmazonPay4Oxid_oxEmail $oEmail */
                    $oEmail = $this->getObjectFactory()->createOxidObject('oxEmail');
                    $oEmail->sendAmazonInvalidPaymentEmail($oOrder);
                    break;
                case "AmazonRejected":
                    /** @var bestitAmazonPay4Oxid_oxEmail $oEmail */
                    $oEmail = $this->getObjectFactory()->createOxidObject('oxEmail');
                    $oEmail->sendAmazonRejectedPaymentEmail($oOrder);
                    $this->closeOrderReference($oOrder);
                    break;
                default:
                    $this->closeOrderReference($oOrder);
            }
        }

        //Authorize handling was selected Direct Capture after Authorize and Authorization status is Open
        if ($oAuthorizationStatus->State === 'Open'
            && $this->getConfig()->getConfigParam('sAmazonCapture') === 'DIRECT'
        ) {
            $this->capture($oOrder);
        }
    }

    /**
     * Amazon GetAuthorizationDetails method
     *
     * @param oxOrder $oOrder             OXID Order object
     * @param array   $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function getAuthorizationDetails($oOrder = null, $aRequestParameters = array())
    {
        $oData = $this->_callOrderRequest(
            'getAuthorizationDetails',
            $oOrder,
            $aRequestParameters,
            array('amazon_authorization_id'),
            $blProcessable
        );

        if ($blProcessable === true
            && isset($oData->GetAuthorizationDetailsResult->AuthorizationDetails->AuthorizationStatus->State)
        ) {
            $this->processAuthorization($oOrder, $oData->GetAuthorizationDetailsResult->AuthorizationDetails);
        }

        return $oData;
    }

    /**
     * @param oxOrder  $oOrder
     * @param stdClass $oCaptureDetails
     * @param bool     $blOnlyNotEmpty
     *
     * @return null
     */
    public function setCaptureState(oxOrder $oOrder, $oCaptureDetails, $blOnlyNotEmpty = false)
    {
        $aFields = array(
            'bestitamazoncaptureid' => $oCaptureDetails->AmazonCaptureId,
            'oxtransstatus' => 'AMZ-Capture-'.$oCaptureDetails->CaptureStatus->State
        );

        //Update paid date
        if ($oCaptureDetails->CaptureStatus->State === 'Completed'
            && ($blOnlyNotEmpty === false || $oOrder->getFieldData('oxpaid') !== '0000-00-00 00:00:00')
        ) {
            $aFields['oxpaid'] = date('Y-m-d H:i:s', $this->getUtilsDate()->getTime());
        }

        $oOrder->assign($aFields);
        return $oOrder->save();
    }

    /**
     * Amazon Capture method
     *
     * @param oxOrder $oOrder             OXID Order object
     * @param array   $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function capture($oOrder = null, $aRequestParameters = array())
    {
        $oData = $this->_callOrderRequest(
            'capture',
            $oOrder,
            $aRequestParameters,
            array(
                'amazon_authorization_id',
                'capture_amount',
                'currency_code',
                'capture_reference_id',
                'seller_capture_note'
            ),
            $blProcessable
        );

        //Update Order info
        if ($blProcessable === true && isset($oData->CaptureResult->CaptureDetails)) {
            $this->setCaptureState($oOrder, $oData->CaptureResult->CaptureDetails);
        }

        return $oData;
    }


    /**
     * Amazon GetCaptureDetails method
     *
     * @param oxOrder $oOrder             OXID Order object
     * @param array   $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function getCaptureDetails($oOrder = null, $aRequestParameters = array())
    {
        $oData = $this->_callOrderRequest(
            'getCaptureDetails',
            $oOrder,
            $aRequestParameters,
            array('amazon_capture_id'),
            $blProcessable
        );

        //Update Order info
        if ($blProcessable === true && isset($oData->GetCaptureDetailsResult->CaptureDetails)) {
            $this->setCaptureState($oOrder, $oData->GetCaptureDetailsResult->CaptureDetails, true);
        }

        return $oData;
    }

    /**
     * Amazon Refund method
     *
     * @param oxOrder $oOrder             OXID Order object
     * @param float   $fPrice             Price to refund
     * @param array   $aRequestParameters Custom parameters to send
     *
     * @return object response XML
     */
    public function refund($oOrder = null, $fPrice, $aRequestParameters = array())
    {
        //Refund ID
        if ($oOrder !== null) {
            $aRequestParameters['refund_amount'] = $fPrice;
            $this->_mapOrderToRequestParameters(
                $oOrder,
                $aRequestParameters,
                array('amazon_capture_id', 'currency_code', 'refund_reference_id', 'seller_refund_note')
            );
        }

        //Make request
        $this->_addSandboxSimulationParams('refund', $aRequestParameters);
        $oData = $this->_convertResponse($this->_getAmazonClient()->refund($aRequestParameters));

        //Update/Insert Refund info
        if ($oData && $oOrder !== null) {
            $sError = '';
            $sAmazonRefundId = '';

            if (isset($oData->Error)) {
                $sState = 'Error';
                $sError = $oData->Error->Message;
            } else {
                $sState = $oData->RefundResult->RefundDetails->RefundStatus->State;
                $sAmazonRefundId = $oData->RefundResult->RefundDetails->AmazonRefundId;
            }

            $sId = $oOrder->getFieldData('bestitamazonorderreferenceid').'_'.$this->getUtilsDate()->getTime();

            $sQuery = "
                INSERT bestitamazonrefunds SET 
                  ID = {$this->getDatabase()->quote($sId)},
                  OXORDERID = {$this->getDatabase()->quote($oOrder->getId())},
                  BESTITAMAZONREFUNDID = {$this->getDatabase()->quote($sAmazonRefundId)},
                  AMOUNT = {$fPrice},
                  STATE = {$this->getDatabase()->quote($sState)},
                  ERROR = {$this->getDatabase()->quote($sError)},
                  TIMESTAMP = NOW()";

            $this->getDatabase()->execute($sQuery);
        }

        return $oData;
    }

    /**
     * Updates the refund status.
     *
     * @param string $sAmazonRefundId
     * @param string $sState
     * @param string $sError
     */
    public function updateRefund($sAmazonRefundId, $sState, $sError = '')
    {
        $sQuery = "
                UPDATE bestitamazonrefunds SET
                  `STATE` = {$this->getDatabase()->quote($sState)},
                  `ERROR` = {$this->getDatabase()->quote($sError)},
                  `TIMESTAMP` = NOW()
                WHERE `BESTITAMAZONREFUNDID` = {$this->getDatabase()->quote($sAmazonRefundId)}";

        $this->getDatabase()->execute($sQuery);
    }

    /**
     * Amazon GetRefundDetails method
     *
     * @var string $sAmazonRefundId
     *
     * @return object response XML
     */
    public function getRefundDetails($sAmazonRefundId)
    {
        //Set default params
        $aRequestParameters['amazon_refund_id'] = $sAmazonRefundId;

        //Make request
        $oData = $this->_convertResponse($this->_getAmazonClient()->getRefundDetails($aRequestParameters));

        //Update/Insert Refund info
        if ($oData) {
            $sError = '';

            if (isset($oData->Error)) {
                $sState = 'Error';
                $sError = $oData->Error->Message;
            } else {
                $sState = $oData->GetRefundDetailsResult->RefundDetails->RefundStatus->State;
            }

            $this->updateRefund($sAmazonRefundId, $sState, $sError);
        }

        return $oData;
    }

    /**
     * Returns the user information.
     *
     * @param string $sAccessToken
     *
     * @return mixed
     */
    public function processAmazonLogin($sAccessToken)
    {
        return $this->_getAmazonClient()->getUserInfo($sAccessToken);
    }
}