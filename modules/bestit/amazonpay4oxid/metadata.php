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


$sMetadataVersion = '1.1';

require_once(dirname(__FILE__).'/application/controllers/admin/bestitamazonpay4oxid_init.php');
$sCurrentVersion = (isset($blPreventVersionCheck) && $blPreventVersionCheck === true) ?
    null : bestitAmazonPay4Oxid_init::getCurrentVersion();

/**
 * Module information
 */
$aModule = array(
    'id' => 'bestitamazonpay4oxid',
    'title' => 'Amazon Pay & Login 4 OXID by BESTIT',
    'description' => array(
        'en' => 'Amazon Pay & Login for OXID eShop<br/>
        IPN address:  [https://www.yourdomain.com]/index.php?cl=bestitamazonipn[&shp=X]<br/>
        CRON address: [http://www.yourdomain.com]/index.php?cl=bestitamazoncron[&shp=X]<br/>
        Allowed JavaScript Origins: [http://www.yourdomain.com]<br/><br/>
        Please be aware: Setting "Capture handling" to "Direct Capture after Authorize" requires prior approval from Amazon Pay!<br/>
		Documentation: https://bestitcon.zendesk.com/hc/de/articles/115001478125-Dokumentation-AmazonPay4OXID<br/>
		<b style="color: red">If you update from a previous version you must deactivate and activate the plugin again</b>
        ',
        'de' => 'Amazon Pay & Login für OXID eShop<br/>
        IPN address:  [https://www.yourdomain.com]/index.php?cl=bestitamazonipn[&shp=X]<br/>
        CRON address: [http://www.yourdomain.com]/index.php?cl=bestitamazoncron[&shp=X]<br/>
        Allowed JavaScript Origins: [http://www.yourdomain.com]<br/><br/>
        Achtung: Das "Capture Handling" darf nur dann auf die Einstellung "Direktes Capture nach Authorize" gestellt werden, wenn dafür eine Freigabe seitens Amazon Pay eingeholt wurde!<br/>
		Dokumentation: https://bestitcon.zendesk.com/hc/de/articles/115001478125-Dokumentation-AmazonPay4OXID<br/>
		<b style="color: red">Wenn Sie das Modul von einer vorhergehenden Version updaten muss das Module deaktivert und erneut aktiviert werden</b>'
    ),
    'thumbnail' => 'bestitamazonpay4oxid_logo.png',
    'version' => '2.5.1',
    'author' => 'best it GmbH & Co. KG',
    'url' => 'http://www.bestit-online.de',
    'email' => 'support@bestit-online.de',
    'extend' => array(
        'oxviewconfig' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_oxviewconfig',
        'user' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_user',
        'oxcmp_basket' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_oxcmp_basket',
        'oxcmp_user' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_oxcmp_user',
        'payment' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_payment',
        'oxdeliverysetlist' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_oxdeliverysetlist',
        'order' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_order',
        'oxorder' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_oxorder',
        'thankyou' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_thankyou',
        'order_overview' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_order_overview',
        'order_main' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_order_main',
        'oxemail' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_oxemail',
        'oxsession' => 'bestit/amazonpay4oxid/ext/bestitamazonpay4oxid_oxsession',
    ),
    'files' => array(
        'bestitamazonpay4oxid_init' => 'bestit/amazonpay4oxid/application/controllers/admin/bestitamazonpay4oxid_init.php',
        'bestitamazonpay4oxid_main' => 'bestit/amazonpay4oxid/application/controllers/admin/bestitamazonpay4oxid_main.php',
        'bestitamazonipn' => 'bestit/amazonpay4oxid/application/controllers/bestitamazonipn.php',
        'bestitamazoncron' => 'bestit/amazonpay4oxid/application/controllers/bestitamazoncron.php',
        'bestitamazonpay4oxid' => 'bestit/amazonpay4oxid/application/models/bestitamazonpay4oxid.php',
        'bestitamazonpay4oxidaddressutil' => 'bestit/amazonpay4oxid/application/models/bestitamazonpay4oxidaddressutil.php',
        'bestitamazonpay4oxidclient' => 'bestit/amazonpay4oxid/application/models/bestitamazonpay4oxidclient.php',
        'bestitamazonpay4oxidcontainer' => 'bestit/amazonpay4oxid/application/models/bestitamazonpay4oxidcontainer.php',
        'bestitamazonpay4oxidipnhandler' => 'bestit/amazonpay4oxid/application/models/bestitamazonpay4oxidipnhandler.php',
        'bestitamazonpay4oxidloginclient' => 'bestit/amazonpay4oxid/application/models/bestitamazonpay4oxidloginclient.php',
        'bestitamazonpay4oxidobjectfactory' => 'bestit/amazonpay4oxid/application/models/bestitamazonpay4oxidobjectfactory.php'
    ),
    'blocks' => array(
        array(
            'template' => 'page/checkout/basket.tpl',
            'block' => 'basket_btn_next_top', // flow + azure
            'file' => 'application/blocks/bestitamazonpay4oxid_paybutton.tpl'
        ),
        array(
            'template' => 'page/checkout/user.tpl',
            'block' => 'checkout_user_main', // flow + azure
            'file' => 'application/blocks/bestitamazonpay4oxid_user.tpl'
        ),
        array(
            'template' => 'page/checkout/inc/options.tpl',
            'block' => 'checkout_user_options', // flow + azure
            'file' => 'application/blocks/bestitamazonpay4oxid_paybutton.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block' => 'select_payment', // flow + azure
            'file' => 'application/blocks/bestitamazonpay4oxid_payment.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block' => 'checkout_payment_nextstep', // flow + azure
            'file' => 'application/blocks/bestitamazonpay4oxid_paybutton.tpl'
        ),
        array(
            'template' => 'page/checkout/order.tpl',
            'block' => 'checkout_order_address', // flow + azure
            'file' => 'application/blocks/bestitamazonpay4oxid_order_address.tpl'
        ),
        array(
            'template' => 'page/checkout/order.tpl',
            'block' => 'shippingAndPayment', // flow + azure
            'file' => 'application/blocks/bestitamazonpay4oxid_order_payment.tpl'
        ),
        array(
            'template' => 'layout/footer.tpl',
            'block' => 'footer_main', // flow + azure
            'file' => 'application/blocks/bestitamazonpay4oxid_loginbutton.tpl'
        ),

        //Just for Mobile templates
        array(
            'template' => 'page/checkout/basket.tpl',
            'block' => 'mb_basket_btn_next_bottom',
            'file' => 'application/blocks/bestitamazonpay4oxid_paybutton.tpl'
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block' => 'mb_select_payment',
            'file' => 'application/blocks/bestitamazonpay4oxid_payment.tpl'
        )
    ),
    'templates' => array(
        'bestitamazonpay4oxidcron.tpl' => 'bestit/amazonpay4oxid/application/views/cron/bestitamazonpay4oxidcron.tpl',
        'bestitamazonpay4oxid_main.tpl' => 'bestit/amazonpay4oxid/application/views/admin/tpl/bestitamazonpay4oxid_main.tpl',
        'bestitamazonpay4oxid_invalidpayment.tpl' => 'bestit/amazonpay4oxid/application/views/azure/tpl/email/html/bestitamazonpay4oxid_invalidpayment.tpl',
        'bestitamazonpay4oxid_rejectedpayment.tpl' => 'bestit/amazonpay4oxid/application/views/azure/tpl/email/html/bestitamazonpay4oxid_rejectedpayment.tpl',
    ),
    'settings' => array(
        array(
            'group' => 'bestitAmazonPay4OxidSettings',
            'name' => 'blAmazonSandboxActive',
            'type' => 'bool',
            'value' => 'true',
            'position' => '1'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidSettings',
            'name' => 'sAmazonSellerId',
            'type' => 'str',
            'value' => '',
            'position' => '2'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidSettings',
            'name' => 'sAmazonAWSAccessKeyId',
            'type' => 'str',
            'value' => '',
            'position' => '3'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidSettings',
            'name' => 'sAmazonSignature',
            'type' => 'password',
            'value' => '',
            'position' => '4'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidSettings',
            'name' => 'blAmazonLogging',
            'type' => 'bool',
            'value' => 'true',
            'position' => '5'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLoginSettings',
            'name' => 'blAmazonLoginActive',
            'type' => 'bool',
            'value' => 'true',
            'position' => '1'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLoginSettings',
            'name' => 'sAmazonLoginClientId',
            'type' => 'str',
            'value' => '',
            'position' => '2'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLoginSettings',
            'name' => 'sAmazonLoginButtonStyle',
            'type' => 'select',
            'value' => 'LwA-Gold',
            'position' => '3',
            'constrains' => 'LwA-LightGray|LwA-DarkGray|LwA-Gold|Login-LightGray|Login-DarkGray|Login-Gold'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLoginSettings',
            'name' => 'sAmazonPayButtonStyle',
            'type' => 'select',
            'value' => 'PwA-Gold',
            'position' => '4',
            'constrains' => 'PwA-LightGray|PwA-DarkGray|PwA-Gold|Pay-LightGray|Pay-DarkGray|Pay-Gold'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLocalization',
            'name' => 'sAmazonLocale',
            'type' => 'select',
            'value' => 'DE',
            'position' => '1',
            'constrains' => 'DE|UK|US|CUSTOM'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLocalization',
            'name' => 'sAmazonEndpointUrlCUSTOM',
            'type' => 'str',
            'value' => '',
            'position' => '2'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLocalization',
            'name' => 'sAmazonEndpointUrlCUSTOMSandbox',
            'type' => 'str',
            'value' => '',
            'position' => '3'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLocalization',
            'name' => 'sAmazonWidgetUrlCUSTOM',
            'type' => 'str',
            'value' => '',
            'position' => '4'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLocalization',
            'name' => 'sAmazonWidgetUrlCUSTOMSandbox',
            'type' => 'str',
            'value' => '',
            'position' => '5'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLocalization',
            'name' => 'sAmazonButtonUrlCUSTOM',
            'type' => 'str',
            'value' => '',
            'position' => '6'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLocalization',
            'name' => 'sAmazonButtonUrlCUSTOMSandbox',
            'type' => 'str',
            'value' => '',
            'position' => '7'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidLanguages',
            'name' => 'aAmazonLanguages',
            'type' => 'aarr',
            'value' => array('en' => 'en-GB', 'de' => 'de-DE', 'fr' => 'fr-FR', 'it' => 'it-IT', 'es' => 'es-ES'),
            'position' => '1'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidConfiguration',
            'name' => 'sAmazonMode',
            'type' => 'select',
            'value' => 'Sync',
            'position' => '1',
            'constrains' => 'Async|Sync'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidConfiguration',
            'name' => 'sAmazonAuthorize',
            'type' => 'select',
            'value' => 'IPN',
            'position' => '2',
            'constrains' => 'IPN|CRON'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidConfiguration',
            'name' => 'sAmazonCapture',
            'type' => 'select',
            'value' => 'SHIPPED',
            'position' => '3',
            'constrains' => 'SHIPPED|DIRECT'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidConfiguration',
            'name' => 'blAmazonERP',
            'type' => 'bool',
            'value' => 'false',
            'position' => '4'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidConfiguration',
            'name' => 'sAmazonERPModeStatus',
            'type' => 'str',
            'value' => 'AP-Pend',
            'position' => '5'
        ),
        array(
            'group' => 'bestitAmazonPay4OxidConfiguration',
            'name' => 'sSandboxSimulation',
            'type' => 'select',
            'value' => '',
            'position' => '6',
            'constrains' => '
                |SetOrderReferenceDetailsPaymentMethodNotAllowed
                |CloseOrderReferenceAmazonClosed
                |AuthorizeInvalidPaymentMethod
                |AuthorizeAmazonRejected
                |AuthorizeTransactionTimedOut
                |AuthorizeExpiredUnused
                |AuthorizeAmazonClosed
                |CapturePending
                |CaptureAmazonRejected
                |CaptureAmazonClosed
                |RefundAmazonRejected'
        )
    ),
    'events' => array(
        'onActivate' => 'bestitAmazonPay4Oxid_init::onActivate',
        'onDeactivate' => 'bestitAmazonPay4Oxid_init::onDeactivate'
    )
);

if ($sCurrentVersion !== null && version_compare($sCurrentVersion, $aModule['version'], '<')) {
    bestitAmazonPay4Oxid_init::flagForUpdate();
}