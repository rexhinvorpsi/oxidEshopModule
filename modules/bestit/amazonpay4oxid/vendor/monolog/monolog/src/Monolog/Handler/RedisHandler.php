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
 * Logs to a Redis key using rpush
 *
 * usage example:
 *
 *   $log = new Logger('application');
 *   $redis = new RedisHandler(new Predis\Client("tcp://localhost:6379"), "logs", "prod");
 *   $log->pushHandler($redis);
 *
 * @author Thomas Tourlourat <thomas@tourlourat.com>
 */
class RedisHandler extends AbstractProcessingHandler
{
    private $redisClient;
    private $redisKey;
    protected $capSize;

    /**
     * @param \Predis\Client|\Redis $redis   The redis instance
     * @param string                $key     The key name to push records to
     * @param int                   $level   The minimum logging level at which this handler will be triggered
     * @param bool                  $bubble  Whether the messages that are handled can bubble up the stack or not
     * @param int                   $capSize Number of entries to limit list size to
     */
    public function __construct($redis, $key, $level = Logger::DEBUG, $bubble = true, $capSize = false)
    {
        if (!(($redis instanceof \Predis\Client) || ($redis instanceof \Redis))) {
            throw new \InvalidArgumentException('Predis\Client or Redis instance required');
        }

        $this->redisClient = $redis;
        $this->redisKey = $key;
        $this->capSize = $capSize;

        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record)
    {
        if ($this->capSize) {
            $this->writeCapped($record);
        } else {
            $this->redisClient->rpush($this->redisKey, $record["formatted"]);
        }
    }

    /**
     * Write and cap the collection
     * Writes the record to the redis list and caps its
     *
     * @param  array $record associative record array
     * @return void
     */
    protected function writeCapped(array $record)
    {
        if ($this->redisClient instanceof \Redis) {
            $this->redisClient->multi()
                ->rpush($this->redisKey, $record["formatted"])
                ->ltrim($this->redisKey, -$this->capSize, -1)
                ->exec();
        } else {
            $redisKey = $this->redisKey;
            $capSize = $this->capSize;
            $this->redisClient->transaction(function ($tx) use ($record, $redisKey, $capSize) {
                $tx->rpush($redisKey, $record["formatted"]);
                $tx->ltrim($redisKey, -$capSize, -1);
            });
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter();
    }
}
