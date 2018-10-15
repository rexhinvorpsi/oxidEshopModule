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
 * Class bestitAmazonPay4Oxid_oxmail
 */
class bestitAmazonPay4Oxid_oxEmail extends bestitAmazonPay4Oxid_oxEmail_parent
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
     * Mail template
     *
     * @var string
     */
    protected $_sInvalidPaymentEmailTemplate = "bestitamazonpay4oxid_invalidpayment.tpl";
    
    /**
     * Mail template
     *
     * @var string
     */
    protected $_sRejectedPaymentEmailTemplate = "bestitamazonpay4oxid_rejectedpayment.tpl";

    /**
     * @param oxOrder $oOrder
     * @param string  $sTemplate
     * @param string  $sSubject
     *
     * @return bool
     */
    private function _baseMailSetup($oOrder, $sTemplate, $sSubject)
    {
        $oConfig = $this->_getContainer()->getConfig();

        $iOrderLang = $this->_getContainer()->getLoginClient()->getOrderLanguageId($oOrder);
        $oShop = $this->_getShop($iOrderLang);

        //set mail params (from, fromName, smtp)
        $this->_setMailParams($oShop);

        //create messages
        $oLang = $this->_getContainer()->getLanguage();
        $oSmarty = $this->_getSmarty();

        $this->setViewData('order', $oOrder);
        $this->setViewData('shopTemplateDir', $oConfig->getTemplateDir(false));

        // Process view data array through oxoutput processor
        $this->_processViewArray();

        // dodger #1469 - we need to patch security here as we do not use standard template dir, so smarty stops working
        $aStore['INCLUDE_ANY'] = $oSmarty->security_settings['INCLUDE_ANY'];
        //V send email in order language
        $iOldTplLang = $oLang->getTplLanguage();
        $iOldBaseLang = $oLang->getTplLanguage();
        $oLang->setTplLanguage($iOrderLang);
        $oLang->setBaseLanguage($iOrderLang);
        $oSmarty->security_settings['INCLUDE_ANY'] = true;
        // force non admin to get correct paths (tpl, img)
        $oConfig->setAdminMode(false);

        $this->setBody($oSmarty->fetch($sTemplate));
        //Set subject
        $this->setSubject($oLang->translateString($sSubject));

        $oConfig->setAdminMode(true);
        $oLang->setTplLanguage($iOldTplLang);
        $oLang->setBaseLanguage($iOldBaseLang);

        // set it back
        $oSmarty->security_settings['INCLUDE_ANY'] = $aStore['INCLUDE_ANY'];

        $sFullName = $oOrder->getFieldData('oxbillfname').' '.$oOrder->getFieldData('oxbilllname');

        $this->setRecipient($oOrder->getFieldData('oxbillemail'), $sFullName);
        $this->setReplyTo($oShop->getFieldData('oxorderemail'), $oShop->getFieldData('oxname'));

        return $this->send();
    }

    /**
     * Sets mailer additional settings and sends Amazon Invalid payment mail to user.
     * Returns true on success.
     *
     * @param oxOrder $oOrder order object
     * @param string $sSubject user defined subject [optional]
     *
     * @return bool
     */
    public function sendAmazonInvalidPaymentEmail($oOrder, $sSubject = null)
    {
        return $this->_baseMailSetup(
            $oOrder,
            $this->_sInvalidPaymentEmailTemplate,
            'BESTITAMAZONPAY_EMAIL_SUBJECT_INVALID_PAYMENT'
        );
    }


    /**
     * Sets mailer additional settings and sends Amazon Rejected payment mail to user.
     * Returns true on success.
     *
     * @param oxOrder $oOrder order object
     * @param string $sSubject user defined subject [optional]
     *
     * @return bool
     */
    public function sendAmazonRejectedPaymentEmail($oOrder, $sSubject = null)
    {
        return $this->_baseMailSetup(
            $oOrder,
            $this->_sRejectedPaymentEmailTemplate,
            'BESTITAMAZONPAY_EMAIL_SUBJECT_REJECTED_PAYMENT'
        );
    }
}