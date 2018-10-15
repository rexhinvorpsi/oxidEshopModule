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

/* ResponseParser
 * Methods provided to convert the Response from the POST to XML, Array or JSON
 */

require_once 'ResponseInterface.php';

class ResponseParser implements ResponseInterface
{
    public $response = null;
    
    public function __construct($response=null)
    {
        $this->response = $response;
    }
   
    /* Returns the XML portion of the response */
    
    public function toXml()
    {
        return $this->response['ResponseBody'];
    }
    
    /* toJson - converts XML into Json
     * @param $response [XML]
     */
    
    public function toJson()
    {
        $response = $this->simpleXmlObject();
        
        return (json_encode($response));
    }
    
    /* toArray - converts XML into associative array
     * @param $this->response [XML]
     */
    
    public function toArray()
    {
        $response = $this->simpleXmlObject();
        
        // Converting the SimpleXMLElement Object to array()
        $response = json_encode($response);
        
        return (json_decode($response, true));
    }
    
    private function simpleXmlObject()
    {
        $response = $this->response;
        
        // Getting the HttpResponse Status code to the output as a string
        $status = strval($response['Status']);
        
        // Getting the Simple XML element object of the XML Response Body
        $response = simplexml_load_string((string) $response['ResponseBody']);
        
        // Adding the HttpResponse Status code to the output as a string
        $response->addChild('ResponseStatus', $status);
        
        return $response;
    }
    
    /* Get the status of the Order Reference ID */
    
    public function getOrderReferenceDetailsStatus($response)
    {
       $oroStatus = $this->getStatus('GetORO', '//GetORO:OrderReferenceStatus', $response);
               
       return $oroStatus;
    }
    
    /* Get the status of the BillingAgreement */
    
    public function getBillingAgreementDetailsStatus($response)
    {
       $baStatus = $this->getStatus('GetBA', '//GetBA:BillingAgreementStatus', $response);  
       
       return $baStatus;
    }
    
    private function getStatus($type, $path, $response) 
    {
       $data= new \SimpleXMLElement($response);
       $namespaces = $data->getNamespaces(true);
       foreach($namespaces as $key=>$value){
           $namespace = $value;
       }
       $data->registerXPathNamespace($type, $namespace);
       foreach ($data->xpath($path) as $value) {
           $status = json_decode(json_encode((array)$value), TRUE);
       }
       
       return $status;
    }
}
