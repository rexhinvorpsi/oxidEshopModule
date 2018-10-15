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

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\TestCase;

/**
 * @coversDefaultClass \Monolog\Handler\FleepHookHandler
 */
class FleepHookHandlerTest extends TestCase
{
    /**
     * Default token to use in tests
     */
    const TOKEN = '123abc';

    /**
     * @var FleepHookHandler
     */
    private $handler;

    public function setUp()
    {
        parent::setUp();

        if (!extension_loaded('openssl')) {
            $this->markTestSkipped('This test requires openssl extension to run');
        }

        // Create instances of the handler and logger for convenience
        $this->handler = new FleepHookHandler(self::TOKEN);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorSetsExpectedDefaults()
    {
        $this->assertEquals(Logger::DEBUG, $this->handler->getLevel());
        $this->assertEquals(true, $this->handler->getBubble());
    }

    /**
     * @covers ::getDefaultFormatter
     */
    public function testHandlerUsesLineFormatterWhichIgnoresEmptyArrays()
    {
        $record = array(
            'message' => 'msg',
            'context' => array(),
            'level' => Logger::DEBUG,
            'level_name' => Logger::getLevelName(Logger::DEBUG),
            'channel' => 'channel',
            'datetime' => new \DateTime(),
            'extra' => array(),
        );

        $expectedFormatter = new LineFormatter(null, null, true, true);
        $expected = $expectedFormatter->format($record);

        $handlerFormatter = $this->handler->getFormatter();
        $actual = $handlerFormatter->format($record);

        $this->assertEquals($expected, $actual, 'Empty context and extra arrays should not be rendered');
    }

    /**
     * @covers ::__construct
     */
    public function testConnectionStringisConstructedCorrectly()
    {
        $this->assertEquals('ssl://' . FleepHookHandler::FLEEP_HOST . ':443', $this->handler->getConnectionString());
    }
}
