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

namespace Monolog;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        Registry::clear();
    }

    /**
     * @dataProvider hasLoggerProvider
     * @covers Monolog\Registry::hasLogger
     */
    public function testHasLogger(array $loggersToAdd, array $loggersToCheck, array $expectedResult)
    {
        foreach ($loggersToAdd as $loggerToAdd) {
            Registry::addLogger($loggerToAdd);
        }
        foreach ($loggersToCheck as $index => $loggerToCheck) {
            $this->assertSame($expectedResult[$index], Registry::hasLogger($loggerToCheck));
        }
    }

    public function hasLoggerProvider()
    {
        $logger1 = new Logger('test1');
        $logger2 = new Logger('test2');
        $logger3 = new Logger('test3');

        return array(
            // only instances
            array(
                array($logger1),
                array($logger1, $logger2),
                array(true, false),
            ),
            // only names
            array(
                array($logger1),
                array('test1', 'test2'),
                array(true, false),
            ),
            // mixed case
            array(
                array($logger1, $logger2),
                array('test1', $logger2, 'test3', $logger3),
                array(true, true, false, false),
            ),
        );
    }

    /**
     * @covers Monolog\Registry::clear
     */
    public function testClearClears()
    {
        Registry::addLogger(new Logger('test1'), 'log');
        Registry::clear();

        $this->setExpectedException('\InvalidArgumentException');
        Registry::getInstance('log');
    }

    /**
     * @dataProvider removedLoggerProvider
     * @covers Monolog\Registry::addLogger
     * @covers Monolog\Registry::removeLogger
     */
    public function testRemovesLogger($loggerToAdd, $remove)
    {
        Registry::addLogger($loggerToAdd);
        Registry::removeLogger($remove);

        $this->setExpectedException('\InvalidArgumentException');
        Registry::getInstance($loggerToAdd->getName());
    }

    public function removedLoggerProvider()
    {
        $logger1 = new Logger('test1');

        return array(
            array($logger1, $logger1),
            array($logger1, 'test1'),
        );
    }

    /**
     * @covers Monolog\Registry::addLogger
     * @covers Monolog\Registry::getInstance
     * @covers Monolog\Registry::__callStatic
     */
    public function testGetsSameLogger()
    {
        $logger1 = new Logger('test1');
        $logger2 = new Logger('test2');

        Registry::addLogger($logger1, 'test1');
        Registry::addLogger($logger2);

        $this->assertSame($logger1, Registry::getInstance('test1'));
        $this->assertSame($logger2, Registry::test2());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @covers Monolog\Registry::getInstance
     */
    public function testFailsOnNonExistantLogger()
    {
        Registry::getInstance('test1');
    }

    /**
     * @covers Monolog\Registry::addLogger
     */
    public function testReplacesLogger()
    {
        $log1 = new Logger('test1');
        $log2 = new Logger('test2');

        Registry::addLogger($log1, 'log');

        Registry::addLogger($log2, 'log', true);

        $this->assertSame($log2, Registry::getInstance('log'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @covers Monolog\Registry::addLogger
     */
    public function testFailsOnUnspecifiedReplacement()
    {
        $log1 = new Logger('test1');
        $log2 = new Logger('test2');

        Registry::addLogger($log1, 'log');

        Registry::addLogger($log2, 'log');
    }
}
