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

/* Class Regions
 * Defines all Region specific properties
 */

class Regions
{
    public $mwsServiceUrls = array('eu' => 'mws-eu.amazonservices.com',
				   'na' => 'mws.amazonservices.com',
				   'jp' => 'mws.amazonservices.jp');
    
    public $profileEndpointUrls = array('uk' => 'amazon.co.uk',
					'us' => 'amazon.com',
					'de' => 'amazon.de',
					'jp' => 'amazon.co.jp');
    
    public $regionMappings = array('de' => 'eu',
				   'uk' => 'eu',
				   'us' => 'na',
				   'jp' => 'jp');
}
