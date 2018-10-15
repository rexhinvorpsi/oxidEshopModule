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

namespace Monolog\Formatter;

use Monolog\Logger;

class ChromePHPFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Monolog\Formatter\ChromePHPFormatter::format
     */
    public function testDefaultFormat()
    {
        $formatter = new ChromePHPFormatter();
        $record = array(
            'level' => Logger::ERROR,
            'level_name' => 'ERROR',
            'channel' => 'meh',
            'context' => array('from' => 'logger'),
            'datetime' => new \DateTime("@0"),
            'extra' => array('ip' => '127.0.0.1'),
            'message' => 'log',
        );

        $message = $formatter->format($record);

        $this->assertEquals(
            array(
                'meh',
                array(
                    'message' => 'log',
                    'context' => array('from' => 'logger'),
                    'extra' => array('ip' => '127.0.0.1'),
                ),
                'unknown',
                'error',
            ),
            $message
        );
    }

    /**
     * @covers Monolog\Formatter\ChromePHPFormatter::format
     */
    public function testFormatWithFileAndLine()
    {
        $formatter = new ChromePHPFormatter();
        $record = array(
            'level' => Logger::CRITICAL,
            'level_name' => 'CRITICAL',
            'channel' => 'meh',
            'context' => array('from' => 'logger'),
            'datetime' => new \DateTime("@0"),
            'extra' => array('ip' => '127.0.0.1', 'file' => 'test', 'line' => 14),
            'message' => 'log',
        );

        $message = $formatter->format($record);

        $this->assertEquals(
            array(
                'meh',
                array(
                    'message' => 'log',
                    'context' => array('from' => 'logger'),
                    'extra' => array('ip' => '127.0.0.1'),
                ),
                'test : 14',
                'error',
            ),
            $message
        );
    }

    /**
     * @covers Monolog\Formatter\ChromePHPFormatter::format
     */
    public function testFormatWithoutContext()
    {
        $formatter = new ChromePHPFormatter();
        $record = array(
            'level' => Logger::DEBUG,
            'level_name' => 'DEBUG',
            'channel' => 'meh',
            'context' => array(),
            'datetime' => new \DateTime("@0"),
            'extra' => array(),
            'message' => 'log',
        );

        $message = $formatter->format($record);

        $this->assertEquals(
            array(
                'meh',
                'log',
                'unknown',
                'log',
            ),
            $message
        );
    }

    /**
     * @covers Monolog\Formatter\ChromePHPFormatter::formatBatch
     */
    public function testBatchFormatThrowException()
    {
        $formatter = new ChromePHPFormatter();
        $records = array(
            array(
                'level' => Logger::INFO,
                'level_name' => 'INFO',
                'channel' => 'meh',
                'context' => array(),
                'datetime' => new \DateTime("@0"),
                'extra' => array(),
                'message' => 'log',
            ),
            array(
                'level' => Logger::WARNING,
                'level_name' => 'WARNING',
                'channel' => 'foo',
                'context' => array(),
                'datetime' => new \DateTime("@0"),
                'extra' => array(),
                'message' => 'log2',
            ),
        );

        $this->assertEquals(
            array(
                array(
                    'meh',
                    'log',
                    'unknown',
                    'info',
                ),
                array(
                    'foo',
                    'log2',
                    'unknown',
                    'warn',
                ),
            ),
            $formatter->formatBatch($records)
        );
    }
}
