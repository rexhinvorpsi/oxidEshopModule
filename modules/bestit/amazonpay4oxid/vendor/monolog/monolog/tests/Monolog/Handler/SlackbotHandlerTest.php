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
 * @author Haralan Dobrev <hkdobrev@gmail.com>
 * @see    https://slack.com/apps/A0F81R8ET-slackbot
 * @coversDefaultClass Monolog\Handler\SlackbotHandler
 */
class SlackbotHandlerTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstructorMinimal()
    {
        $handler = new SlackbotHandler('test-team', 'test-token', 'test-channel');
        $this->assertInstanceOf('Monolog\Handler\AbstractProcessingHandler', $handler);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorFull()
    {
        $handler = new SlackbotHandler(
            'test-team',
            'test-token',
            'test-channel',
            Logger::DEBUG,
            false
        );
        $this->assertInstanceOf('Monolog\Handler\AbstractProcessingHandler', $handler);
    }
}
