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

/* Class HttpCurl
 * Handles Curl POST function for all requests
 */

require_once 'HttpCurlInterface.php';

class HttpCurl implements HttpCurlInterface
{
    private $config = array();
    private $header = false;
    private $accessToken = null;
    private $curlResponseInfo = null;
    private $headerArray = array ();

    /* Takes user configuration array as input
     * Takes configuration for API call or IPN config
     */

    public function __construct($config = null)
    {
        $this->config = $config;
    }

    /* Setter for boolean header to get the user info */

    public function setHttpHeader()
    {
        $this->header = true;
    }

    /* Setter for Access token to get the user info */

    public function setAccessToken($accesstoken)
    {
        $this->accessToken = $accesstoken;
    }

    /* Add the common Curl Parameters to the curl handler $ch
     * Also checks for optional parameters if provided in the config
     * config['cabundle_file']
     * config['proxy_port']
     * config['proxy_host']
     * config['proxy_username']
     * config['proxy_password']
     */

    private  function commonCurlParams($url,$userAgent)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!is_null($this->config['cabundle_file'])) {
            curl_setopt($ch, CURLOPT_CAINFO, $this->config['cabundle_file']);
        }

        if (!empty($userAgent))
            curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

        if ($this->config['proxy_host'] != null && $this->config['proxy_port'] != -1) {
            curl_setopt($ch, CURLOPT_PROXY, $this->config['proxy_host'] . ':' . $this->config['proxy_port']);
        }

        if ($this->config['proxy_username'] != null && $this->config['proxy_password'] != null) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->config['proxy_username'] . ':' . $this->config['proxy_password']);
        }

        return $ch;
    }

    /* POST using curl for the following situations
     * 1. API calls
     * 2. IPN certificate retrieval
     * 3. Get User Info
     */

    public function httpPost($url, $userAgent = null, $parameters = null)
    {
        $ch = $this->commonCurlParams($url,$userAgent);
      
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_HEADER, false);
        
        $response = $this->execute($ch);
        return $response;
    }

    /* GET using curl for the following situations
     * 1. IPN certificate retrieval
     * 2. Get User Info
     */

    public function httpGet($url, $userAgent = null)
    {
        $ch = $this->commonCurlParams($url,$userAgent);

        // Setting the HTTP header with the Access Token only for Getting user info
        if ($this->header) {
            $this->headerArray[] = 'Authorization: bearer ' . $this->accessToken;
        }

        $response = $this->execute($ch);
        return $response;
    }

    /* Execute Curl request */

    private function execute($ch)
    {
        $response = '';

        // Ensure we never send the "Expect: 100-continue" header
        $this->headerArray[] = 'Expect:';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headerArray);

        $response = curl_exec($ch);
        if ($response === false) {
            $error_msg = "Unable to post request, underlying exception of " . curl_error($ch);
            curl_close($ch);
            throw new \Exception($error_msg);
        } else {
            $this->curlResponseInfo = curl_getinfo($ch);
        }
        curl_close($ch);
        return $response;
    }

    /* Get the output of Curl Getinfo */

    public function getCurlResponseInfo()
    {
        return $this->curlResponseInfo;
    }
}
