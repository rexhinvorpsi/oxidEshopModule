<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2018
 * @version   OXID eShop CE
 */

/**
 * Metadata version
 */
$sMetadataVersion = '1.0';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'categoryattachment',
    'title'       => 'Category Attachment',
    'description' => 'Category Attachment on category main menu',
    'thumbnail'   => null,
    'version'     => '1.0',
    'author'      => 'Rexhin Vorpsi',
    'email'       => 'rexhinvorpsi@yahoo.com',
    'extend'      => array(
        'category_main' => 'rvp/categoryattachment/extension/controllers/admin/categoryattachment_category_main',
        'oxcategory' => 'rvp/categoryattachment/models/admin/categoryattachment_category'
    ),
    'files'       => array(
    ),
    'blocks'      => array(
        array(
            'template' => 'category_main.tpl',
            'block' => 'admin_category_main_form',
            'file' => 'views/admin/blocks/rvpcategory_main.tpl'
        ),
    ),
);
