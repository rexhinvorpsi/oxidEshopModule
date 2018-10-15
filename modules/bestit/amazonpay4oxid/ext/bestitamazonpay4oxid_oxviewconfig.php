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
 * Class bestitAmazonPay4Oxid_oxViewcCnfig
 */
class bestitAmazonPay4Oxid_oxViewConfig extends bestitAmazonPay4Oxid_oxViewConfig_parent
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
     * Method checks if Amazon pay is active and can be used
     *
     * @return boolean true/false
     */
    public function getAmazonPayIsActive()
    {
        return $this->_getContainer()->getModule()->isActive();
    }

    /**
     * Returns Amazon Model class property by given property name
     *
     * @param string $sPropertyName property name
     *
     * @return mixed
     */
    public function getAmazonProperty($sPropertyName)
    {
        return $this->_getContainer()->getClient()->getAmazonProperty($sPropertyName);
    }

    /**
     * Returns Amazon config value
     *
     * @param string $sConfigVariable Config variable name
     *
     * @return mixed
     */
    public function getAmazonConfigValue($sConfigVariable)
    {
        return $this->_getContainer()->getConfig()->getConfigParam($sConfigVariable);
    }

    /**
     * Method checks if Amazon Login is active and can be used
     *
     * @return boolean true/false
     */
    public function getAmazonLoginIsActive()
    {
        return $this->_getContainer()->getLoginClient()->isActive();
    }

    /**
     * Method checks if Amazon Login is active and can be used
     *
     * @return boolean true/false
     */
    public function showAmazonLoginButton()
    {
        return $this->_getContainer()->getLoginClient()->showAmazonLoginButton();
    }

    /**
     * Method checks if Amazon Pay is active and can be used
     *
     * @return boolean true/false
     */
    public function showAmazonPayButton()
    {
        return $this->_getContainer()->getLoginClient()->showAmazonPayButton();
    }

    /**
     * Method returns language for Amazon GUI elements
     *
     * @return string
     */
    public function getAmazonLanguage()
    {
        return $this->_getContainer()->getLoginClient()->getAmazonLanguage();
    }

    /**
     * Forces to return shop self link if Amazon Login is active and we already have ORO
     * Method is dedicated to stay always in checkout process under SSL
     *
     * @return string
     */
    public function getSelfLink()
    {
        if ((bool)$this->_getContainer()->getConfig()->getConfigParam('sSSLShopURL') === true
            && !$this->isAdmin()
            && $this->getAmazonLoginIsActive()
        ) {
            return $this->getSslSelfLink();
        }

        return parent::getSelfLink();
    }

    /**
     * Forces to return basket link if Amazon Login is active and we already have ORO in SSL
     *
     * @return string
     */
    public function getBasketLink()
    {
        if ($this->getAmazonLoginIsActive() === true) {
            $sValue = $this->getViewConfigParam('basketlink');

            if ((string)$sValue === '') {
                $sValue = $this->_getContainer()->getConfig()->getShopSecureHomeUrl().'cl=basket';
                $this->setViewConfigParam('basketlink', $sValue);
            }

            return $sValue;
        }

        return parent::getBasketLink();
    }
}

