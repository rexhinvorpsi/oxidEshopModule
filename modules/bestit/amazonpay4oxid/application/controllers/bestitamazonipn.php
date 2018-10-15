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

use Monolog\Logger;

/**
 * Class bestitAmazonIpn
 */
class bestitAmazonIpn extends oxUBase
{
    /**
     * @var string
     */
    protected $_sThisTemplate = 'bestitamazonpay4oxidcron.tpl';

    /**
     * @var string
     */
    protected $_sInput = 'php://input';

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
     * @param string $sError
     *
     * @return string
     */
    protected function _processError($sError)
    {
        $this->_getContainer()->getIpnHandler()->logIPNResponse(Logger::ERROR, $sError);
        $this->setViewData(array('sError' => $sError));
        return $this->_sThisTemplate;
    }

    /**
     * The controller entry point.
     *
     * @return string
     */
    public function render()
    {
        //If ERP mode is enabled do nothing, if IPN or CRON authorize unauthorized orders
        if ($this->_getContainer()->getConfig()->getConfigParam('blAmazonERP') === true) {
            return $this->_processError('IPN response handling disabled - ERP mode is ON (Module settings)');
        }

        //Check if IPN response handling is turned ON
        if ($this->_getContainer()->getConfig()->getConfigParam('sAmazonAuthorize') !== 'IPN') {
            return $this->_processError('IPN response handling disabled (Module settings)');
        }

        //Get SNS message
        $sBody = file_get_contents($this->_sInput);

        if ($sBody === '') {
            return $this->_processError('SNS message empty or Error while reading SNS message occurred');
        }

        //Perform IPN action
        if ($this->_getContainer()->getIpnHandler()->processIPNAction($sBody) !== true) {
            return $this->_processError('Error while handling Amazon response');
        }

        return $this->_sThisTemplate;
    }
}
