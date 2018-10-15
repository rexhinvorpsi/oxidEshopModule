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

use Monolog\Handler\TestHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\Test\LoggerInterfaceTest;

class PsrLogCompatTest extends LoggerInterfaceTest
{
    private $handler;

    public function getLogger()
    {
        $logger = new Logger('foo');
        $logger->pushHandler($handler = new TestHandler);
        $logger->pushProcessor(new PsrLogMessageProcessor);
        $handler->setFormatter(new LineFormatter('%level_name% %message%'));

        $this->handler = $handler;

        return $logger;
    }

    public function getLogs()
    {
        $convert = function ($record) {
            $lower = function ($match) {
                return strtolower($match[0]);
            };

            return preg_replace_callback('{^[A-Z]+}', $lower, $record['formatted']);
        };

        return array_map($convert, $this->handler->getRecords());
    }
}
