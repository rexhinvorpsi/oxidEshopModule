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

/* Interface for HttpCurl.php */

interface HttpCurlInterface
{    
    /* Set Http header for Access token for the GetUserInfo call */
    
    public function setHttpHeader();
    
    /* Setter for  Access token to get the user info */
    
    public function setAccessToken($accesstoken);
    
    /* POST using curl for the following situations
     * 1. API calls
     * 2. IPN certificate retrieval
     * 3. Get User Info
     */
    
    public function httpPost($url, $userAgent = null, $parameters = null);
    
    /* GET using curl for the following situations
     * 1. IPN certificate retrieval
     * 3. Get User Info
     */
    
    public function httpGet($url, $userAgent = null);
}
