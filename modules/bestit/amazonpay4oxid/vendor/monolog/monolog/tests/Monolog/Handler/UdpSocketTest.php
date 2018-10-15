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
use Monolog\Handler\SyslogUdp\UdpSocket;

/**
 * @requires extension sockets
 */
class UdpSocketTest extends TestCase
{
    public function testWeDoNotTruncateShortMessages()
    {
        $socket = $this->getMock('\Monolog\Handler\SyslogUdp\UdpSocket', array('send'), array('lol', 'lol'));

        $socket->expects($this->at(0))
            ->method('send')
            ->with("HEADER: The quick brown fox jumps over the lazy dog");

        $socket->write("The quick brown fox jumps over the lazy dog", "HEADER: ");
    }

    public function testLongMessagesAreTruncated()
    {
        $socket = $this->getMock('\Monolog\Handler\SyslogUdp\UdpSocket', array('send'), array('lol', 'lol'));

        $truncatedString = str_repeat("derp", 16254).'d';

        $socket->expects($this->exactly(1))
            ->method('send')
            ->with("HEADER" . $truncatedString);

        $longString = str_repeat("derp", 20000);

        $socket->write($longString, "HEADER");
    }

    public function testDoubleCloseDoesNotError()
    {
        $socket = new UdpSocket('127.0.0.1', 514);
        $socket->close();
        $socket->close();
    }

    /**
     * @expectedException LogicException
     */
    public function testWriteAfterCloseErrors()
    {
        $socket = new UdpSocket('127.0.0.1', 514);
        $socket->close();
        $socket->write('foo', "HEADER");
    }
}
