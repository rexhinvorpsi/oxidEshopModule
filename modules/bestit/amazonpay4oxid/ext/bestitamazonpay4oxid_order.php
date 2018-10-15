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
 * Class bestitAmazonPay4Oxid_order
 */
class bestitAmazonPay4Oxid_order extends bestitAmazonPay4Oxid_order_parent
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
     * @param string $sError
     * @param string $sRedirectUrl
     */
    protected function _setErrorAndRedirect($sError, $sRedirectUrl)
    {
        /** @var oxUserException $oEx */
        $oEx = $this->_getContainer()->getObjectFactory()->createOxidObject('oxUserException');
        $oEx->setMessage($sError);
        $this->_getContainer()->getUtilsView()->addErrorToDisplay($oEx, false, true);
        $this->_getContainer()->getUtils()->redirect($sRedirectUrl, false);
    }
    
    public function render()
    {
        $sTemplate = parent::render();
        $oPayment = $this->getPayment();

        //payment is set and not oxempty if amazon selected?
        if ($oPayment !== false) {
            $oConfig = $this->_getContainer()->getConfig();
            $sPaymentId = (string)$this->getPayment()->getId();
            $sAmazonOrderReferenceId = (string)$this->_getContainer()
                ->getSession()->getVariable('amazonOrderReferenceId');

            if ($sAmazonOrderReferenceId !== '') {
                if ($sPaymentId === 'oxempty') {
                    $this->_setErrorAndRedirect(
                        'BESTITAMAZONPAY_NO_PAYMENTS_FOR_SHIPPING_ADDRESS',
                        $oConfig->getShopSecureHomeUrl().'cl=user'
                    );

                    return $sTemplate;
                } elseif ($sPaymentId === 'bestitamazon'
                    && (string)$oConfig->getRequestParameter('fnc') !== 'execute'
                    && (string)$oConfig->getRequestParameter('action') !== 'changePayment'
                ) {
                    //Send Order reference details to Amazon if payment id is bestitamazon and amazonreferenceid exists
                    //Send SetOrderReferenceDetails request
                    $oData = $this->_getContainer()->getClient()->setOrderReferenceDetails($this->getBasket());
                    $oReferenceDetails = isset($oData->SetOrderReferenceDetailsResult->OrderReferenceDetails)
                        ? $oData->SetOrderReferenceDetailsResult->OrderReferenceDetails : null;

                    //If payment method is not valid to choose
                    if ($oReferenceDetails !== null
                        && (string)$oReferenceDetails->Constraints->Constraint->ConstraintID === 'PaymentMethodNotAllowed'
                    ) {
                        $this->_setErrorAndRedirect(
                            'BESTITAMAZONPAY_CHANGE_PAYMENT',
                            $oConfig->getShopSecureHomeUrl().'cl=payment'
                        );
                        return $sTemplate;
                    }

                    //If there's some other unexpected error
                    if ($oReferenceDetails === null
                        || (string)$oReferenceDetails->OrderReferenceStatus->State !== 'Draft'
                    ) {
                        $this->_getContainer()->getUtils()->redirect(
                            $oConfig->getShopSecureHomeUrl().'cl=user&fnc=cleanAmazonPay',
                            false
                        );
                        return $sTemplate;
                    }
                }
            } elseif ($sPaymentId === 'bestitamazon') {
                // If selected payment was bestitamazon but there's no amazonreferenceid,
                // redirect back to second step and show message
                $this->_setErrorAndRedirect(
                    'BESTITAMAZONPAY_CHANGE_PAYMENT',
                    $oConfig->getShopSecureHomeUrl().'cl=basket'
                );
            }
        }

        return $sTemplate;
    }
}