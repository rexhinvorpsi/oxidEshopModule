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

class WhatFailureGroupHandlerTest extends TestCase
{
    /**
     * @covers Monolog\Handler\WhatFailureGroupHandler::__construct
     * @expectedException InvalidArgumentException
     */
    public function testConstructorOnlyTakesHandler()
    {
        new WhatFailureGroupHandler(array(new TestHandler(), "foo"));
    }

    /**
     * @covers Monolog\Handler\WhatFailureGroupHandler::__construct
     * @covers Monolog\Handler\WhatFailureGroupHandler::handle
     */
    public function testHandle()
    {
        $testHandlers = array(new TestHandler(), new TestHandler());
        $handler = new WhatFailureGroupHandler($testHandlers);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        foreach ($testHandlers as $test) {
            $this->assertTrue($test->hasDebugRecords());
            $this->assertTrue($test->hasInfoRecords());
            $this->assertTrue(count($test->getRecords()) === 2);
        }
    }

    /**
     * @covers Monolog\Handler\WhatFailureGroupHandler::handleBatch
     */
    public function testHandleBatch()
    {
        $testHandlers = array(new TestHandler(), new TestHandler());
        $handler = new WhatFailureGroupHandler($testHandlers);
        $handler->handleBatch(array($this->getRecord(Logger::DEBUG), $this->getRecord(Logger::INFO)));
        foreach ($testHandlers as $test) {
            $this->assertTrue($test->hasDebugRecords());
            $this->assertTrue($test->hasInfoRecords());
            $this->assertTrue(count($test->getRecords()) === 2);
        }
    }

    /**
     * @covers Monolog\Handler\WhatFailureGroupHandler::isHandling
     */
    public function testIsHandling()
    {
        $testHandlers = array(new TestHandler(Logger::ERROR), new TestHandler(Logger::WARNING));
        $handler = new WhatFailureGroupHandler($testHandlers);
        $this->assertTrue($handler->isHandling($this->getRecord(Logger::ERROR)));
        $this->assertTrue($handler->isHandling($this->getRecord(Logger::WARNING)));
        $this->assertFalse($handler->isHandling($this->getRecord(Logger::DEBUG)));
    }

    /**
     * @covers Monolog\Handler\WhatFailureGroupHandler::handle
     */
    public function testHandleUsesProcessors()
    {
        $test = new TestHandler();
        $handler = new WhatFailureGroupHandler(array($test));
        $handler->pushProcessor(function ($record) {
            $record['extra']['foo'] = true;

            return $record;
        });
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasWarningRecords());
        $records = $test->getRecords();
        $this->assertTrue($records[0]['extra']['foo']);
    }

    /**
     * @covers Monolog\Handler\WhatFailureGroupHandler::handle
     */
    public function testHandleException()
    {
        $test = new TestHandler();
        $exception = new ExceptionTestHandler();
        $handler = new WhatFailureGroupHandler(array($exception, $test, $exception));
        $handler->pushProcessor(function ($record) {
            $record['extra']['foo'] = true;

            return $record;
        });
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasWarningRecords());
        $records = $test->getRecords();
        $this->assertTrue($records[0]['extra']['foo']);
    }
}

class ExceptionTestHandler extends TestHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(array $record)
    {
        parent::handle($record);

        throw new \Exception("ExceptionTestHandler::handle");
    }
}
