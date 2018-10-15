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
use Monolog\Formatter\LineFormatter;

function error_log()
{
    $GLOBALS['error_log'][] = func_get_args();
}

class ErrorLogHandlerTest extends TestCase
{
    protected function setUp()
    {
        $GLOBALS['error_log'] = array();
    }

    /**
     * @covers Monolog\Handler\ErrorLogHandler::__construct
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The given message type "42" is not supported
     */
    public function testShouldNotAcceptAnInvalidTypeOnContructor()
    {
        new ErrorLogHandler(42);
    }

    /**
     * @covers Monolog\Handler\ErrorLogHandler::write
     */
    public function testShouldLogMessagesUsingErrorLogFuncion()
    {
        $type = ErrorLogHandler::OPERATING_SYSTEM;
        $handler = new ErrorLogHandler($type);
        $handler->setFormatter(new LineFormatter('%channel%.%level_name%: %message% %context% %extra%', null, true));
        $handler->handle($this->getRecord(Logger::ERROR, "Foo\nBar\r\n\r\nBaz"));

        $this->assertSame("test.ERROR: Foo\nBar\r\n\r\nBaz [] []", $GLOBALS['error_log'][0][0]);
        $this->assertSame($GLOBALS['error_log'][0][1], $type);

        $handler = new ErrorLogHandler($type, Logger::DEBUG, true, true);
        $handler->setFormatter(new LineFormatter(null, null, true));
        $handler->handle($this->getRecord(Logger::ERROR, "Foo\nBar\r\n\r\nBaz"));

        $this->assertStringMatchesFormat('[%s] test.ERROR: Foo', $GLOBALS['error_log'][1][0]);
        $this->assertSame($GLOBALS['error_log'][1][1], $type);

        $this->assertStringMatchesFormat('Bar', $GLOBALS['error_log'][2][0]);
        $this->assertSame($GLOBALS['error_log'][2][1], $type);

        $this->assertStringMatchesFormat('Baz [] []', $GLOBALS['error_log'][3][0]);
        $this->assertSame($GLOBALS['error_log'][3][1], $type);
    }
}
