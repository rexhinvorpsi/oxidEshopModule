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
 * @covers Monolog\Handler\BrowserConsoleHandlerTest
 */
class BrowserConsoleHandlerTest extends TestCase
{
    protected function setUp()
    {
        BrowserConsoleHandler::reset();
    }

    protected function generateScript()
    {
        $reflMethod = new \ReflectionMethod('Monolog\Handler\BrowserConsoleHandler', 'generateScript');
        $reflMethod->setAccessible(true);

        return $reflMethod->invoke(null);
    }

    public function testStyling()
    {
        $handler = new BrowserConsoleHandler();
        $handler->setFormatter($this->getIdentityFormatter());

        $handler->handle($this->getRecord(Logger::DEBUG, 'foo[[bar]]{color: red}'));

        $expected = <<<EOF
(function (c) {if (c && c.groupCollapsed) {
c.log("%cfoo%cbar%c", "font-weight: normal", "color: red", "font-weight: normal");
}})(console);
EOF;

        $this->assertEquals($expected, $this->generateScript());
    }

    public function testEscaping()
    {
        $handler = new BrowserConsoleHandler();
        $handler->setFormatter($this->getIdentityFormatter());

        $handler->handle($this->getRecord(Logger::DEBUG, "[foo] [[\"bar\n[baz]\"]]{color: red}"));

        $expected = <<<EOF
(function (c) {if (c && c.groupCollapsed) {
c.log("%c[foo] %c\"bar\\n[baz]\"%c", "font-weight: normal", "color: red", "font-weight: normal");
}})(console);
EOF;

        $this->assertEquals($expected, $this->generateScript());
    }

    public function testAutolabel()
    {
        $handler = new BrowserConsoleHandler();
        $handler->setFormatter($this->getIdentityFormatter());

        $handler->handle($this->getRecord(Logger::DEBUG, '[[foo]]{macro: autolabel}'));
        $handler->handle($this->getRecord(Logger::DEBUG, '[[bar]]{macro: autolabel}'));
        $handler->handle($this->getRecord(Logger::DEBUG, '[[foo]]{macro: autolabel}'));

        $expected = <<<EOF
(function (c) {if (c && c.groupCollapsed) {
c.log("%c%cfoo%c", "font-weight: normal", "background-color: blue; color: white; border-radius: 3px; padding: 0 2px 0 2px", "font-weight: normal");
c.log("%c%cbar%c", "font-weight: normal", "background-color: green; color: white; border-radius: 3px; padding: 0 2px 0 2px", "font-weight: normal");
c.log("%c%cfoo%c", "font-weight: normal", "background-color: blue; color: white; border-radius: 3px; padding: 0 2px 0 2px", "font-weight: normal");
}})(console);
EOF;

        $this->assertEquals($expected, $this->generateScript());
    }

    public function testContext()
    {
        $handler = new BrowserConsoleHandler();
        $handler->setFormatter($this->getIdentityFormatter());

        $handler->handle($this->getRecord(Logger::DEBUG, 'test', array('foo' => 'bar')));

        $expected = <<<EOF
(function (c) {if (c && c.groupCollapsed) {
c.groupCollapsed("%ctest", "font-weight: normal");
c.log("%c%s", "font-weight: bold", "Context");
c.log("%s: %o", "foo", "bar");
c.groupEnd();
}})(console);
EOF;

        $this->assertEquals($expected, $this->generateScript());
    }

    public function testConcurrentHandlers()
    {
        $handler1 = new BrowserConsoleHandler();
        $handler1->setFormatter($this->getIdentityFormatter());

        $handler2 = new BrowserConsoleHandler();
        $handler2->setFormatter($this->getIdentityFormatter());

        $handler1->handle($this->getRecord(Logger::DEBUG, 'test1'));
        $handler2->handle($this->getRecord(Logger::DEBUG, 'test2'));
        $handler1->handle($this->getRecord(Logger::DEBUG, 'test3'));
        $handler2->handle($this->getRecord(Logger::DEBUG, 'test4'));

        $expected = <<<EOF
(function (c) {if (c && c.groupCollapsed) {
c.log("%ctest1", "font-weight: normal");
c.log("%ctest2", "font-weight: normal");
c.log("%ctest3", "font-weight: normal");
c.log("%ctest4", "font-weight: normal");
}})(console);
EOF;

        $this->assertEquals($expected, $this->generateScript());
    }
}
