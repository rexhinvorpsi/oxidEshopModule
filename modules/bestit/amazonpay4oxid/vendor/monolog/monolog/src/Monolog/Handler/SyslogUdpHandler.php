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

use Monolog\Logger;
use Monolog\Handler\SyslogUdp\UdpSocket;

/**
 * A Handler for logging to a remote syslogd server.
 *
 * @author Jesper Skovgaard Nielsen <nulpunkt@gmail.com>
 */
class SyslogUdpHandler extends AbstractSyslogHandler
{
    protected $socket;
    protected $ident;

    /**
     * @param string  $host
     * @param int     $port
     * @param mixed   $facility
     * @param int     $level    The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble   Whether the messages that are handled can bubble up the stack or not
     * @param string  $ident    Program name or tag for each log message.
     */
    public function __construct($host, $port = 514, $facility = LOG_USER, $level = Logger::DEBUG, $bubble = true, $ident = 'php')
    {
        parent::__construct($facility, $level, $bubble);

        $this->ident = $ident;

        $this->socket = new UdpSocket($host, $port ?: 514);
    }

    protected function write(array $record)
    {
        $lines = $this->splitMessageIntoLines($record['formatted']);

        $header = $this->makeCommonSyslogHeader($this->logLevels[$record['level']]);

        foreach ($lines as $line) {
            $this->socket->write($line, $header);
        }
    }

    public function close()
    {
        $this->socket->close();
    }

    private function splitMessageIntoLines($message)
    {
        if (is_array($message)) {
            $message = implode("\n", $message);
        }

        return preg_split('/$\R?^/m', $message, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Make common syslog header (see rfc5424)
     */
    protected function makeCommonSyslogHeader($severity)
    {
        $priority = $severity + $this->facility;

        if (!$pid = getmypid()) {
            $pid = '-';
        }

        if (!$hostname = gethostname()) {
            $hostname = '-';
        }

        return "<$priority>1 " .
            $this->getDateTime() . " " .
            $hostname . " " .
            $this->ident . " " .
            $pid . " - - ";
    }

    protected function getDateTime()
    {
        return date(\DateTime::RFC3339);
    }

    /**
     * Inject your own socket, mainly used for testing
     */
    public function setSocket($socket)
    {
        $this->socket = $socket;
    }
}
