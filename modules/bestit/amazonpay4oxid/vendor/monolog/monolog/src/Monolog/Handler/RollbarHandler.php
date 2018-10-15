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

use RollbarNotifier;
use Exception;
use Monolog\Logger;

/**
 * Sends errors to Rollbar
 *
 * If the context data contains a `payload` key, that is used as an array
 * of payload options to RollbarNotifier's report_message/report_exception methods.
 *
 * Rollbar's context info will contain the context + extra keys from the log record
 * merged, and then on top of that a few keys:
 *
 *  - level (rollbar level name)
 *  - monolog_level (monolog level name, raw level, as rollbar only has 5 but monolog 8)
 *  - channel
 *  - datetime (unix timestamp)
 *
 * @author Paul Statezny <paulstatezny@gmail.com>
 */
class RollbarHandler extends AbstractProcessingHandler
{
    /**
     * Rollbar notifier
     *
     * @var RollbarNotifier
     */
    protected $rollbarNotifier;

    protected $levelMap = array(
        Logger::DEBUG     => 'debug',
        Logger::INFO      => 'info',
        Logger::NOTICE    => 'info',
        Logger::WARNING   => 'warning',
        Logger::ERROR     => 'error',
        Logger::CRITICAL  => 'critical',
        Logger::ALERT     => 'critical',
        Logger::EMERGENCY => 'critical',
    );

    /**
     * Records whether any log records have been added since the last flush of the rollbar notifier
     *
     * @var bool
     */
    private $hasRecords = false;

    protected $initialized = false;

    /**
     * @param RollbarNotifier $rollbarNotifier RollbarNotifier object constructed with valid token
     * @param int             $level           The minimum logging level at which this handler will be triggered
     * @param bool            $bubble          Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct(RollbarNotifier $rollbarNotifier, $level = Logger::ERROR, $bubble = true)
    {
        $this->rollbarNotifier = $rollbarNotifier;

        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if (!$this->initialized) {
            // __destructor() doesn't get called on Fatal errors
            register_shutdown_function(array($this, 'close'));
            $this->initialized = true;
        }

        $context = $record['context'];
        $payload = array();
        if (isset($context['payload'])) {
            $payload = $context['payload'];
            unset($context['payload']);
        }
        $context = array_merge($context, $record['extra'], array(
            'level' => $this->levelMap[$record['level']],
            'monolog_level' => $record['level_name'],
            'channel' => $record['channel'],
            'datetime' => $record['datetime']->format('U'),
        ));

        if (isset($context['exception']) && $context['exception'] instanceof Exception) {
            $payload['level'] = $context['level'];
            $exception = $context['exception'];
            unset($context['exception']);

            $this->rollbarNotifier->report_exception($exception, $context, $payload);
        } else {
            $this->rollbarNotifier->report_message(
                $record['message'],
                $context['level'],
                $context,
                $payload
            );
        }

        $this->hasRecords = true;
    }

    public function flush()
    {
        if ($this->hasRecords) {
            $this->rollbarNotifier->flush();
            $this->hasRecords = false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->flush();
    }
}
