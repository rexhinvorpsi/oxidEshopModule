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

use Exception;
use Monolog\TestCase;
use Monolog\Logger;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @author Erik Johansson <erik.pm.johansson@gmail.com>
 * @see    https://rollbar.com/docs/notifier/rollbar-php/
 *
 * @coversDefaultClass Monolog\Handler\RollbarHandler
 */
class RollbarHandlerTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $rollbarNotifier;

    /**
     * @var array
     */
    public $reportedExceptionArguments = null;

    protected function setUp()
    {
        parent::setUp();

        $this->setupRollbarNotifierMock();
    }

    /**
     * When reporting exceptions to Rollbar the
     * level has to be set in the payload data
     */
    public function testExceptionLogLevel()
    {
        $handler = $this->createHandler();

        $handler->handle($this->createExceptionRecord(Logger::DEBUG));

        $this->assertEquals('debug', $this->reportedExceptionArguments['payload']['level']);
    }

    private function setupRollbarNotifierMock()
    {
        $this->rollbarNotifier = $this->getMockBuilder('RollbarNotifier')
            ->setMethods(array('report_message', 'report_exception', 'flush'))
            ->getMock();

        $that = $this;

        $this->rollbarNotifier
            ->expects($this->any())
            ->method('report_exception')
            ->willReturnCallback(function ($exception, $context, $payload) use ($that) {
                $that->reportedExceptionArguments = compact('exception', 'context', 'payload');
            });
    }

    private function createHandler()
    {
        return new RollbarHandler($this->rollbarNotifier, Logger::DEBUG);
    }

    private function createExceptionRecord($level = Logger::DEBUG, $message = 'test', $exception = null)
    {
        return $this->getRecord($level, $message, array(
            'exception' => $exception ?: new Exception()
        ));
    }
}
