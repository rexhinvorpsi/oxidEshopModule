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

use AmazonPay\IpnHandler;

/**
 * Class bestitAmazonPay4OxidObjectFactory
 */
class bestitAmazonPay4OxidObjectFactory
{
    /**
     * Returns a new object instance.
     *
     * @param string $sClass
     *
     * @return object
     */
    public function createOxidObject($sClass)
    {
        return oxNew($sClass);
    }

    /**
     * @param array  $aHeaders
     * @param string $sBody
     *
     * @return IpnHandler
     */
    public function createIpnHandler(array $aHeaders, $sBody)
    {
        return new IpnHandler($aHeaders, $sBody);
    }
}
