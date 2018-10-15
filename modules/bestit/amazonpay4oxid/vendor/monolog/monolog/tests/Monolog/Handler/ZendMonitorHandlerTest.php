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

class ZendMonitorHandlerTest extends TestCase
{
    protected $zendMonitorHandler;

    public function setUp()
    {
        if (!function_exists('zend_monitor_custom_event')) {
            $this->markTestSkipped('ZendServer is not installed');
        }
    }

    /**
     * @covers  Monolog\Handler\ZendMonitorHandler::write
     */
    public function testWrite()
    {
        $record = $this->getRecord();
        $formatterResult = array(
            'message' => $record['message'],
        );

        $zendMonitor = $this->getMockBuilder('Monolog\Handler\ZendMonitorHandler')
            ->setMethods(array('writeZendMonitorCustomEvent', 'getDefaultFormatter'))
            ->getMock();

        $formatterMock = $this->getMockBuilder('Monolog\Formatter\NormalizerFormatter')
            ->disableOriginalConstructor()
            ->getMock();

        $formatterMock->expects($this->once())
            ->method('format')
            ->will($this->returnValue($formatterResult));

        $zendMonitor->expects($this->once())
            ->method('getDefaultFormatter')
            ->will($this->returnValue($formatterMock));

        $levelMap = $zendMonitor->getLevelMap();

        $zendMonitor->expects($this->once())
            ->method('writeZendMonitorCustomEvent')
            ->with($levelMap[$record['level']], $record['message'], $formatterResult);

        $zendMonitor->handle($record);
    }

    /**
     * @covers Monolog\Handler\ZendMonitorHandler::getDefaultFormatter
     */
    public function testGetDefaultFormatterReturnsNormalizerFormatter()
    {
        $zendMonitor = new ZendMonitorHandler();
        $this->assertInstanceOf('Monolog\Formatter\NormalizerFormatter', $zendMonitor->getDefaultFormatter());
    }
}
