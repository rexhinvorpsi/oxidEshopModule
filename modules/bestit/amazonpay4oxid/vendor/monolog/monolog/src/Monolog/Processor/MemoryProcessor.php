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

/**
 * Some methods that are common for all memory processors
 *
 * @author Rob Jensen
 */
abstract class MemoryProcessor
{
    /**
     * @var bool If true, get the real size of memory allocated from system. Else, only the memory used by emalloc() is reported.
     */
    protected $realUsage;

    /**
     * @var bool If true, then format memory size to human readable string (MB, KB, B depending on size)
     */
    protected $useFormatting;

    /**
     * @param bool $realUsage     Set this to true to get the real size of memory allocated from system.
     * @param bool $useFormatting If true, then format memory size to human readable string (MB, KB, B depending on size)
     */
    public function __construct($realUsage = true, $useFormatting = true)
    {
        $this->realUsage = (boolean) $realUsage;
        $this->useFormatting = (boolean) $useFormatting;
    }

    /**
     * Formats bytes into a human readable string if $this->useFormatting is true, otherwise return $bytes as is
     *
     * @param  int        $bytes
     * @return string|int Formatted string if $this->useFormatting is true, otherwise return $bytes as is
     */
    protected function formatBytes($bytes)
    {
        $bytes = (int) $bytes;

        if (!$this->useFormatting) {
            return $bytes;
        }

        if ($bytes > 1024 * 1024) {
            return round($bytes / 1024 / 1024, 2).' MB';
        } elseif ($bytes > 1024) {
            return round($bytes / 1024, 2).' KB';
        }

        return $bytes . ' B';
    }
}
