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

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\TestCase;
use Monolog\Logger;
use InvalidArgumentException;

function mail($to, $subject, $message, $additional_headers = null, $additional_parameters = null)
{
    $GLOBALS['mail'][] = func_get_args();
}

class NativeMailerHandlerTest extends TestCase
{
    protected function setUp()
    {
        $GLOBALS['mail'] = array();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorHeaderInjection()
    {
        $mailer = new NativeMailerHandler('spammer@example.org', 'dear victim', "receiver@example.org\r\nFrom: faked@attacker.org");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetterHeaderInjection()
    {
        $mailer = new NativeMailerHandler('spammer@example.org', 'dear victim', 'receiver@example.org');
        $mailer->addHeader("Content-Type: text/html\r\nFrom: faked@attacker.org");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetterArrayHeaderInjection()
    {
        $mailer = new NativeMailerHandler('spammer@example.org', 'dear victim', 'receiver@example.org');
        $mailer->addHeader(array("Content-Type: text/html\r\nFrom: faked@attacker.org"));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetterContentTypeInjection()
    {
        $mailer = new NativeMailerHandler('spammer@example.org', 'dear victim', 'receiver@example.org');
        $mailer->setContentType("text/html\r\nFrom: faked@attacker.org");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetterEncodingInjection()
    {
        $mailer = new NativeMailerHandler('spammer@example.org', 'dear victim', 'receiver@example.org');
        $mailer->setEncoding("utf-8\r\nFrom: faked@attacker.org");
    }

    public function testSend()
    {
        $to = 'spammer@example.org';
        $subject = 'dear victim';
        $from = 'receiver@example.org';

        $mailer = new NativeMailerHandler($to, $subject, $from);
        $mailer->handleBatch(array());

        // batch is empty, nothing sent
        $this->assertEmpty($GLOBALS['mail']);

        // non-empty batch
        $mailer->handle($this->getRecord(Logger::ERROR, "Foo\nBar\r\n\r\nBaz"));
        $this->assertNotEmpty($GLOBALS['mail']);
        $this->assertInternalType('array', $GLOBALS['mail']);
        $this->assertArrayHasKey('0', $GLOBALS['mail']);
        $params = $GLOBALS['mail'][0];
        $this->assertCount(5, $params);
        $this->assertSame($to, $params[0]);
        $this->assertSame($subject, $params[1]);
        $this->assertStringEndsWith(" test.ERROR: Foo Bar  Baz [] []\n", $params[2]);
        $this->assertSame("From: $from\r\nContent-type: text/plain; charset=utf-8\r\n", $params[3]);
        $this->assertSame('', $params[4]);
    }

    public function testMessageSubjectFormatting()
    {
        $mailer = new NativeMailerHandler('to@example.org', 'Alert: %level_name% %message%', 'from@example.org');
        $mailer->handle($this->getRecord(Logger::ERROR, "Foo\nBar\r\n\r\nBaz"));
        $this->assertNotEmpty($GLOBALS['mail']);
        $this->assertInternalType('array', $GLOBALS['mail']);
        $this->assertArrayHasKey('0', $GLOBALS['mail']);
        $params = $GLOBALS['mail'][0];
        $this->assertCount(5, $params);
        $this->assertSame('Alert: ERROR Foo Bar  Baz', $params[1]);
    }
}
