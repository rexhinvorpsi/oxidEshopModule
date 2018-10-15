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

/**
 * Logs to syslog service.
 *
 * usage example:
 *
 *   $log = new Logger('application');
 *   $syslog = new SyslogHandler('myfacility', 'local6');
 *   $formatter = new LineFormatter("%channel%.%level_name%: %message% %extra%");
 *   $syslog->setFormatter($formatter);
 *   $log->pushHandler($syslog);
 *
 * @author Sven Paulus <sven@karlsruhe.org>
 */
class SyslogHandler extends AbstractSyslogHandler
{
    protected $ident;
    protected $logopts;

    /**
     * @param string  $ident
     * @param mixed   $facility
     * @param int     $level    The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble   Whether the messages that are handled can bubble up the stack or not
     * @param int     $logopts  Option flags for the openlog() call, defaults to LOG_PID
     */
    public function __construct($ident, $facility = LOG_USER, $level = Logger::DEBUG, $bubble = true, $logopts = LOG_PID)
    {
        parent::__construct($facility, $level, $bubble);

        $this->ident = $ident;
        $this->logopts = $logopts;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        closelog();
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if (!openlog($this->ident, $this->logopts, $this->facility)) {
            throw new \LogicException('Can\'t open syslog for ident "'.$this->ident.'" and facility "'.$this->facility.'"');
        }
        syslog($this->logLevels[$record['level']], (string) $record['formatted']);
    }
}
