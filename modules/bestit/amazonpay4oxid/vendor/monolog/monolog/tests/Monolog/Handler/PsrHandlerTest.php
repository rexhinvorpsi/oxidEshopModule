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
 * @covers Monolog\Handler\PsrHandler::handle
 */
class PsrHandlerTest extends TestCase
{
    public function logLevelProvider()
    {
        $levels = array();
        $monologLogger = new Logger('');

        foreach ($monologLogger->getLevels() as $levelName => $level) {
            $levels[] = array($levelName, $level);
        }

        return $levels;
    }

    /**
     * @dataProvider logLevelProvider
     */
    public function testHandlesAllLevels($levelName, $level)
    {
        $message = 'Hello, world! ' . $level;
        $context = array('foo' => 'bar', 'level' => $level);

        $psrLogger = $this->getMock('Psr\Log\NullLogger');
        $psrLogger->expects($this->once())
            ->method('log')
            ->with(strtolower($levelName), $message, $context);

        $handler = new PsrHandler($psrLogger);
        $handler->handle(array('level' => $level, 'level_name' => $levelName, 'message' => $message, 'context' => $context));
    }
}
