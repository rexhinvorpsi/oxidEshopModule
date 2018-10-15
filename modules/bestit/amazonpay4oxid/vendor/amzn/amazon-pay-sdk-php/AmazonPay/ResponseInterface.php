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

/* Interface for ResponseParser.php */

interface ResponseInterface
{   
    /* Returns the XML portion of the response */
    
    public function toXml();
    
    /* toJson  - converts XML into Json
     * @param $response [XML]
     */
    
    public function toJson();
    
    /* toArray  - converts XML into associative array
     * @param $this->_response [XML]
     */
    
    public function toArray();
    
    /* Get the status of the BillingAgreement */
    
    public function getBillingAgreementDetailsStatus($response);

    /* Get the status of the OrderReference */
    
    public function getOrderReferenceDetailsStatus($response);
}
