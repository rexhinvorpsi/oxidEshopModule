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

/**
 * @author Alexey Karapetov <alexey@karapetov.com>
 */
class HandlerWrapperTest extends TestCase
{
    /**
     * @var HandlerWrapper
     */
    private $wrapper;

    private $handler;

    public function setUp()
    {
        parent::setUp();
        $this->handler = $this->getMock('Monolog\\Handler\\HandlerInterface');
        $this->wrapper = new HandlerWrapper($this->handler);
    }

    /**
     * @return array
     */
    public function trueFalseDataProvider()
    {
        return array(
            array(true),
            array(false),
        );
    }

    /**
     * @param $result
     * @dataProvider trueFalseDataProvider
     */
    public function testIsHandling($result)
    {
        $record = $this->getRecord();
        $this->handler->expects($this->once())
            ->method('isHandling')
            ->with($record)
            ->willReturn($result);

        $this->assertEquals($result, $this->wrapper->isHandling($record));
    }

    /**
     * @param $result
     * @dataProvider trueFalseDataProvider
     */
    public function testHandle($result)
    {
        $record = $this->getRecord();
        $this->handler->expects($this->once())
            ->method('handle')
            ->with($record)
            ->willReturn($result);

        $this->assertEquals($result, $this->wrapper->handle($record));
    }

    /**
     * @param $result
     * @dataProvider trueFalseDataProvider
     */
    public function testHandleBatch($result)
    {
        $records = $this->getMultipleRecords();
        $this->handler->expects($this->once())
            ->method('handleBatch')
            ->with($records)
            ->willReturn($result);

        $this->assertEquals($result, $this->wrapper->handleBatch($records));
    }

    public function testPushProcessor()
    {
        $processor = function () {};
        $this->handler->expects($this->once())
            ->method('pushProcessor')
            ->with($processor);

        $this->assertEquals($this->wrapper, $this->wrapper->pushProcessor($processor));
    }

    public function testPopProcessor()
    {
        $processor = function () {};
        $this->handler->expects($this->once())
            ->method('popProcessor')
            ->willReturn($processor);

        $this->assertEquals($processor, $this->wrapper->popProcessor());
    }

    public function testSetFormatter()
    {
        $formatter = $this->getMock('Monolog\\Formatter\\FormatterInterface');
        $this->handler->expects($this->once())
            ->method('setFormatter')
            ->with($formatter);

        $this->assertEquals($this->wrapper, $this->wrapper->setFormatter($formatter));
    }

    public function testGetFormatter()
    {
        $formatter = $this->getMock('Monolog\\Formatter\\FormatterInterface');
        $this->handler->expects($this->once())
            ->method('getFormatter')
            ->willReturn($formatter);

        $this->assertEquals($formatter, $this->wrapper->getFormatter());
    }
}
