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

use Monolog\TestCase;

class LogglyFormatterTest extends TestCase
{
    /**
     * @covers Monolog\Formatter\LogglyFormatter::__construct
     */
    public function testConstruct()
    {
        $formatter = new LogglyFormatter();
        $this->assertEquals(LogglyFormatter::BATCH_MODE_NEWLINES, $formatter->getBatchMode());
        $formatter = new LogglyFormatter(LogglyFormatter::BATCH_MODE_JSON);
        $this->assertEquals(LogglyFormatter::BATCH_MODE_JSON, $formatter->getBatchMode());
    }

    /**
     * @covers Monolog\Formatter\LogglyFormatter::format
     */
    public function testFormat()
    {
        $formatter = new LogglyFormatter();
        $record = $this->getRecord();
        $formatted_decoded = json_decode($formatter->format($record), true);
        $this->assertArrayHasKey("timestamp", $formatted_decoded);
        $this->assertEquals(new \DateTime($formatted_decoded["timestamp"]), $record["datetime"]);
    }
}
