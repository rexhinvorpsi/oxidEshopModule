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

/**
 * @author Robert Kaufmann III <rok3@rok3.me>
 */
class LogEntriesHandlerTest extends TestCase
{
    /**
     * @var resource
     */
    private $res;

    /**
     * @var LogEntriesHandler
     */
    private $handler;

    public function testWriteContent()
    {
        $this->createHandler();
        $this->handler->handle($this->getRecord(Logger::CRITICAL, 'Critical write test'));

        fseek($this->res, 0);
        $content = fread($this->res, 1024);

        $this->assertRegexp('/testToken \[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] test.CRITICAL: Critical write test/', $content);
    }

    public function testWriteBatchContent()
    {
        $records = array(
            $this->getRecord(),
            $this->getRecord(),
            $this->getRecord(),
        );
        $this->createHandler();
        $this->handler->handleBatch($records);

        fseek($this->res, 0);
        $content = fread($this->res, 1024);

        $this->assertRegexp('/(testToken \[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] .* \[\] \[\]\n){3}/', $content);
    }

    private function createHandler()
    {
        $useSSL = extension_loaded('openssl');
        $args = array('testToken', $useSSL, Logger::DEBUG, true);
        $this->res = fopen('php://memory', 'a');
        $this->handler = $this->getMock(
            '\Monolog\Handler\LogEntriesHandler',
            array('fsockopen', 'streamSetTimeout', 'closeSocket'),
            $args
        );

        $reflectionProperty = new \ReflectionProperty('\Monolog\Handler\SocketHandler', 'connectionString');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->handler, 'localhost:1234');

        $this->handler->expects($this->any())
            ->method('fsockopen')
            ->will($this->returnValue($this->res));
        $this->handler->expects($this->any())
            ->method('streamSetTimeout')
            ->will($this->returnValue(true));
        $this->handler->expects($this->any())
            ->method('closeSocket')
            ->will($this->returnValue(true));
    }
}
