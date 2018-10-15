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

use Gelf\Message;
use Monolog\TestCase;
use Monolog\Logger;
use Monolog\Formatter\GelfMessageFormatter;

class GelfHandlerTest extends TestCase
{
    public function setUp()
    {
        if (!class_exists('Gelf\Publisher') || !class_exists('Gelf\Message')) {
            $this->markTestSkipped("graylog2/gelf-php not installed");
        }
    }

    /**
     * @covers Monolog\Handler\GelfHandler::__construct
     */
    public function testConstruct()
    {
        $handler = new GelfHandler($this->getMessagePublisher());
        $this->assertInstanceOf('Monolog\Handler\GelfHandler', $handler);
    }

    protected function getHandler($messagePublisher)
    {
        $handler = new GelfHandler($messagePublisher);

        return $handler;
    }

    protected function getMessagePublisher()
    {
        return $this->getMock('Gelf\Publisher', array('publish'), array(), '', false);
    }

    public function testDebug()
    {
        $record = $this->getRecord(Logger::DEBUG, "A test debug message");
        $expectedMessage = new Message();
        $expectedMessage
            ->setLevel(7)
            ->setFacility("test")
            ->setShortMessage($record['message'])
            ->setTimestamp($record['datetime'])
        ;

        $messagePublisher = $this->getMessagePublisher();
        $messagePublisher->expects($this->once())
            ->method('publish')
            ->with($expectedMessage);

        $handler = $this->getHandler($messagePublisher);

        $handler->handle($record);
    }

    public function testWarning()
    {
        $record = $this->getRecord(Logger::WARNING, "A test warning message");
        $expectedMessage = new Message();
        $expectedMessage
            ->setLevel(4)
            ->setFacility("test")
            ->setShortMessage($record['message'])
            ->setTimestamp($record['datetime'])
        ;

        $messagePublisher = $this->getMessagePublisher();
        $messagePublisher->expects($this->once())
            ->method('publish')
            ->with($expectedMessage);

        $handler = $this->getHandler($messagePublisher);

        $handler->handle($record);
    }

    public function testInjectedGelfMessageFormatter()
    {
        $record = $this->getRecord(Logger::WARNING, "A test warning message");
        $record['extra']['blarg'] = 'yep';
        $record['context']['from'] = 'logger';

        $expectedMessage = new Message();
        $expectedMessage
            ->setLevel(4)
            ->setFacility("test")
            ->setHost("mysystem")
            ->setShortMessage($record['message'])
            ->setTimestamp($record['datetime'])
            ->setAdditional("EXTblarg", 'yep')
            ->setAdditional("CTXfrom", 'logger')
        ;

        $messagePublisher = $this->getMessagePublisher();
        $messagePublisher->expects($this->once())
            ->method('publish')
            ->with($expectedMessage);

        $handler = $this->getHandler($messagePublisher);
        $handler->setFormatter(new GelfMessageFormatter('mysystem', 'EXT', 'CTX'));
        $handler->handle($record);
    }
}
