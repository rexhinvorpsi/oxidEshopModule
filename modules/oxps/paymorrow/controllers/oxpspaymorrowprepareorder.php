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
 * Class OxpsPaymorrowPrepareOrder
 */
class OxpsPaymorrowPrepareOrder extends oxUBase
{

    /**
     * A name for request/session fields to store selected payment method ID in.
     */
    const OXPS_PAYMENT_ID_FIELD = 'paymentid';

    /**
     * A name of POST field to store Paymorrow payment name.
     */
    const OXPS_PM_PAYMENT_NAME_FIELD = 'pm_paymentMethod_name';


    /**
     * Paymorrow function for Verifying Form Data against Paymorrow Services.
     * Also set selected payment method ID revealed by Paymorrow payment method name.
     */
    public function prepareOrder()
    {
        $this->setPaymorrowPaymentMethodId();

        /** @var OxpsPaymorrowRequestControllerProxy $pmGateWay */
        $pmGateWay = oxNew('OxpsPaymorrowRequestControllerProxy');

        $oUtils = oxRegistry::getUtils();
        $oUtils->setHeader("Content-Type: application/json");
        $oUtils->showMessageAndExit($pmGateWay->prepareOrder($_POST));
    }


    /**
     * Load payment instance by Paymorrow payment method name
     * and set it to both, request and session if not yet set.
     */
    protected function setPaymorrowPaymentMethodId()
    {
        /** @var oxPayment|OxpsPaymorrowOxPayment $payment */
        $payment = oxNew('oxPayment');
        $paymentIdField = self::OXPS_PAYMENT_ID_FIELD;
        $paymentName = (string) $this->getConfig()->getRequestParameter(self::OXPS_PM_PAYMENT_NAME_FIELD);

        if ($payment->loadByPaymorrowName($paymentName) and
            !$this->getConfig()->getRequestParameter($paymentIdField)
        ) {
            $this->appendPostData(array($paymentIdField => (string) $payment->getId()));
        }
    }

    /**
     * Add assoc array to POST request.
     *
     * @param array $data
     */
    protected function appendPostData(array $data)
    {
        $_POST = array_merge($_POST, $data);
    }
}
