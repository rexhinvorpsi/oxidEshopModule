<?php
/**
 * Class that extends category_main controller in order to add Media Url functionality
 * @package
 * @author Rexhin Vorpsi <rexhinvorpsi@yahoo.com>
 */
class categoryattachment_category_main extends categoryattachment_category_main_parent
{
    public  $_aMediaUrls = null;

  public function render(){
        $render = parent::render();
        $soxId = $this->getEditObjectId();
        $oCategory = oxNew('oxcategory');
        $this->_aViewData['aMediaUrls'] = $oCategory->getMediaUrl($soxId);
        return $render;
    }
// Extending save funcition found in category_main controller
    public function save()
    {
        $return = parent::save();
        $soxId = $this->getEditObjectId();
        $this->saveMediaUrl($soxId);
        return $return;
    }

    //Extending function to update media
    public function updateMedia()
    {
        $aMediaUrls = $this->getConfig()->getRequestParameter('aMediaUrls');
        if (is_array($aMediaUrls)) {
            foreach ($aMediaUrls as $sMediaId => $aMediaParams) {
                $oMedia = oxNew("oxMediaUrl");
                if ($oMedia->load($sMediaId)) {
                    $oMedia->setLanguage(0);
                    $oMedia->assign($aMediaParams);
                    $oMedia->setLanguage($this->_iEditLang);
                    $oMedia->save();
                }
            }
        }
    }
    //Extending function to delete media
    public function deletemedia()
    {
        $soxId = $this->getEditObjectId();
        $sMediaId = $this->getConfig()->getRequestParameter("mediaid");
        if ($sMediaId && $soxId) {
            $oMediaUrl = oxNew("oxMediaUrl");
            $oMediaUrl->load($sMediaId);
            $oMediaUrl->delete();
        }
    }
//Save Media Url Function Grabbed from Article Extend
    private function saveMediaUrl($soxId)
    {
        $aMyFile = $this->getConfig()->getUploadedFile("myfile");
        $aMediaFile = $this->getConfig()->getUploadedFile("mediaFile");
        $sMediaUrl = $this->getConfig()->getRequestParameter("mediaUrl");
        $sMediaDesc = $this->getConfig()->getRequestParameter("mediaDesc");

        if (($sMediaUrl && $sMediaUrl != 'http://') || $aMediaFile['name'] || $sMediaDesc) {

            if (!$sMediaDesc) {
                return oxRegistry::get("oxUtilsView")->addErrorToDisplay('EXCEPTION_NODESCRIPTIONADDED');
            }

            if ((!$sMediaUrl || $sMediaUrl == 'http://') && !$aMediaFile['name']) {
                return oxRegistry::get("oxUtilsView")->addErrorToDisplay('EXCEPTION_NOMEDIAADDED');
            }

            $oMediaUrl = oxNew("oxMediaUrl");
            $oMediaUrl->setLanguage($this->_iEditLang);
            $oMediaUrl->oxmediaurls__oxisuploaded = new oxField(0, oxField::T_RAW);

            //handle uploaded file
            if ($aMediaFile['name']) {
                try {
                    $sMediaUrl = oxRegistry::get("oxUtilsFile")->processFile('mediaFile', 'out/media/');
                    $oMediaUrl->oxmediaurls__oxisuploaded = new oxField(1, oxField::T_RAW);
                } catch (Exception $e) {
                    return oxRegistry::get("oxUtilsView")->addErrorToDisplay($e->getMessage());
                }
            }

            //save media url
            $oMediaUrl->oxmediaurls__oxobjectid = new oxField($soxId, oxField::T_RAW);
            $oMediaUrl->oxmediaurls__oxurl = new oxField($sMediaUrl, oxField::T_RAW);
            $oMediaUrl->oxmediaurls__oxdesc = new oxField($sMediaDesc, oxField::T_RAW);
            $oMediaUrl->save();
        }
    }

}