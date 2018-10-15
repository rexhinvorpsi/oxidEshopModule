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
 * Class bestitAmazonPay4Oxid_payment
 */
class bestitAmazonPay4Oxid_payment extends bestitAmazonPay4Oxid_payment_parent
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
     * @param $sObjectId
     * @param $sAmazonOrderReferenceId
     */
    protected function _setObjectAmazonReferenceId($sObjectId, $sAmazonOrderReferenceId)
    {
        $sInsert = "INSERT INTO `bestitamazonobject2reference` 
            (`OXOBJECTID`, `AMAZONORDERREFERENCEID`) VALUES ('$sObjectId', '$sAmazonOrderReferenceId')
            ON DUPLICATE KEY UPDATE OXOBJECTID = OXOBJECTID";

        $this->_getContainer()->getDatabase()->execute($sInsert);
    }

    /**
     * @param $sObjectId
     *
     * @return false|string
     */
    protected function _getObjectAmazonReferenceId($sObjectId)
    {
        $sSelect = "SELECT `AMAZONORDERREFERENCEID` 
            FROM `bestitamazonobject2reference`
            WHERE `OXOBJECTID` = '$sObjectId'";

        return $this->_getContainer()->getDatabase()->getOne($sSelect);
    }

    /**
     * Creates user if user is not logged in, if user is logged in creates new shipping address
     *
     * @param object $oAmazonData User data received from Amazon WS
     */
    protected function _managePrimaryUserData($oAmazonData)
    {
        $oUser = $this->_getContainer()->getActiveUser();
        $oSession = $this->_getContainer()->getSession();

        //Parse data from Amazon for OXID
        $aParsedData = $this->_getContainer()->getAddressUtil()->parseAmazonAddress($oAmazonData);
        $aDataMap = array(
            'oxfname' => $aParsedData['FirstName'],
            'oxlname' => $aParsedData['LastName'],
            'oxcity' => $aParsedData['City'],
            'oxstateid' => $aParsedData['StateOrRegion'],
            'oxcountryid' => $aParsedData['CountryId'],
            'oxzip' => $aParsedData['PostalCode']
        );

        //If user is not logged, create new user and login it
        if ($oUser === false) {
            $sAmazonOrderReferenceId = $oSession->getVariable('amazonOrderReferenceId');

            /** @var oxUser $oUser */
            $oUser = $this->_getContainer()->getObjectFactory()->createOxidObject('oxUser');
            $oUser->assign(array_merge(
                $aDataMap,
                array(
                    'oxregister' => 0,
                    'oxshopid' => $this->_getContainer()->getConfig()->getShopId(),
                    'oxactive' => 1,
                    'oxusername' => $sAmazonOrderReferenceId . '@amazon.com'
                )
            ));

            if ($oUser->save() !== false) {
                $sUserId = $oUser->getId();

                //Set user id to session
                $oSession->setVariable('usr', $sUserId);

                //Add user to two default OXID groups
                $oUser->addToGroup('oxidnewcustomer');
                $oUser->addToGroup('oxidnotyetordered');

                $this->_setObjectAmazonReferenceId($sUserId, $sAmazonOrderReferenceId);
            }
        } else {
            $sUserId = $oUser->getId();
            $sUserAmazonOrderReferenceId = $this->_getObjectAmazonReferenceId($sUserId);
            $sAmazonOrderReferenceId = $oSession->getVariable('amazonOrderReferenceId');

            //If our logged in user is the one that was created by us before update details from Amazon WS
            //(Can be selected another user from Amazon Address widget)
            if ($sUserAmazonOrderReferenceId === $sAmazonOrderReferenceId) {
                $oUser->assign(array(
                    'oxcity' => $aParsedData['City'],
                    'oxcountryid' => $aParsedData['CountryId'],
                    'oxzip' => $aParsedData['PostalCode']
                ));
                $oUser->save();
            } else {
                //If we have logged in within Amazon Login for the first time, and user have not updated billing address
                if ((string)$oSession->getVariable('amazonLoginToken') !== ''
                    && (string)$oUser->getFieldData('oxstreet') === ''
                ) {
                    $oUser->assign(array_merge(
                        $aDataMap,
                        array(
                            'oxcompany' => $aParsedData['CompanyName'],
                            'oxfon' => $aParsedData['Phone'],
                            'oxstreet' => $aParsedData['Street'],
                            'oxstreetnr' => $aParsedData['StreetNr'],
                            'oxaddinfo' => $aParsedData['AddInfo']
                        )
                    ));
                    $oUser->save();
                }

                //If there exists registered user add Amazon address as users shipping address
                /** @var oxAddress $oDelAddress */
                $oDelAddress = $this->_getContainer()->getObjectFactory()->createOxidObject('oxAddress');

                //Maybe we have already shipping address added for this amazon reference ID. If yes then use it.
                /** @var oxAddress[] $aUserAddresses */
                $aUserAddresses = $oUser->getUserAddresses();

                foreach ($aUserAddresses as $oAddress) {
                    $sAddressId = $oAddress->getId();
                    $sAddressAmazonOrderReferenceId = $this->_getObjectAmazonReferenceId($sAddressId);

                    if ($sAddressAmazonOrderReferenceId === $sAmazonOrderReferenceId) {
                        $oDelAddress->load($sAddressId);
                        break;
                    }
                }

                //Add new shipping address to user and select it
                $oDelAddress->assign(array_merge(
                    $aDataMap,
                    array('oxuserid' => $oUser->getId())
                ));

                $sDeliveryAddressId = $oDelAddress->save();

                //Set another delivery address as shipping address
                $oSession->setVariable('blshowshipaddress', 1);
                $oSession->setVariable('deladrid', $sDeliveryAddressId);
                $this->_setObjectAmazonReferenceId($sDeliveryAddressId, $sAmazonOrderReferenceId);
            }
        }
    }
    
    /**
     * Get's primary user details and logins user if one is not logged in
     * Add's new address if user is logged in.
     */
    public function setPrimaryAmazonUserData()
    {
        $oUtils = $this->_getContainer()->getUtils();
        $sShopSecureHomeUrl = $this->_getContainer()->getConfig()->getShopSecureHomeUrl();

        //Get primary user data from Amazon
        $oData = $this->_getContainer()->getClient()->getOrderReferenceDetails();
        $oOrderReferenceDetail = isset($oData->GetOrderReferenceDetailsResult->OrderReferenceDetails)
            ? $oData->GetOrderReferenceDetailsResult->OrderReferenceDetails : null;

        if ($oOrderReferenceDetail === null
            || isset($oOrderReferenceDetail->Destination->PhysicalDestination) === false
        ) {
            $oUtils->redirect($sShopSecureHomeUrl.'cl=user&fnc=cleanAmazonPay', false);
            return;
        }

        //Creating and(or) logging user
        $sStatus = (string)$oOrderReferenceDetail->OrderReferenceStatus->State;

        if ($sStatus === 'Draft') {
            //Manage primary user data
            $oAmazonData = $oOrderReferenceDetail->Destination->PhysicalDestination;
            $this->_managePrimaryUserData($oAmazonData);

            //Recalculate basket to get shipping price for created user
            $this->_getContainer()->getSession()->getBasket()->onUpdate();

            //Redirect with registered user or new shipping address to payment page
            $oUtils->redirect($sShopSecureHomeUrl.'cl=payment', false);
            return;
        }

        $oUtils->redirect($sShopSecureHomeUrl.'cl=user&fnc=cleanAmazonPay', false);
    }

    /**
     * Set's order remark to session
     *
     * @return mixed
     */
    public function validatePayment()
    {
        $oSession = $this->_getContainer()->getSession();
        $oConfig = $this->_getContainer()->getConfig();

        //Don't do anything with order remark if we not under Amazon Pay
        if ((string)$oSession->getVariable('amazonOrderReferenceId') === ''
            || (string)$oConfig->getRequestParameter('paymentid') !== 'bestitamazon'
        ) {
            return parent::validatePayment();
        }

        // order remark
        $sOrderRemark = (string)$oConfig->getRequestParameter('order_remark', true);

        if ($sOrderRemark !== '') {
            $oSession->setVariable('ordrem', $sOrderRemark);
        } else {
            $oSession->deleteVariable('ordrem');
        }

        return parent::validatePayment();
    }


    /**
     * Template variable getter. Returns order remark
     *
     * @return string
     */
    public function getOrderRemark()
    {
        // if already connected, we can use the session
        if ($this->_getContainer()->getActiveUser() !== false) {
            $sOrderRemark = $this->_getContainer()->getSession()->getVariable('ordrem');
        } else {
            // not connected so nowhere to save, we're gonna use what we get from post
            $sOrderRemark = $this->_getContainer()->getConfig()->getRequestParameter('order_remark', true);
        }

        if (!empty($sOrderRemark)) {
            return $this->_getContainer()->getConfig()->checkParamSpecialChars($sOrderRemark);
        }

        return false;
    }
}
