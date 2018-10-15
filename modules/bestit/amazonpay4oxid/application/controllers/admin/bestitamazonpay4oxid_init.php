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

/**
 * Class bestitAmazonPay4Oxid_init
 */
class bestitAmazonPay4Oxid_init
{
    const TMP_DB_ID = 'module:bestitAmazonPay4Oxid_tmp';
    const OLD_MODULE_ID = 'jagamazonpayment4oxid';

    /**
     * @var null|oxConfig
     */
    protected static $_oConfig = null;

    /**
     * @var null|oxDb
     */
    protected static $_oDatabase = null;

    /**
     * @var null|oxUtilsView
     */
    protected static $_oUtilsView = null;

    /**
     * @var null|oxModule
     */
    protected static $_oModule = null;

    /**
     * @var null|oxModuleCache
     */
    protected static $_oModuleCache = null;

    /**
     * @var null|oxModuleInstaller
     */
    protected static $_oModuleInstaller = null;

    /**
     * @var null|oxDbMetaDataHandler
     */
    protected static $_oDbMetaDataHandler = null;

    /**
     * @return oxConfig
     */
    protected static function _getConfig()
    {
        if (self::$_oConfig === null) {
            self::$_oConfig = oxRegistry::getConfig();
        }

        return self::$_oConfig;
    }

    /**
     * @return DatabaseInterface
     */
    protected static function _getDatabase()
    {
        if (self::$_oDatabase === null) {
            self::$_oDatabase = oxDb::getDb();
        }

        return self::$_oDatabase;
    }

    /**
     * @return oxUtilsView
     */
    protected static function _getUtilsView()
    {
        if (self::$_oUtilsView === null) {
            self::$_oUtilsView = oxRegistry::get('oxUtilsView');
        }

        return self::$_oUtilsView;
    }

    /**
     * @return oxModule
     */
    protected static function _getModule()
    {
        if (self::$_oModule === null) {
            self::$_oModule = oxRegistry::get('oxModule');
        }

        return self::$_oModule;
    }

    /**
     * @param oxModule $oModule
     *
     * @return oxModuleCache
     */
    protected static function _getModuleCache(oxModule $oModule)
    {
        if (self::$_oModuleCache === null) {
            self::$_oModuleCache = oxNew('oxModuleCache', $oModule);
        }

        return self::$_oModuleCache;
    }

    /**
     * @param oxModuleCache $oModuleCache
     *
     * @return oxModuleInstaller
     */
    protected static function _getModuleInstaller(oxModuleCache $oModuleCache)
    {
        if (self::$_oModuleInstaller === null) {
            self::$_oModuleInstaller = oxNew('oxModuleInstaller', $oModuleCache);
        }

        return self::$_oModuleInstaller;
    }

    /**
     * @return oxDbMetaDataHandler
     */
    protected static function _getDbMetaDataHandler()
    {
        if (self::$_oDbMetaDataHandler === null) {
            self::$_oDbMetaDataHandler = oxRegistry::get('oxDbMetaDataHandler');
        }

        return self::$_oDbMetaDataHandler;
    }

    /**
     * Deactivates the old module.
     *
     * @return bool
     */
    protected static function _deactivateOldModule()
    {
        $sModule = self::OLD_MODULE_ID;

        /**
         * @var oxModule $oModule
         */
        $oModule = self::_getModule();

        if ($oModule->load($sModule) === false) {
            self::_getUtilsView()->addErrorToDisplay(new oxException('EXCEPTION_MODULE_NOT_LOADED'));
            return false;
        }

        try {
            $oModuleCache = self::_getModuleCache($oModule);
            $oModuleInstaller = self::_getModuleInstaller($oModuleCache);
            return $oModuleInstaller->deactivate($oModule);
        } catch (oxException $oEx) {
            self::_getUtilsView()->addErrorToDisplay($oEx);
            $oEx->debugOut();
        }

        return false;
    }

    /**
     * Removes the temporary version number of the module from the database.
     */
    protected static function _removeTempVersionNumberFromDatabase()
    {
        $oConfig = self::_getConfig();
        $sModuleId = self::_getDatabase()->quote(self::TMP_DB_ID);
        $sQuotedShopId = self::_getDatabase()->quote($oConfig->getShopId());

        $sDeleteSql = "DELETE
                FROM `oxconfig`
                WHERE oxmodule = {$sModuleId}
                  AND oxshopid = {$sQuotedShopId}";

        self::_getDatabase()->execute($sDeleteSql);
    }

    /**
     * Executes a sql file.
     *
     * @param string $sFile
     *
     * @return bool
     */
    protected static function _executeSqlFile($sFile)
    {
        $blSuccess = false;
        $sFileWithPath = dirname(__FILE__) . '/../../../_db/' . $sFile;

        if (file_exists($sFileWithPath)) {
            $sSqlFile = file_get_contents($sFileWithPath);
            $aSqlRows = explode(';', $sSqlFile);
            $aSqlRows = array_map('trim', $aSqlRows);

            foreach ($aSqlRows as $sSqlRow) {
                if ($sSqlRow !== '') {
                    self::_getDatabase()->execute($sSqlRow);
                }
            }

            $blSuccess = true;
        }

        return $blSuccess;
    }

    /**
     * Execute required sql statements.
     */
    public static function onActivate()
    {
        $sSql = "SELECT COUNT(OXID)
            FROM oxpayments
            WHERE OXID IN ('jagamazon', 'bestitamazon')";

        //Insert payment records to DB
        $iRes = self::_getDatabase()->getOne($sSql);

        if ($iRes !== false && (int)$iRes === 0) {
            self::_executeSqlFile('install.sql');

            //Update Views
            $oDbHandler = self::_getDbMetaDataHandler();
            $oDbHandler->updateViews();
        }

        $sPaymentTable = getViewName('oxpayments');
        $sSql = "UPDATE {$sPaymentTable} SET OXACTIVE = 1 
            WHERE OXID = 'bestitamazon'";

        //Make payment active
        self::_getDatabase()->execute($sSql);

        $oConfig = self::_getConfig();
        $sUpdateFrom = $oConfig->getShopConfVar('sUpdateFrom', null, self::TMP_DB_ID);

        if ($sUpdateFrom !== null) {
            $blRemoveTempVersionNumber = version_compare($sUpdateFrom, '2.2.2', '<')
                && self::_executeSqlFile('update_2.2.2.sql');

            if (version_compare($sUpdateFrom, '2.4.0', '<')
                && self::_executeSqlFile('update_2.4.0.sql')
            ) {
                $blRemoveTempVersionNumber = true;
                self::_deactivateOldModule();
            }

            if ($blRemoveTempVersionNumber === true) {
                self::_removeTempVersionNumberFromDatabase();
            }
        }

        self::clearTmp();
    }

    /**
     * Disable amazon pay on deactivation.
     */
    public static function onDeactivate()
    {
        $sPaymentTable = getViewName('oxpayments');
        $sSql = "UPDATE {$sPaymentTable} SET OXACTIVE = 0
            WHERE OXID = 'bestitamazon'";

        //Make payment inactive
        self::_getDatabase()->execute($sSql);
    }

    /**
     * Returns the current installed version.
     *
     * @return null|string
     */
    public static function getCurrentVersion()
    {
        $aVersions = (array)self::_getConfig()->getConfigParam('aModuleVersions');

        $aPossibleModuleNames = array(
            'jagAmazonPayment4Oxid',
            'bestitAmazonPay4Oxid'
        );

        foreach ($aPossibleModuleNames as $sPossibleModuleName) {
            if ($aVersions[$sPossibleModuleName]) {
                return $aVersions[$sPossibleModuleName];
            } elseif ($aVersions[strtolower($sPossibleModuleName)]) {
                return $aVersions[strtolower($sPossibleModuleName)];
            }
        }

        return null;
    }

    /**
     * Flags the module for the update action.
     */
    public static function flagForUpdate()
    {
        self::_getConfig()->saveShopConfVar('str', 'sUpdateFrom', self::getCurrentVersion(), null, self::TMP_DB_ID);
    }

    /**
     * Glob that is safe with streams (vfs for example)
     *
     * @param string $sDirectory
     * @param string $sFilePattern
     *
     * @return array
     */
    protected static function _streamSafeGlob($sDirectory, $sFilePattern)
    {
        $sDirectory = rtrim($sDirectory, '/');
        $aFiles = scandir($sDirectory);
        $aFound = array();

        foreach ($aFiles as $sFilename) {
            if (fnmatch($sFilePattern, $sFilename)) {
                $aFound[] = $sDirectory . '/' . $sFilename;
            }
        }

        return $aFound;
    }

    /**
     * Clear tmp dir and smarty cache.
     *
     * @return void
     */
    public static function clearTmp()
    {
        $sTmpDir = self::_getConfig()->getConfigParam('sCompileDir');
        $sTmpDir = rtrim($sTmpDir, '/').'/';
        $sSmartyDir = $sTmpDir.'smarty/';

        foreach (self::_streamSafeGlob($sTmpDir, '*.txt') as $sFileName) {
            unlink($sFileName);
        }

        foreach (self::_streamSafeGlob($sSmartyDir, '*.php') as $sFileName) {
            unlink($sFileName);
        }
    }
}
