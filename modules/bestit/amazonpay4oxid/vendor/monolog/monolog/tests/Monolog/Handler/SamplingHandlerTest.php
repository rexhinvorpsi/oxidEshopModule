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

/**
 * @covers Monolog\Handler\SamplingHandler::handle
 */
class SamplingHandlerTest extends TestCase
{
    public function testHandle()
    {
        $testHandler = new TestHandler();
        $handler = new SamplingHandler($testHandler, 2);
        for ($i = 0; $i < 10000; $i++) {
            $handler->handle($this->getRecord());
        }
        $count = count($testHandler->getRecords());
        // $count should be half of 10k, so between 4k and 6k
        $this->assertLessThan(6000, $count);
        $this->assertGreaterThan(4000, $count);
    }
}
