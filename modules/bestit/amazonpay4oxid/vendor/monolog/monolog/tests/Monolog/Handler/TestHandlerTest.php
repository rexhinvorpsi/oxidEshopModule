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
 * @covers Monolog\Handler\TestHandler
 */
class TestHandlerTest extends TestCase
{
    /**
     * @dataProvider methodProvider
     */
    public function testHandler($method, $level)
    {
        $handler = new TestHandler;
        $record = $this->getRecord($level, 'test'.$method);
        $this->assertFalse($handler->hasRecords($level));
        $this->assertFalse($handler->hasRecord($record, $level));
        $this->assertFalse($handler->{'has'.$method}($record), 'has'.$method);
        $this->assertFalse($handler->{'has'.$method.'ThatContains'}('test'), 'has'.$method.'ThatContains');
        $this->assertFalse($handler->{'has'.$method.'ThatPasses'}(function ($rec) {
            return true;
        }), 'has'.$method.'ThatPasses');
        $this->assertFalse($handler->{'has'.$method.'ThatMatches'}('/test\w+/'));
        $this->assertFalse($handler->{'has'.$method.'Records'}(), 'has'.$method.'Records');
        $handler->handle($record);

        $this->assertFalse($handler->{'has'.$method}('bar'), 'has'.$method);
        $this->assertTrue($handler->hasRecords($level));
        $this->assertTrue($handler->hasRecord($record, $level));
        $this->assertTrue($handler->{'has'.$method}($record), 'has'.$method);
        $this->assertTrue($handler->{'has'.$method}('test'.$method), 'has'.$method);
        $this->assertTrue($handler->{'has'.$method.'ThatContains'}('test'), 'has'.$method.'ThatContains');
        $this->assertTrue($handler->{'has'.$method.'ThatPasses'}(function ($rec) {
            return true;
        }), 'has'.$method.'ThatPasses');
        $this->assertTrue($handler->{'has'.$method.'ThatMatches'}('/test\w+/'));
        $this->assertTrue($handler->{'has'.$method.'Records'}(), 'has'.$method.'Records');

        $records = $handler->getRecords();
        unset($records[0]['formatted']);
        $this->assertEquals(array($record), $records);
    }

    public function methodProvider()
    {
        return array(
            array('Emergency', Logger::EMERGENCY),
            array('Alert'    , Logger::ALERT),
            array('Critical' , Logger::CRITICAL),
            array('Error'    , Logger::ERROR),
            array('Warning'  , Logger::WARNING),
            array('Info'     , Logger::INFO),
            array('Notice'   , Logger::NOTICE),
            array('Debug'    , Logger::DEBUG),
        );
    }
}