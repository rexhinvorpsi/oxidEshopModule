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
namespace AmazonPay;

/* Interface for IpnHandler.php */

interface IpnHandlerInterface
{   
    /* returnMessage() - JSON decode the raw [Message] portion of the IPN */
    
    public function returnMessage();

    /* toJson() - Converts IPN [Message] field to JSON
     *
     * Has child elements
     * ['NotificationData'] [XML] - API call XML notification data
     * @param remainingFields - consists of remaining IPN array fields that are merged
     * Type - Notification
     * MessageId -  ID of the Notification
     * Topic ARN - Topic of the IPN
     * @return response in JSON format
     */
    
    public function toJson();

    /* toArray() - Converts IPN [Message] field to associative array
     * @return response in array format
     */
    
    public function toArray();
}
