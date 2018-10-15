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

namespace Monolog\Handler\SyslogUdp;

class UdpSocket
{
    const DATAGRAM_MAX_LENGTH = 65023;

    protected $ip;
    protected $port;
    protected $socket;

    public function __construct($ip, $port = 514)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    }

    public function write($line, $header = "")
    {
        $this->send($this->assembleMessage($line, $header));
    }

    public function close()
    {
        if (is_resource($this->socket)) {
            socket_close($this->socket);
            $this->socket = null;
        }
    }

    protected function send($chunk)
    {
        if (!is_resource($this->socket)) {
            throw new \LogicException('The UdpSocket to '.$this->ip.':'.$this->port.' has been closed and can not be written to anymore');
        }
        socket_sendto($this->socket, $chunk, strlen($chunk), $flags = 0, $this->ip, $this->port);
    }

    protected function assembleMessage($line, $header)
    {
        $chunkSize = self::DATAGRAM_MAX_LENGTH - strlen($header);

        return $header . substr($line, 0, $chunkSize);
    }
}
