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

namespace Monolog\Formatter;

/**
 * Formats a record for use with the MongoDBHandler.
 *
 * @author Florian Plattner <me@florianplattner.de>
 */
class MongoDBFormatter implements FormatterInterface
{
    private $exceptionTraceAsString;
    private $maxNestingLevel;

    /**
     * @param int  $maxNestingLevel        0 means infinite nesting, the $record itself is level 1, $record['context'] is 2
     * @param bool $exceptionTraceAsString set to false to log exception traces as a sub documents instead of strings
     */
    public function __construct($maxNestingLevel = 3, $exceptionTraceAsString = true)
    {
        $this->maxNestingLevel = max($maxNestingLevel, 0);
        $this->exceptionTraceAsString = (bool) $exceptionTraceAsString;
    }

    /**
     * {@inheritDoc}
     */
    public function format(array $record)
    {
        return $this->formatArray($record);
    }

    /**
     * {@inheritDoc}
     */
    public function formatBatch(array $records)
    {
        foreach ($records as $key => $record) {
            $records[$key] = $this->format($record);
        }

        return $records;
    }

    protected function formatArray(array $record, $nestingLevel = 0)
    {
        if ($this->maxNestingLevel == 0 || $nestingLevel <= $this->maxNestingLevel) {
            foreach ($record as $name => $value) {
                if ($value instanceof \DateTime) {
                    $record[$name] = $this->formatDate($value, $nestingLevel + 1);
                } elseif ($value instanceof \Exception) {
                    $record[$name] = $this->formatException($value, $nestingLevel + 1);
                } elseif (is_array($value)) {
                    $record[$name] = $this->formatArray($value, $nestingLevel + 1);
                } elseif (is_object($value)) {
                    $record[$name] = $this->formatObject($value, $nestingLevel + 1);
                }
            }
        } else {
            $record = '[...]';
        }

        return $record;
    }

    protected function formatObject($value, $nestingLevel)
    {
        $objectVars = get_object_vars($value);
        $objectVars['class'] = get_class($value);

        return $this->formatArray($objectVars, $nestingLevel);
    }

    protected function formatException(\Exception $exception, $nestingLevel)
    {
        $formattedException = array(
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile() . ':' . $exception->getLine(),
        );

        if ($this->exceptionTraceAsString === true) {
            $formattedException['trace'] = $exception->getTraceAsString();
        } else {
            $formattedException['trace'] = $exception->getTrace();
        }

        return $this->formatArray($formattedException, $nestingLevel);
    }

    protected function formatDate(\DateTime $value, $nestingLevel)
    {
        return new \MongoDate($value->getTimestamp());
    }
}
