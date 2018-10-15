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
namespace AmazonPay;

require_once 'AmazonPay/IpnHandler.php';

class IpnHandlertest extends \PHPUnit_Framework_TestCase
{
    private $configParams = array(
                'cabundle_file'  => null,
                'proxy_host'     => null,
                'proxy_port'     => -1,
                'proxy_username' => null,
                'proxy_Password' => null
            );

    public function testConstructor()
    {
        try {
            $headers = array();
            $headers = array('ab'=>'abc');
            $body = 'abctest';

            $ipnHandler = new IpnHandler($headers,$body,$this->configParams);

        } catch (\Exception $expected) {
            $this->assertRegExp('/Error with message - header./i', strval($expected));
        }
        try {
            $headers['x-amz-sns-message-type'] = 'Notification';
            $body = 'abctest';

            $ipnHandler = new IpnHandler($headers,$body,$this->configParams);

        } catch (\Exception $expected) {
            $this->assertRegExp('/Error with message - content is not in json format./i', strval($expected));
        }
        try {
            $ConfigParams = array(
                'a' => 'A',
                'b' => 'B'
            );

            $ipnHandler = new IpnHandler(array(),null,$ConfigParams);

        } catch (\Exception $expected) {
            $this->assertRegExp('/is either not part of the configuration or has incorrect Key name./i', strval($expected));
        }
    }

    public function testValidateUrl()
    {
      $headers = array('x-amz-sns-message-type' => 'Notification');
      try {
        $body = '{"Type":"Notification", "Message":"Test", "MessageId":"Test", "Timestamp":"Test", "Subject":"Test", "TopicArn":"Test", "Signature":"Test", "SigningCertURL":"http://sns.us-east-1.amazonaws.com/SimpleNotificationService-bb750dd426d95ee9390147a5624348ee.pem"}';
        $ipnHandler = new IpnHandler($headers, $body, $this->configParams);
      } catch (\Exception $expected) {
        $this->assertRegExp('/The certificate is located on an invalid domain./i', strval($expected));
      }

      try {
        $body = '{"Type":"Notification", "Message":"Test", "MessageId":"Test", "Timestamp":"Test", "Subject":"Test", "TopicArn":"Test", "Signature":"Test", "SigningCertURL":"https://sns.us-east-1.amazonaws.com/SimpleNotificationService-bb750dd426d95ee9390147a5624348ee.exe"}';
        $ipnHandler = new IpnHandler($headers, $body, $this->configParams);
      } catch (\Exception $expected) {
        $this->assertRegExp('/The certificate is located on an invalid domain./i', strval($expected));
      }

      try {
        $body = '{"Type":"Notification", "Message":"Test", "MessageId":"Test", "Timestamp":"Test", "Subject":"Test", "TopicArn":"Test", "Signature":"Test", "SigningCertURL":"https://sns.us-east-1.example.com/SimpleNotificationService-bb750dd426d95ee9390147a5624348ee.pem"}';
        $ipnHandler = new IpnHandler($headers, $body, $this->configParams);
      } catch (\Exception $expected) {
        $this->assertRegExp('/The certificate is located on an invalid domain./i', strval($expected));
      }

      try {
        $body = '{"Type":"Notification", "Message":"Test", "MessageId":"Test", "Timestamp":"Test", "Subject":"Test", "TopicArn":"Test", "Signature":"Test", "SigningCertURL":"https://sni.us-east-1.amazonaws.com/SimpleNotificationService-bb750dd426d95ee9390147a5624348ee.pem"}';
        $ipnHandler = new IpnHandler($headers, $body, $this->configParams);
      } catch (\Exception $expected) {
        $this->assertRegExp('/The certificate is located on an invalid domain./i', strval($expected));
      }

      try {
        $body = '{"Type":"Notification", "Message":"Test", "MessageId":"Test", "Timestamp":"Test", "Subject":"Test", "TopicArn":"Test", "Signature":"Test", "SigningCertURL":"https://sns.us.amazonaws.com/SimpleNotificationService-bb750dd426d95ee9390147a5624348ee.pem"}';
        $ipnHandler = new IpnHandler($headers, $body, $this->configParams);
      } catch (\Exception $expected) {
        $this->assertRegExp('/The certificate is located on an invalid domain./i', strval($expected));
      }

      try {
        $body = '{"Type":"Notification", "Message":"Test", "MessageId":"Test", "Timestamp":"Test", "Subject":"Test", "TopicArn":"Test", "Signature":"Test", "SigningCertURL":"https://sns.us-east-1.amazonaws.com.com/SimpleNotificationService-bb750dd426d95ee9390147a5624348ee.pem"}';
        $ipnHandler = new IpnHandler($headers, $body, $this->configParams);
      } catch (\Exception $expected) {
        $this->assertRegExp('/The certificate is located on an invalid domain./i', strval($expected));
      }
    }
}
