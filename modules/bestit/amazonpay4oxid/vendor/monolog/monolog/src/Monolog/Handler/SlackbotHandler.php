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
 * Sends notifications through Slack's Slackbot
 *
 * @author Haralan Dobrev <hkdobrev@gmail.com>
 * @see    https://slack.com/apps/A0F81R8ET-slackbot
 */
class SlackbotHandler extends AbstractProcessingHandler
{
    /**
     * The slug of the Slack team
     * @var string
     */
    private $slackTeam;

    /**
     * Slackbot token
     * @var string
     */
    private $token;

    /**
     * Slack channel name
     * @var string
     */
    private $channel;

    /**
     * @param  string $slackTeam Slack team slug
     * @param  string $token     Slackbot token
     * @param  string $channel   Slack channel (encoded ID or name)
     * @param  int    $level     The minimum logging level at which this handler will be triggered
     * @param  bool   $bubble    Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($slackTeam, $token, $channel, $level = Logger::CRITICAL, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->slackTeam = $slackTeam;
        $this->token = $token;
        $this->channel = $channel;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     */
    protected function write(array $record)
    {
        $slackbotUrl = sprintf(
            'https://%s.slack.com/services/hooks/slackbot?token=%s&channel=%s',
            $this->slackTeam,
            $this->token,
            $this->channel
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $slackbotUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $record['message']);

        Curl\Util::execute($ch);
    }
}
