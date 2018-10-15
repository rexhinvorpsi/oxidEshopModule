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

namespace Monolog\Processor;

use Monolog\TestCase;

class WebProcessorTest extends TestCase
{
    public function testProcessor()
    {
        $server = array(
            'REQUEST_URI'    => 'A',
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
            'HTTP_REFERER'   => 'D',
            'SERVER_NAME'    => 'F',
            'UNIQUE_ID'      => 'G',
        );

        $processor = new WebProcessor($server);
        $record = $processor($this->getRecord());
        $this->assertEquals($server['REQUEST_URI'], $record['extra']['url']);
        $this->assertEquals($server['REMOTE_ADDR'], $record['extra']['ip']);
        $this->assertEquals($server['REQUEST_METHOD'], $record['extra']['http_method']);
        $this->assertEquals($server['HTTP_REFERER'], $record['extra']['referrer']);
        $this->assertEquals($server['SERVER_NAME'], $record['extra']['server']);
        $this->assertEquals($server['UNIQUE_ID'], $record['extra']['unique_id']);
    }

    public function testProcessorDoNothingIfNoRequestUri()
    {
        $server = array(
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
        );
        $processor = new WebProcessor($server);
        $record = $processor($this->getRecord());
        $this->assertEmpty($record['extra']);
    }

    public function testProcessorReturnNullIfNoHttpReferer()
    {
        $server = array(
            'REQUEST_URI'    => 'A',
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
            'SERVER_NAME'    => 'F',
        );
        $processor = new WebProcessor($server);
        $record = $processor($this->getRecord());
        $this->assertNull($record['extra']['referrer']);
    }

    public function testProcessorDoesNotAddUniqueIdIfNotPresent()
    {
        $server = array(
            'REQUEST_URI'    => 'A',
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
            'SERVER_NAME'    => 'F',
        );
        $processor = new WebProcessor($server);
        $record = $processor($this->getRecord());
        $this->assertFalse(isset($record['extra']['unique_id']));
    }

    public function testProcessorAddsOnlyRequestedExtraFields()
    {
        $server = array(
            'REQUEST_URI'    => 'A',
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
            'SERVER_NAME'    => 'F',
        );

        $processor = new WebProcessor($server, array('url', 'http_method'));
        $record = $processor($this->getRecord());

        $this->assertSame(array('url' => 'A', 'http_method' => 'C'), $record['extra']);
    }

    public function testProcessorConfiguringOfExtraFields()
    {
        $server = array(
            'REQUEST_URI'    => 'A',
            'REMOTE_ADDR'    => 'B',
            'REQUEST_METHOD' => 'C',
            'SERVER_NAME'    => 'F',
        );

        $processor = new WebProcessor($server, array('url' => 'REMOTE_ADDR'));
        $record = $processor($this->getRecord());

        $this->assertSame(array('url' => 'B'), $record['extra']);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testInvalidData()
    {
        new WebProcessor(new \stdClass);
    }
}
