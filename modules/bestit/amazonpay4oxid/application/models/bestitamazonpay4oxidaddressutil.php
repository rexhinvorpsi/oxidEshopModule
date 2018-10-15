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
 * Class bestitAmazonPay4OxidAddressUtil
 */
class bestitAmazonPay4OxidAddressUtil extends bestitAmazonPay4OxidContainer
{
    /**
     * Returns Parsed address from Amazon by specific rules
     *
     * @param object $oAmazonData Address object
     *
     * @return array Parsed Address
     */
    public function parseAmazonAddress($oAmazonData)
    {
        //Cast to array
        $aResult = (array)$oAmazonData;

        //Parsing first and last names
        $aFullName = explode(' ', trim($oAmazonData->Name));
        $aResult['LastName'] = array_pop($aFullName);
        $aResult['FirstName'] = implode(' ', $aFullName);

        $sTable = getViewName('oxcountry');
        $sSql = "SELECT OXID
            FROM {$sTable}
            WHERE OXISOALPHA2 = " . $this->getDatabase()->quote($oAmazonData->CountryCode);

        //Country ID
        $aResult['CountryId'] = $this->getDatabase()->getOne($sSql);

        //Parsing address
        $aAddress = array();
        $aResult['CompanyName'] = '';

        if (!empty($oAmazonData->AddressLine3)) {
            $aAddress = $this->_parseSingleAddress($oAmazonData->AddressLine3);
            $aResult['CompanyName'] = trim($oAmazonData->AddressLine1 . ' ' . $oAmazonData->AddressLine2);
        } else if (!empty($oAmazonData->AddressLine2)) {
            $aAddress = $this->_parseSingleAddress($oAmazonData->AddressLine2);
            $aResult['CompanyName'] = $oAmazonData->AddressLine1;
        } else if (!empty($oAmazonData->AddressLine1)) {
            $aAddress = $this->_parseSingleAddress($oAmazonData->AddressLine1);
        }

        $aResult['Street'] = isset($aAddress[1]) ? $aAddress[1] : '';
        $aResult['StreetNr'] = isset($aAddress[2]) ? $aAddress[2] : '';
        $aResult['AddInfo'] = isset($aAddress[3]) ? $aAddress[3] : '';

        //If shop runs in non UTF-8 mode encode values to ANSI
        if ($this->getConfig()->isUtf() === false) {
            foreach ($aResult as $sKey => $sValue) {
                $aResult[$sKey] = $this->encodeString($sValue);
            }
        }

        return $aResult;
    }


    /**
     * Returns parsed Street name and Street number in array
     *
     * @param string $sString Full address
     *
     * @return string
     */
    protected function _parseSingleAddress($sString)
    {
        preg_match('/\s*([^\d]*[^\d\s])\s*(\d[^\s]*)\s*(.*)/', $sString, $aResult);

        return $aResult;
    }


    /**
     * If shop is using non-Utf8 chars, encode string according used encoding
     *
     * @param string $sString the string to encode
     *
     * @return string encoded string
     */
    public function encodeString($sString)
    {
        //If shop is running in UTF-8 nothing to do here
        if ($this->getConfig()->isUtf() === true) {
            return $sString;
        }

        $sShopEncoding = $this->getLanguage()->translateString('charset');
        return iconv('UTF-8', $sShopEncoding, $sString);
    }
}
