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
use Monolog\Formatter\LineFormatter;

class RedisHandlerTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorShouldThrowExceptionForInvalidRedis()
    {
        new RedisHandler(new \stdClass(), 'key');
    }

    public function testConstructorShouldWorkWithPredis()
    {
        $redis = $this->getMock('Predis\Client');
        $this->assertInstanceof('Monolog\Handler\RedisHandler', new RedisHandler($redis, 'key'));
    }

    public function testConstructorShouldWorkWithRedis()
    {
        $redis = $this->getMock('Redis');
        $this->assertInstanceof('Monolog\Handler\RedisHandler', new RedisHandler($redis, 'key'));
    }

    public function testPredisHandle()
    {
        $redis = $this->getMock('Predis\Client', array('rpush'));

        // Predis\Client uses rpush
        $redis->expects($this->once())
            ->method('rpush')
            ->with('key', 'test');

        $record = $this->getRecord(Logger::WARNING, 'test', array('data' => new \stdClass, 'foo' => 34));

        $handler = new RedisHandler($redis, 'key');
        $handler->setFormatter(new LineFormatter("%message%"));
        $handler->handle($record);
    }

    public function testRedisHandle()
    {
        $redis = $this->getMock('Redis', array('rpush'));

        // Redis uses rPush
        $redis->expects($this->once())
            ->method('rPush')
            ->with('key', 'test');

        $record = $this->getRecord(Logger::WARNING, 'test', array('data' => new \stdClass, 'foo' => 34));

        $handler = new RedisHandler($redis, 'key');
        $handler->setFormatter(new LineFormatter("%message%"));
        $handler->handle($record);
    }

    public function testRedisHandleCapped()
    {
        $redis = $this->getMock('Redis', array('multi', 'rpush', 'ltrim', 'exec'));

        // Redis uses multi
        $redis->expects($this->once())
            ->method('multi')
            ->will($this->returnSelf());

        $redis->expects($this->once())
            ->method('rpush')
            ->will($this->returnSelf());

        $redis->expects($this->once())
            ->method('ltrim')
            ->will($this->returnSelf());

        $redis->expects($this->once())
            ->method('exec')
            ->will($this->returnSelf());

        $record = $this->getRecord(Logger::WARNING, 'test', array('data' => new \stdClass, 'foo' => 34));

        $handler = new RedisHandler($redis, 'key', Logger::DEBUG, true, 10);
        $handler->setFormatter(new LineFormatter("%message%"));
        $handler->handle($record);
    }

    public function testPredisHandleCapped()
    {
        $redis = $this->getMock('Predis\Client', array('transaction'));

        $redisTransaction = $this->getMock('Predis\Client', array('rpush', 'ltrim'));

        $redisTransaction->expects($this->once())
            ->method('rpush')
            ->will($this->returnSelf());

        $redisTransaction->expects($this->once())
            ->method('ltrim')
            ->will($this->returnSelf());

        // Redis uses multi
        $redis->expects($this->once())
            ->method('transaction')
            ->will($this->returnCallback(function ($cb) use ($redisTransaction) {
                $cb($redisTransaction);
            }));

        $record = $this->getRecord(Logger::WARNING, 'test', array('data' => new \stdClass, 'foo' => 34));

        $handler = new RedisHandler($redis, 'key', Logger::DEBUG, true, 10);
        $handler->setFormatter(new LineFormatter("%message%"));
        $handler->handle($record);
    }
}
