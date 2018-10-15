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

use Monolog\Logger;
use Monolog\TestCase;

class MailHandlerTest extends TestCase
{
    /**
     * @covers Monolog\Handler\MailHandler::handleBatch
     */
    public function testHandleBatch()
    {
        $formatter = $this->getMock('Monolog\\Formatter\\FormatterInterface');
        $formatter->expects($this->once())
            ->method('formatBatch'); // Each record is formatted

        $handler = $this->getMockForAbstractClass('Monolog\\Handler\\MailHandler');
        $handler->expects($this->once())
            ->method('send');
        $handler->expects($this->never())
            ->method('write'); // write is for individual records

        $handler->setFormatter($formatter);

        $handler->handleBatch($this->getMultipleRecords());
    }

    /**
     * @covers Monolog\Handler\MailHandler::handleBatch
     */
    public function testHandleBatchNotSendsMailIfMessagesAreBelowLevel()
    {
        $records = array(
            $this->getRecord(Logger::DEBUG, 'debug message 1'),
            $this->getRecord(Logger::DEBUG, 'debug message 2'),
            $this->getRecord(Logger::INFO, 'information'),
        );

        $handler = $this->getMockForAbstractClass('Monolog\\Handler\\MailHandler');
        $handler->expects($this->never())
            ->method('send');
        $handler->setLevel(Logger::ERROR);

        $handler->handleBatch($records);
    }

    /**
     * @covers Monolog\Handler\MailHandler::write
     */
    public function testHandle()
    {
        $handler = $this->getMockForAbstractClass('Monolog\\Handler\\MailHandler');

        $record = $this->getRecord();
        $records = array($record);
        $records[0]['formatted'] = '['.$record['datetime']->format('Y-m-d H:i:s').'] test.WARNING: test [] []'."\n";

        $handler->expects($this->once())
            ->method('send')
            ->with($records[0]['formatted'], $records);

        $handler->handle($record);
    }
}
