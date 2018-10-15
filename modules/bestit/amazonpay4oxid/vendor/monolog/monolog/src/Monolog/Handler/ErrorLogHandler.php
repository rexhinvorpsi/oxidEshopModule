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

/**
 * Stores to PHP error_log() handler.
 *
 * @author Elan Ruusamäe <glen@delfi.ee>
 */
class ErrorLogHandler extends AbstractProcessingHandler
{
    const OPERATING_SYSTEM = 0;
    const SAPI = 4;

    protected $messageType;
    protected $expandNewlines;

    /**
     * @param int     $messageType    Says where the error should go.
     * @param int     $level          The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble         Whether the messages that are handled can bubble up the stack or not
     * @param Boolean $expandNewlines If set to true, newlines in the message will be expanded to be take multiple log entries
     */
    public function __construct($messageType = self::OPERATING_SYSTEM, $level = Logger::DEBUG, $bubble = true, $expandNewlines = false)
    {
        parent::__construct($level, $bubble);

        if (false === in_array($messageType, self::getAvailableTypes())) {
            $message = sprintf('The given message type "%s" is not supported', print_r($messageType, true));
            throw new \InvalidArgumentException($message);
        }

        $this->messageType = $messageType;
        $this->expandNewlines = $expandNewlines;
    }

    /**
     * @return array With all available types
     */
    public static function getAvailableTypes()
    {
        return array(
            self::OPERATING_SYSTEM,
            self::SAPI,
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter('[%datetime%] %channel%.%level_name%: %message% %context% %extra%');
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if ($this->expandNewlines) {
            $lines = preg_split('{[\r\n]+}', (string) $record['formatted']);
            foreach ($lines as $line) {
                error_log($line, $this->messageType);
            }
        } else {
            error_log((string) $record['formatted'], $this->messageType);
        }
    }
}
