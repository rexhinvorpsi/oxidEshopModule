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

class BufferHandlerTest extends TestCase
{
    private $shutdownCheckHandler;

    /**
     * @covers Monolog\Handler\BufferHandler::__construct
     * @covers Monolog\Handler\BufferHandler::handle
     * @covers Monolog\Handler\BufferHandler::close
     */
    public function testHandleBuffers()
    {
        $test = new TestHandler();
        $handler = new BufferHandler($test);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $this->assertFalse($test->hasDebugRecords());
        $this->assertFalse($test->hasInfoRecords());
        $handler->close();
        $this->assertTrue($test->hasInfoRecords());
        $this->assertTrue(count($test->getRecords()) === 2);
    }

    /**
     * @covers Monolog\Handler\BufferHandler::close
     * @covers Monolog\Handler\BufferHandler::flush
     */
    public function testPropagatesRecordsAtEndOfRequest()
    {
        $test = new TestHandler();
        $handler = new BufferHandler($test);
        $handler->handle($this->getRecord(Logger::WARNING));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $this->shutdownCheckHandler = $test;
        register_shutdown_function(array($this, 'checkPropagation'));
    }

    public function checkPropagation()
    {
        if (!$this->shutdownCheckHandler->hasWarningRecords() || !$this->shutdownCheckHandler->hasDebugRecords()) {
            echo '!!! BufferHandlerTest::testPropagatesRecordsAtEndOfRequest failed to verify that the messages have been propagated' . PHP_EOL;
            exit(1);
        }
    }

    /**
     * @covers Monolog\Handler\BufferHandler::handle
     */
    public function testHandleBufferLimit()
    {
        $test = new TestHandler();
        $handler = new BufferHandler($test, 2);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $handler->handle($this->getRecord(Logger::WARNING));
        $handler->close();
        $this->assertTrue($test->hasWarningRecords());
        $this->assertTrue($test->hasInfoRecords());
        $this->assertFalse($test->hasDebugRecords());
    }

    /**
     * @covers Monolog\Handler\BufferHandler::handle
     */
    public function testHandleBufferLimitWithFlushOnOverflow()
    {
        $test = new TestHandler();
        $handler = new BufferHandler($test, 3, Logger::DEBUG, true, true);

        // send two records
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $this->assertFalse($test->hasDebugRecords());
        $this->assertCount(0, $test->getRecords());

        // overflow
        $handler->handle($this->getRecord(Logger::INFO));
        $this->assertTrue($test->hasDebugRecords());
        $this->assertCount(3, $test->getRecords());

        // should buffer again
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertCount(3, $test->getRecords());

        $handler->close();
        $this->assertCount(5, $test->getRecords());
        $this->assertTrue($test->hasWarningRecords());
        $this->assertTrue($test->hasInfoRecords());
    }

    /**
     * @covers Monolog\Handler\BufferHandler::handle
     */
    public function testHandleLevel()
    {
        $test = new TestHandler();
        $handler = new BufferHandler($test, 0, Logger::INFO);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $handler->handle($this->getRecord(Logger::WARNING));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->close();
        $this->assertTrue($test->hasWarningRecords());
        $this->assertTrue($test->hasInfoRecords());
        $this->assertFalse($test->hasDebugRecords());
    }

    /**
     * @covers Monolog\Handler\BufferHandler::flush
     */
    public function testFlush()
    {
        $test = new TestHandler();
        $handler = new BufferHandler($test, 0);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $handler->flush();
        $this->assertTrue($test->hasInfoRecords());
        $this->assertTrue($test->hasDebugRecords());
        $this->assertFalse($test->hasWarningRecords());
    }

    /**
     * @covers Monolog\Handler\BufferHandler::handle
     */
    public function testHandleUsesProcessors()
    {
        $test = new TestHandler();
        $handler = new BufferHandler($test);
        $handler->pushProcessor(function ($record) {
            $record['extra']['foo'] = true;

            return $record;
        });
        $handler->handle($this->getRecord(Logger::WARNING));
        $handler->flush();
        $this->assertTrue($test->hasWarningRecords());
        $records = $test->getRecords();
        $this->assertTrue($records[0]['extra']['foo']);
    }
}
