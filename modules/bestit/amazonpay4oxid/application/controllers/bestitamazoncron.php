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

/**
 * Class bestitAmazonCron
 */
class bestitAmazonCron extends oxUBase
{
    /**
     * @var string
     */
    protected $_sThisTemplate = 'bestitamazonpay4oxidcron.tpl';
    
    /**
     * @var null|bestitAmazonPay4OxidContainer
     */
    protected $_oContainer = null;

    /**
     * Returns the active user object.
     *
     * @return bestitAmazonPay4OxidContainer
     */
    protected function _getContainer()
    {
        if ($this->_oContainer === null) {
            $this->_oContainer = oxNew('bestitAmazonPay4OxidContainer');
        }

        return $this->_oContainer;
    }

    /**
     * Adds the text to the message.
     *
     * @param $sText
     */
    protected function _addToMessages($sText)
    {
        $aViewData = $this->getViewData();
        $aViewData['sMessage'] = isset($aViewData['sMessage']) ? $aViewData['sMessage'].$sText : $sText;
        $this->setViewData($aViewData);
    }

    /**
     * Processes the order states.
     *
     * @param string  $sQuery
     * @param string  $sClientFunction
     *
     * @return array
     */
    protected function _processOrderStates($sQuery, $sClientFunction)
    {
        $aResponses = array();
        $aResult = $this->_getContainer()->getDatabase()->getAll($sQuery);

        foreach ($aResult as $aRow) {
            $oOrder = $this->_getContainer()->getObjectFactory()->createOxidObject('oxOrder');

            if ($oOrder->load($aRow['OXID'])) {
                $oData = $this->_getContainer()->getClient()->{$sClientFunction}($oOrder);
                $aResponses[$aRow['OXORDERNR']] = $oData;
            }
        }

        return $aResponses;
    }

    /**
     * Authorize unauthorized orders or orders with pending status
     */
    protected function _updateAuthorizedOrders()
    {
        $aProcessed = $this->_processOrderStates(
            "SELECT OXID, OXORDERNR FROM oxorder
            WHERE BESTITAMAZONORDERREFERENCEID != ''
              AND BESTITAMAZONAUTHORIZATIONID != ''
              AND OXTRANSSTATUS = 'AMZ-Authorize-Pending'",
            'getAuthorizationDetails'
        );

        foreach ($aProcessed as $sOrderNumber => $oData) {
            if (isset($oData->GetAuthorizationDetailsResult->AuthorizationDetails->AuthorizationStatus->State)) {
                $sState = $oData->GetAuthorizationDetailsResult
                    ->AuthorizationDetails
                    ->AuthorizationStatus->State;
                $this->_addToMessages("Authorized Order #{$sOrderNumber} - Status updated to: {$sState}<br/>");
            }
        }
    }

    /**
     * Update declined orders state
     */
    protected function _updateDeclinedOrders()
    {
        $aProcessed = $this->_processOrderStates(
            "SELECT OXID, OXORDERNR FROM oxorder
            WHERE BESTITAMAZONORDERREFERENCEID != ''
              AND BESTITAMAZONAUTHORIZATIONID != ''
              AND OXTRANSSTATUS = 'AMZ-Authorize-Declined'",
            'getOrderReferenceDetails'
        );

        foreach ($aProcessed as $sOrderNumber => $oData) {
            if (isset($oData->GetOrderReferenceDetailsResult->OrderReferenceDetails->OrderReferenceStatus->State)) {
                $sState = $oData->GetOrderReferenceDetailsResult
                    ->OrderReferenceDetails
                    ->OrderReferenceStatus->State;
                $this->_addToMessages("Declined Order #{$sOrderNumber} - Status updated to: {$sState}<br/>");
            }
        }
    }

    /**
     * Update suspended orders
     */
    protected function _updateSuspendedOrders()
    {
        $aProcessed = $this->_processOrderStates(
            "SELECT OXID, OXORDERNR FROM oxorder
            WHERE BESTITAMAZONORDERREFERENCEID != ''
              AND BESTITAMAZONAUTHORIZATIONID != ''
              AND OXTRANSSTATUS = 'AMZ-Order-Suspended'",
            'getOrderReferenceDetails'
        );

        foreach ($aProcessed as $sOrderNumber => $oData) {
            if (isset($oData->GetOrderReferenceDetailsResult->OrderReferenceDetails->OrderReferenceStatus->State)) {
                $sState = $oData->GetOrderReferenceDetailsResult
                    ->OrderReferenceDetails
                    ->OrderReferenceStatus->State;
                $this->_addToMessages("Suspended Order #{$sOrderNumber} - Status updated to: {$sState}<br/>");
            }
        }
    }

    /**
     * Capture orders with Authorize status=open
     */
    protected function _captureOrders()
    {
        $sSQLAddShippedCase = '';

        //Capture orders if in module settings was set to capture just shipped orders
        if ((string)$this->_getContainer()->getConfig()->getConfigParam('sAmazonCapture') === 'SHIPPED') {
            $sSQLAddShippedCase = ' AND OXSENDDATE > 0';
        }

        $aProcessed = $this->_processOrderStates(
            "SELECT OXID, OXORDERNR
            FROM oxorder
            WHERE BESTITAMAZONAUTHORIZATIONID != ''
              AND OXTRANSSTATUS = 'AMZ-Authorize-Open' {$sSQLAddShippedCase}",
            'capture'
        );

        foreach ($aProcessed as $sOrderNumber => $oData) {
            if (isset($oData->CaptureResult->CaptureDetails->CaptureStatus->State)) {
                $sState = $oData->CaptureResult->CaptureDetails->CaptureStatus->State;
                $this->_addToMessages("Capture Order #{$sOrderNumber} - Status updated to: {$sState}<br/>");
            }
        }
    }

    /**
     * Check and update refund details for made refunds
     */
    protected function _updateRefundDetails()
    {
        $sQuery = "SELECT BESTITAMAZONREFUNDID
            FROM bestitamazonrefunds
            WHERE STATE = 'Pending'
              AND BESTITAMAZONREFUNDID != ''";

        $aResult = $this->_getContainer()->getDatabase()->getAll($sQuery);

        foreach ($aResult as $aRow) {
            $oData = $this->_getContainer()->getClient()->getRefundDetails($aRow['BESTITAMAZONREFUNDID']);

            if (isset($oData->GetRefundDetailsResult->RefundDetails->RefundStatus->State)) {
                $this->_addToMessages(
                    "Refund ID: {$oData->GetRefundDetailsResult->RefundDetails->RefundReferenceId} - "
                    ."Status: {$oData->GetRefundDetailsResult->RefundDetails->RefundStatus->State}<br/>"
                );
            }
        }
    }

    /**
     * The render function
     */
    public function render()
    {
        //Increase execution time for the script to run without timeouts
        set_time_limit(3600);

        //If ERP mode is enabled do nothing, if IPN or CRON authorize unauthorized orders
        if ((bool)$this->_getContainer()->getConfig()->getConfigParam('blAmazonERP') === true) {
            $this->setViewData(array('sError' => 'ERP mode is ON (Module settings)'));
        } elseif ((string)$this->_getContainer()->getConfig()->getConfigParam('sAmazonAuthorize') !== 'CRON') {
            $this->setViewData(array('sError' => 'Trigger Authorise via Cronjob mode is turned Off (Module settings)'));
        } else {
            //Authorize unauthorized or Authorize-Pending orders
            $this->_updateAuthorizedOrders();

            //Check for declined orders
            $this->_updateDeclinedOrders();

            //Check for suspended orders
            $this->_updateSuspendedOrders();

            //Capture handling
            $this->_captureOrders();

            //Check refund stats
            $this->_updateRefundDetails();
            
            $this->_addToMessages('Done');
        }

        return $this->_sThisTemplate;
    }

    /**
     * Method returns Operation name
     *
     * @return mixed
     */
    protected function _getOperationName()
    {
        $operation = lcfirst($this->_getContainer()->getConfig()->getRequestParameter('operation'));

        if (method_exists($this->_getContainer()->getClient(), $operation)) {
            return $operation;
        }

        $this->setViewData(array('sError' => "Operation '{$operation}' does not exist"));
        return false;
    }

    /**
     * Method returns Order object
     *
     * @return null|oxOrder
     */
    protected function _getOrder()
    {
        $sOrderId = $this->_getContainer()->getConfig()->getRequestParameter('oxid');

        if ($sOrderId !== null) {
            /** @var oxOrder $oOrder */
            $oOrder = $this->_getContainer()->getObjectFactory()->createOxidObject('oxOrder');

            if ($oOrder->load($sOrderId) === true) {
                return $oOrder;
            }
        }

        return null;
    }

    /**
     * Method returns Parameters from GET aParam array
     *
     * @return array
     */
    protected function _getParams()
    {
        $aResult = array();
        $aParams = (array)$this->_getContainer()->getConfig()->getRequestParameter('aParams');

        foreach ($aParams as $sKey => $sValue) {
            $aResult[html_entity_decode($sKey)] = html_entity_decode($sValue);
        }

        return $aResult;
    }

    /**
     * Makes request to Amazon methods
     *
     * amazonCall method Calling examples:
     *
     * index.php?cl=bestitamazoncron&fnc=amazonCall&operation=Authorize&oxid=87feca21ce31c34f0d3dceb8197a2375
     * index.php?cl=bestitamazoncron&fnc=amazonCall&operation=Authorize&aParams[AmazonOrderReferenceId]=51fd6a7381e7a0220b0f166fe331e420&aParams[AmazonAuthorizationId]=S02-8774768-9373076-A060413
     */
    public function amazonCall()
    {
        $sOperation = $this->_getOperationName();

        if ($sOperation !== false) {
            $oResult = $this->_getContainer()->getClient()->{$sOperation}(
                $this->_getOrder(),
                $this->_getParams()
            );

            $this->_addToMessages('<pre>'.print_r($oResult, true).'</pre>');
            return true;
        }

        $this->setViewData(array(
            'sError' => 'Please specify operation you want to call (&operation=) '
                .'and use &oxid= parameter to specify order ID or use &aParams[\'key\']=value'
        ));

        return false;
    }
}
