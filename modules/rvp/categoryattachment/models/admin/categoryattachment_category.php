<?php
/**
 *
 * Class that extends oxcategory model class to add mediaURl functionality
 * @author Rexhin Vorpsi <rexhinvorpsi@yahoo.com>
 */
class categoryattachment_category extends categoryattachment_category_parent {
    public $_aMediaUrls = null;
    //function to retrieve all media url from category using oxid
    public function getMediaUrl($soxId){
        if ($this->_aMediaUrls === null) {
            $this->_aMediaUrls = oxNew("oxlist");
            $this->_aMediaUrls->init("oxmediaurl");
            $this->_aMediaUrls->getBaseObject()->setLanguage($this->getLanguage());

            $sViewName = getViewName("oxmediaurls", $this->getLanguage());
            $sQ = "select * from {$sViewName} where oxobjectid = '" . $soxId . "'";
            $this->_aMediaUrls->selectString($sQ);
        }

        return $this->_aMediaUrls;
    }
}