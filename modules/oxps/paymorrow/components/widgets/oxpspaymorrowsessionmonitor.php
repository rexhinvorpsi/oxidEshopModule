<?php
/**
 * This file is part of OXID eSales Paymorrow module.
 *
 * OXID eSales Paymorrow module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eSales eVAT module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eSales eVAT module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2018
 */

/**
 * Class OxPsPaymorrowSessionMonitor.
 */
class OxPsPaymorrowSessionMonitor extends oxWidget
{

    /**
     * Widget template
     *
     * @var string
     */
    protected $_sThisTemplate = 'oxpspaymorrowsessionmonitor.tpl';


    /**
     * Returns resource URL.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getPaymorrowResourceControllerJavaScript()
    {
        return (string) str_replace('&amp;', '&', $this->getConfig()->getShopSecureHomeURL()) .
               'index.php?cl=oxpspaymorrowresource&fnc=getPaymorrowSessionMonitorJavaScript';
    }

    /**
     * Returns if view should be cached.
     *
     * @codeCoverageIgnore
     *
     * @return bool
     */
    public function isCacheable()
    {
        return false;
    }
}
