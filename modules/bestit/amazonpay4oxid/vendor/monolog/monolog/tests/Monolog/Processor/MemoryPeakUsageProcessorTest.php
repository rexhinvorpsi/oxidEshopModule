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

namespace Monolog\Processor;

use Monolog\TestCase;

class MemoryPeakUsageProcessorTest extends TestCase
{
    /**
     * @covers Monolog\Processor\MemoryPeakUsageProcessor::__invoke
     * @covers Monolog\Processor\MemoryProcessor::formatBytes
     */
    public function testProcessor()
    {
        $processor = new MemoryPeakUsageProcessor();
        $record = $processor($this->getRecord());
        $this->assertArrayHasKey('memory_peak_usage', $record['extra']);
        $this->assertRegExp('#[0-9.]+ (M|K)?B$#', $record['extra']['memory_peak_usage']);
    }

    /**
     * @covers Monolog\Processor\MemoryPeakUsageProcessor::__invoke
     * @covers Monolog\Processor\MemoryProcessor::formatBytes
     */
    public function testProcessorWithoutFormatting()
    {
        $processor = new MemoryPeakUsageProcessor(true, false);
        $record = $processor($this->getRecord());
        $this->assertArrayHasKey('memory_peak_usage', $record['extra']);
        $this->assertInternalType('int', $record['extra']['memory_peak_usage']);
        $this->assertGreaterThan(0, $record['extra']['memory_peak_usage']);
    }
}
