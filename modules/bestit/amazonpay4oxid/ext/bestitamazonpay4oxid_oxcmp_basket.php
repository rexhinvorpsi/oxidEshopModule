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
 * Class bestitAmazonPay4Oxid_oxcmp_basket
 */
class bestitAmazonPay4Oxid_oxcmp_basket extends bestitAmazonPay4Oxid_oxcmp_basket_parent
{
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
     * Cleans Amazon pay as the selected one, including all related variables and values
     */
    public function cleanAmazonPay()
    {
        //Clean all related variables with user data and amazon reference id
        $this->_getContainer()->getModule()->cleanAmazonPay();
        $oConfig = $this->_getContainer()->getConfig();
        $sError = (string)$oConfig->getRequestParameter('error');

        //Bind redirect message if previous was not set
        if ($sError === '') {
            $sError = 'BESTITAMAZONPAY_ERROR_AMAZON_TERMINATED';
        }

        /** @var oxUserException $oEx */
        $oEx = $this->_getContainer()->getObjectFactory()->createOxidObject('oxUserException');
        $oEx->setMessage($sError);
        $this->_getContainer()->getUtilsView()->addErrorToDisplay($oEx, false, true);

        //Redirect to user step
        $this->_getContainer()->getUtils()->redirect($oConfig->getShopSecureHomeUrl().'cl=basket', false);
    }

    /**
     * Clears amazon pay variables.
     *
     * @return mixed
     */
    public function render()
    {
        $sClass = $this->_getContainer()->getConfig()->getRequestParameter('cl');

        //If user was let to change payment, don't let him do other shit, just payment selection
        if ($sClass !== 'order'
            && $sClass !== 'thankyou'
            && (bool)$this->_getContainer()->getSession()->getVariable('blAmazonSyncChangePayment') === true
        ) {
            $this->cleanAmazonPay();
        }

        return parent::render();
    }
}

