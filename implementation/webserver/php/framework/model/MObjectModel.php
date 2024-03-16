<?php
/**
 * @brief Universal model class for each editable object, that is used for storing objects between loads.
 */
class MObjectModel extends MModel {
    /**
     * @const urlPrefix
     * Used for generating url for this model.
     */
    const urlPrefix = 'object';
    /**
     * @var $id
     * Id of this model.
     */
    public $id;
    /**
     * @var $PageId
     * Id of page this model was created for. If not set yet, it is generated. It is shared between all forms on one page.
     * It is used for identifying 2 separate models of same type, that were created by separate page loads.
     */
    private static $PageId;

    /**
     * Constructs instance, sets id to default value.
     */
    public function __construct() {
        $this->id = 0;
    }

    /**
     * Generates accurate url to access the object, based on current state.
     * @return string Url that should be loaded next.
     */
    public function getUrl() {
        return "/".static::urlPrefix."/".($this->id ? $this->id."/edit" : "new");
    }

    /**
     * Checks if PageId of current page is set, if not, generates it using current time and url location.
     * @return string PageId
     */
    public static function getPageId() : string {
        if(!isset(static::$PageId)) static::$PageId=md5(microtime().'/'.$_SERVER['REMOTE_ADDR'].'/'.$_SERVER['REMOTE_PORT']);
        return static::$PageId;
    }

    /**
     * Sets current PageId.
     * @param string $pageId Id value to be set.
     * @return void
     */
    public static function setPageId(string $pageId) : void {
        static::$PageId = $pageId;
    }
}