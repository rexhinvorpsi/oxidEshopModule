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
 * Class bestitAmazonPay4Oxid
 */
class bestitAmazonPay4Oxid extends bestitAmazonPay4OxidContainer
{
    /**
     * @var bool
     */
    protected $_isSelectedCurrencyAvailable = null;

    /**
     * @var bool
     */
    protected $_blActive = null;

    /**
     * Returns true if currency meets locale
     *
     * @return boolean
     */
    public function getIsSelectedCurrencyAvailable()
    {
        if ($this->_isSelectedCurrencyAvailable === null) {
            $this->_isSelectedCurrencyAvailable = true;

            $aMap = array(
                'DE' => 'EUR',
                'UK' => 'GBP',
                'US' => 'USD'
            );
            $sLocale = (string)$this->getConfig()->getConfigParam('sAmazonLocale');
            $sCurrency = (string)$this->getSession()->getBasket()->getBasketCurrency()->name;

            //If Locale is DE and currency is not EURO don't allow Amazon checkout process
            if (isset($aMap[$sLocale]) && $aMap[$sLocale] !== $sCurrency) {
                $this->_isSelectedCurrencyAvailable = false;
            }
        }

        return $this->_isSelectedCurrencyAvailable;
    }

    /**
     * Method checks if Amazon Pay is active and can be used
     *
     * @return bool
     */
    public function isActive()
    {
        //If check was made once return result
        if ($this->_blActive !== null) {
            return $this->_blActive;
        }

        //Check if payment method itself is active
        $sTable = getViewName('oxpayments');
        $sSql = "SELECT OXACTIVE
            FROM {$sTable}
            WHERE OXID = 'bestitamazon'";

        $blPaymentActive = (bool)$this->getDatabase()->getOne($sSql);

        if ($blPaymentActive === false) {
            return $this->_blActive = false;
        }

        //Check if payment has at least one shipping method assigned
        $sO2PTable = getViewName('oxobject2payment');
        $sDelSetTable = getViewName('oxdeliveryset');
        $sSql = "SELECT OXOBJECTID
            FROM {$sO2PTable} AS o2p RIGHT JOIN {$sDelSetTable} AS d 
              ON (o2p.OXOBJECTID = d.OXID AND d.OXACTIVE = 1)
            WHERE OXPAYMENTID = 'bestitamazon'
              AND OXTYPE='oxdelset'
            LIMIT 1";

        $sShippingId = (string)$this->getDatabase()->getOne($sSql);

        if ($sShippingId === '') {
            return $this->_blActive = false;
        }

        //Check if shipping method has at least one shipping cost assigned
        $sTable = getViewName('oxdel2delset');
        $sSql = "SELECT OXID 
            FROM {$sTable} 
            WHERE OXDELSETID = {$this->getDatabase()->quote($sShippingId)}
            LIMIT 1";
        $sShippingCostRelated = (string)$this->getDatabase()->getOne($sSql);

        if ($sShippingCostRelated === '') {
            return $this->_blActive = false;
        }

        //Check if selected currency is available for selected Amazon locale
        if ($this->getIsSelectedCurrencyAvailable() === false) {
            return $this->_blActive = false;
        }

        //If Amazon SellerId is empty
        if ((string)$this->getConfig()->getConfigParam('sAmazonSellerId') === '') {
            return $this->_blActive = false;
        }

        //If basket items price = 0
        if ((int)$this->getSession()->getBasket()->getPrice()->getBruttoPrice() === 0) {
            return $this->_blActive = false;
        }

        return $this->_blActive = true;
    }

    /**
     * Cleans Amazon pay as the selected one, including all related variables, records and values
     */
    public function cleanAmazonPay()
    {
        //Delete our created user for Amazon checkout
        $oUser = $this->getActiveUser();
        $sAmazonUserName = $this->getSession()->getVariable('amazonOrderReferenceId') . '@amazon.com';

        if ($oUser !== false && $oUser->getFieldData('oxusername') === $sAmazonUserName) {
            $oUser->delete();
        }

        //Delete several session variables to clean up Amazon data in session
        $this->getSession()->deleteVariable('amazonOrderReferenceId');
        $this->getSession()->deleteVariable('sAmazonSyncResponseState');
        $this->getSession()->deleteVariable('sAmazonSyncResponseAuthorizationId');
        $this->getSession()->deleteVariable('blAmazonSyncChangePayment');

        //General cleanup of user accounts that has been created for orders and wos not used
        $this->cleanUpUnusedAccounts();
    }

    /**
     * Deletes previously created user accounts which was not used
     *
     */
    public function cleanUpUnusedAccounts()
    {
        $sTable = getViewName('oxuser');
        $sSql = "SELECT oxid, oxusername
            FROM {$sTable}
            WHERE oxusername LIKE '%-%-%@amazon.com'
              AND oxcreate < (NOW() - INTERVAL 1440 MINUTE)";

        $aData = $this->getDatabase()->getAll($sSql);

        foreach ($aData as $aUser) {
            //Delete user from OXID
            $oUser = $this->getObjectFactory()->createOxidObject('oxUser');

            if ($oUser->load($aUser['oxid'])) {
                $oUser->delete();
            }
        }
    }
}
